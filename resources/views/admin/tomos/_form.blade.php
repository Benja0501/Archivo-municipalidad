@php
    $isEdit = isset($tomo) && $tomo;
@endphp

@csrf

<div class="space-y-6">

    {{-- Área + Año --}}
    <div class="grid gap-4 md:grid-cols-3">
        <div class="md:col-span-2">
            <x-input-label for="area_id" value="Área" />
            <select id="area_id" name="area_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required>
                <option value="">— Seleccione un área —</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}"
                        @selected(old('area_id', $tomo->area_id ?? null) == $area->id)>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('area_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="year" value="Año" />
            <x-text-input id="year" name="year" type="number" class="mt-1 block w-full"
                          value="{{ old('year', $tomo->year ?? date('Y')) }}" required />
            <x-input-error :messages="$errors->get('year')" class="mt-2" />
        </div>
    </div>

    {{-- Serie documental (opcional) --}}
    <div>
        <x-input-label for="document_series_id" value="Serie documental (opcional)" />
        <select id="document_series_id" name="document_series_id"
            class="mt1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">— Sin serie asociada —</option>
            @foreach ($series as $s)
                <option value="{{ $s->id }}"
                    @selected(old('document_series_id', $tomo->document_series_id ?? null) == $s->id)>
                    {{ $s->code }} — {{ $s->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('document_series_id')" class="mt-2" />
    </div>

    {{-- N° de tomo --}}
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <x-input-label for="tome_number" value="N° de tomo" />
            <x-text-input id="tome_number" name="tome_number" type="number"
                          class="mt-1 block w-full"
                          value="{{ old('tome_number', $tomo->tome_number ?? 1) }}" required />
            <x-input-error :messages="$errors->get('tome_number')" class="mt-2" />
        </div>

        {{-- Item (solo lectura en edición) --}}
        <div>
            <x-input-label value="Item" />
            @if($isEdit)
                <x-text-input type="number" class="mt-1 block w-full bg-gray-100"
                              value="{{ $tomo->item }}" disabled />
                <p class="text-xs text-gray-500 mt-1">Correlativo generado automáticamente.</p>
            @else
                <p class="mt-2 text-sm text-gray-500">
                    El item se asignará automáticamente al guardar el tomo.
                </p>
            @endif
        </div>

        {{-- Folios (solo lectura) --}}
        <div>
            <x-input-label value="Folios" />
            @if($isEdit)
                <x-text-input type="number" class="mt-1 block w-full bg-gray-100"
                              value="{{ $tomo->folios }}" disabled />
                <p class="text-xs text-gray-500 mt-1">
                    Cantidad de documentos asociados a este tomo.
                </p>
            @else
                <p class="mt-2 text-sm text-gray-500">
                    Se calculará automáticamente según los documentos registrados en el tomo.
                </p>
            @endif
        </div>
    </div>

    {{-- Descripción del tomo --}}
    <div>
        <x-input-label for="description" value="Descripción del tomo" />
        <x-text-input id="description" name="description" type="text"
                      class="mt-1 block w-full"
                      placeholder="Ej: RESOLUCIONES DE ALCALDÍA MAYO"
                      value="{{ old('description', $tomo->description ?? '') }}" required />
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    {{-- Desde / Hasta (solo lectura) --}}
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <x-input-label value="Desde (primer documento)" />
            @if($isEdit)
                <textarea rows="2" class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100"
                          disabled>{{ $tomo->from_ref }}</textarea>
            @else
                <p class="mt-2 text-sm text-gray-500">
                    Se rellenará automáticamente con el primer documento registrado en este tomo.
                </p>
            @endif
        </div>

        <div>
            <x-input-label value="Hasta (último documento)" />
            @if($isEdit)
                <textarea rows="2" class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100"
                          disabled>{{ $tomo->to_ref }}</textarea>
            @else
                <p class="mt-2 text-sm text-gray-500">
                    Se actualizará automáticamente con el último documento registrado en este tomo.
                </p>
            @endif
        </div>
    </div>

    {{-- Ubicación física --}}
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <x-input-label for="shelf_number" value="N° de andamio" />
            <x-text-input id="shelf_number" name="shelf_number" type="number"
                          class="mt-1 block w-full"
                          value="{{ old('shelf_number', $tomo->shelf_number ?? 1) }}" required />
            <x-input-error :messages="$errors->get('shelf_number')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shelf_row" value="N° de fila" />
            <x-text-input id="shelf_row" name="shelf_row" type="number"
                          class="mt-1 block w-full"
                          value="{{ old('shelf_row', $tomo->shelf_row ?? 1) }}" required />
            <x-input-error :messages="$errors->get('shelf_row')" class="mt-2" />
        </div>
    </div>

    {{-- Estado --}}
    <div class="flex items-center">
        <input id="active" name="active" type="checkbox" value="1"
               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
               @checked(old('active', $tomo->active ?? true))>
        <label for="active" class="ml-2 text-sm text-gray-700">
            Tomo activo
        </label>
    </div>
</div>

<div class="mt-8 flex items-center justify-end gap-x-3">
    <a href="{{ route('admin.tomos.index') }}"
       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold
              text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
        Cancelar
    </a>

    <x-primary-button>
        Guardar
    </x-primary-button>
</div>
