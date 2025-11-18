<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $areas = Area::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.areas.index', compact('areas', 'search'));
    }

    public function create()
    {
        return view('admin.areas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string'],
            'active'      => ['nullable', 'boolean'],
        ]);

        $data['active'] = $request->boolean('active', true);

        Area::create($data);

        return redirect()
            ->route('admin.areas.index')
            ->with('status', 'Área creada correctamente.');
    }

    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string'],
            'active'      => ['nullable', 'boolean'],
        ]);

        $data['active'] = $request->boolean('active', true);

        $area->update($data);

        return redirect()
            ->route('admin.areas.index')
            ->with('status', 'Área actualizada correctamente.');
    }

    public function destroy(Area $area)
    {
        // Podrías validar si tiene tomos asociados antes de eliminar
        if ($area->tomos()->exists()) {
            return back()->with('status', 'No se puede eliminar un área que tiene tomos registrados.');
        }

        $area->delete();

        return redirect()
            ->route('admin.areas.index')
            ->with('status', 'Área eliminada correctamente.');
    }
}
