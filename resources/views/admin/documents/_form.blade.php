@csrf
@php $isEdit = isset($document); @endphp

<div class="space-y-6">

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <x-input-label for="tomo_id" value="Tomo" />
            <select id="tomo_id" name="tomo_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required>
                <option value="">— Seleccione un tomo —</option>
                @foreach ($tomos as $tomo)
                    <option value="{{ $tomo->id }}"
                        @selected(old('tomo_id', $document->tomo_id ?? null) == $tomo->id)>
                        {{ $tomo->area->name }} — {{ $tomo->description }} ({{ $tomo->year }}) [Tomo {{ $tomo->tome_number }}]
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('tomo_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="document_series_id" value="Serie documental (opcional)" />
            <select id="document_series_id" name="document_series_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">— Sin serie —</option>
                @foreach ($series as $s)
                    <option value="{{ $s->id }}"
                        @selected(old('document_series_id', $document->document_series_id ?? null) == $s->id)>
                        {{ $s->code }} — {{ $s->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('document_series_id')" class="mt-2" />
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="md:col-span-2">
            <x-input-label for="number" value="Número del documento" />
            <x-text-input id="number" name="number" type="text" class="mt-1 block w-full"
                          placeholder="Ej: Resolución de Alcaldía N° 231-2010-MDG/A"
                          value="{{ old('number', $document->number ?? '') }}" required />
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="date" value="Fecha" />
            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full"
                          value="{{ old('date', isset($document->date) ? $document->date->format('Y-m-d') : '') }}" />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="summary" value="Asunto / descripción" />
        <textarea id="summary" name="summary" rows="3"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Resumen breve del contenido">{{ old('summary', $document->summary ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('summary')" class="mt-2" />
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <x-input-label for="pages" value="N° de folios internos (hojas)" />
            <x-text-input id="pages" name="pages" type="number" min="1" class="mt-1 block w-full"
                          value="{{ old('pages', $document->pages ?? '') }}" />
            <p class="text-xs text-gray-500 mt-1">
                Cantidad de hojas físicas del documento. No afecta el conteo de folios del tomo.
            </p>
            <x-input-error :messages="$errors->get('pages')" class="mt-2" />
        </div>

        <div>
            <x-input-label value="Folio en el tomo" />
            @if($isEdit)
                <x-text-input type="number" class="mt-1 block w-full bg-gray-100"
                              value="{{ $document->folio_number }}" disabled />
            @else
                <p class="mt-2 text-sm text-gray-500">
                    Se asignará automáticamente al guardar.
                </p>
            @endif
        </div>

        <div>
            <x-input-label for="pdf" value="Archivo digital (opcional)" />
            <input id="pdf" name="pdf" type="file"
                   class="mt-1 block w-full text-sm text-gray-700"
                   accept=".pdf,.jpg,.jpeg,.png" />
            @if($isEdit && $document->pdf_path)
                <a href="{{ asset('storage/'.$document->pdf_path) }}" target="_blank"
                   class="text-xs text-indigo-600 hover:text-indigo-800 mt-1 inline-block">
                    Ver archivo actual
                </a>
            @endif
            <x-input-error :messages="$errors->get('pdf')" class="mt-2" />
        </div>
    </div>
</div>

<div class="mt-8 flex items-center justify-end gap-x-3">
    <a href="{{ route('admin.documents.index') }}"
       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold
              text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
        Cancelar
    </a>

    <x-primary-button>
        Guardar
    </x-primary-button>
</div>
