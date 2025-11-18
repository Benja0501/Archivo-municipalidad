<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentSeries;

class DocumentSeriesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $series = DocumentSeries::query()
            ->with('parent')
            ->when($search, function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            })
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('admin.series.index', compact('series', 'search'));
    }

    public function create()
    {
        $parents = DocumentSeries::orderBy('code')->get();

        return view('admin.series.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'        => ['required', 'string', 'max:20', 'unique:document_series,code'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id'   => ['nullable', 'exists:document_series,id'],
            'active'      => ['nullable', 'boolean'],
        ]);

        $data['active'] = $request->boolean('active', true);

        DocumentSeries::create($data);

        return redirect()
            ->route('admin.series.index')
            ->with('status', 'Serie documental creada correctamente.');
    }

    public function edit(DocumentSeries $series)
    {
        $parents = DocumentSeries::where('id', '!=', $series->id)
            ->orderBy('code')
            ->get();

        return view('admin.series.edit', compact('series', 'parents'));
    }

    public function update(Request $request, DocumentSeries $series)
    {
        $data = $request->validate([
            'code'        => ['required', 'string', 'max:20', "unique:document_series,code,{$series->id}"],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id'   => ['nullable', 'exists:document_series,id'],
            'active'      => ['nullable', 'boolean'],
        ]);

        $data['active'] = $request->boolean('active', true);

        $series->update($data);

        return redirect()
            ->route('admin.series.index')
            ->with('status', 'Serie documental actualizada correctamente.');
    }

    public function destroy(DocumentSeries $series)
    {
        if ($series->children()->exists()) {
            return back()->with('status', 'No se puede eliminar una serie que tiene subseries asociadas.');
        }

        $series->delete();

        return redirect()
            ->route('admin.series.index')
            ->with('status', 'Serie documental eliminada correctamente.');
    }
}
