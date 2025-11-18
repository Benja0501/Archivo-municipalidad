@csrf

<div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-3">
        <div class="md:col-span-2">
            <x-input-label for="name" value="Nombre del área" />
            <x-text-input id="name" name="name" type="text"
                          class="mt-1 block w-full"
                          placeholder="Ej: Secretaría General, RRHH"
                          value="{{ old('name', $area->name ?? '') }}" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="code" value="Código" />
            <x-text-input id="code" name="code" type="text"
                          class="mt-1 block w-full"
                          placeholder="Ej: SG, RRHH"
                          value="{{ old('code', $area->code ?? '') }}" />
            <p class="text-xs text-gray-500 mt-1">Opcional, útil para reportes o etiquetas.</p>
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="description" value="Descripción" />
        <textarea id="description" name="description" rows="3"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Ej: Área que tramita resoluciones de alcaldía, acuerdos de consejo, etc.">{{ old('description', $area->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="flex items-center">
        <input id="active" name="active" type="checkbox" value="1"
               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
               @checked(old('active', $area->active ?? true))>
        <label for="active" class="ml-2 text-sm text-gray-700">
            Área activa
        </label>
    </div>
</div>

<div class="mt-8 flex items-center justify-end gap-x-3">
    <a href="{{ route('admin.areas.index') }}"
       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold
              text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
        Cancelar
    </a>

    <x-primary-button>
        Guardar
    </x-primary-button>
</div>
