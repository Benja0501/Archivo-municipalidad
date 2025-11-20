<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tomo;
use App\Models\Area;
use App\Models\DocumentSeries;

class TomoController extends Controller
{
    public function index(Request $request)
    {
        $areas  = Area::orderBy('name')->get();
        $areaId = $request->input('area_id');
        $year   = $request->input('year');
        $search = $request->input('search');

        $tomos = Tomo::with('area', 'series')
            ->when($areaId, fn($q) => $q->where('area_id', $areaId))
            ->when($year, fn($q) => $q->where('year', $year))
            ->when($search, function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('from_ref', 'like', "%{$search}%")
                    ->orWhere('to_ref', 'like', "%{$search}%");
            })
            ->orderBy('area_id')
            ->orderBy('year')
            ->orderBy('item')
            ->paginate(30)
            ->withQueryString();

        return view('admin.tomos.index', compact('tomos', 'areas', 'areaId', 'year', 'search'));
    }

    public function create()
    {
        $areas  = Area::orderBy('name')->get();
        $series = DocumentSeries::orderBy('code')->get();

        return view('admin.tomos.create', compact('areas', 'series'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'area_id'            => ['required', 'exists:areas,id'],
            'document_series_id' => ['nullable', 'exists:document_series,id'],
            'year'               => ['required', 'integer'],
            'tome_number'        => ['required', 'integer'],
            'description'        => ['required', 'string', 'max:255'],
            'shelf_number'       => ['required', 'integer'],
            'shelf_row'          => ['required', 'integer'],
            'active'             => ['nullable', 'boolean'],
        ]);

        // correlativo de item por área (puedes cambiar la lógica si lo quieres global)
        $nextItem = (Tomo::where('area_id', $data['area_id'])->max('item') ?? 0) + 1;

        $data['item']   = $nextItem;
        $data['folios'] = 0;          // se actualizará cuando registremos documentos
        $data['from_ref'] = null;     // se llenará con el primer documento
        $data['to_ref']   = null;     // se llenará con el último documento
        $data['active']   = $request->boolean('active', true);

        Tomo::create($data);

        return redirect()
            ->route('admin.tomos.index')
            ->with('status', 'Tomo creado correctamente.');
    }

    public function edit(Tomo $tomo)
    {
        $areas  = Area::orderBy('name')->get();
        $series = DocumentSeries::orderBy('code')->get();

        return view('admin.tomos.edit', compact('tomo', 'areas', 'series'));
    }

    public function update(Request $request, Tomo $tomo)
    {
        $data = $request->validate([
            'area_id'            => ['required', 'exists:areas,id'],
            'document_series_id' => ['nullable', 'exists:document_series,id'],
            'year'               => ['required', 'integer'],
            'tome_number'        => ['required', 'integer'],
            'description'        => ['required', 'string', 'max:255'],
            'shelf_number'       => ['required', 'integer'],
            'shelf_row'          => ['required', 'integer'],
            'active'             => ['nullable', 'boolean'],
        ]);

        $data['active'] = $request->boolean('active', true);

        $tomo->update($data);

        return redirect()
            ->route('admin.tomos.index')
            ->with('status', 'Tomo actualizado correctamente.');
    }


    public function destroy(Tomo $tomo)
    {
        $tomo->delete();

        return redirect()->route('admin.tomos.index')
            ->with('status', 'Tomo eliminado correctamente.');
    }

    // Ver detalles de un tomo y sus documentos
    public function show(Tomo $tomo, Request $request)
    {
        $search = $request->input('search');

        // Carga de documentos del tomo con su serie
        $documents = $tomo->documents()
            ->with('series')
            ->when($search, function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            })
            ->orderBy('folio_number')
            ->paginate(25)
            ->withQueryString();

        return view('admin.tomos.show', compact('tomo', 'documents', 'search'));
    }
}
