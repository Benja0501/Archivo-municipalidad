<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tomo del archivo físico
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Cabecera del tomo --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    {{ $tomo->area->name }} — {{ $tomo->description }} ({{ $tomo->year }})
                    — Tomo {{ $tomo->tome_number }}
                </h3>

                <dl class="mt-2 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm text-gray-700">
                    <div>
                        <dt class="font-medium text-gray-500">Folios</dt>
                        <dd>{{ $tomo->folios ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Desde</dt>
                        <dd>{{ $tomo->from_ref ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Hasta</dt>
                        <dd>{{ $tomo->to_ref ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Ubicación</dt>
                        <dd>N° andamio {{ $tomo->shelf_number ?? '—' }},
                            fila {{ $tomo->row_number ?? '—' }}</dd>
                    </div>
                </dl>

                <div class="mt-4">
                    <a href="{{ route('admin.tomos.index') }}"
                       class="text-sm text-indigo-600 hover:text-indigo-800">
                        ← Volver a la lista de tomos
                    </a>
                </div>
            </div>

            {{-- Filtro de documentos --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="{{ route('admin.tomos.show', $tomo) }}"
                      class="flex flex-col md:flex-row gap-3 md:items-center">
                    <div class="flex-1">
                        <x-input-label for="search" value="Buscar en documentos" />
                        <x-text-input id="search" name="search" type="text"
                                      class="mt-1 block w-full"
                                      placeholder="Número, asunto, etc."
                                      value="{{ $search }}" />
                    </div>

                    <div class="mt-2 md:mt-6">
                        <x-primary-button>Filtrar</x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Tabla de documentos del tomo --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Documentos de este tomo
                </h3>

                @if($documents->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-700">Folio</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-700">N° documento</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-700">Fecha</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-700">Asunto</th>
                                    <th class="px-3 py-2 text-center font-medium text-gray-700">Hojas</th>
                                    <th class="px-3 py-2 text-center font-medium text-gray-700">Archivo</th>
                                    <th class="px-3 py-2 text-center font-medium text-gray-700">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($documents as $doc)
                                    <tr>
                                        <td class="px-3 py-2">{{ $doc->folio_number }}</td>
                                        <td class="px-3 py-2">{{ $doc->number }}</td>
                                        <td class="px-3 py-2">
                                            {{ $doc->date ? $doc->date->format('d/m/Y') : '—' }}
                                        </td>
                                        <td class="px-3 py-2">{{ $doc->summary }}</td>
                                        <td class="px-3 py-2 text-center">
                                            {{ $doc->pages ?? '—' }}
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            @php
                                                $filesCount = $doc->files_count ?? $doc->files->count();
                                            @endphp

                                            @if($filesCount > 0)
                                                <span class="text-xs text-gray-600">
                                                    {{ $filesCount }} archivo{{ $filesCount > 1 ? 's' : '' }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">Sin archivo</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <a href="{{ route('admin.documents.edit', $doc) }}"
                                               class="text-indigo-600 hover:text-indigo-800 text-xs">
                                                Editar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $documents->links() }}
                    </div>
                @else
                    <p class="text-sm text-gray-500">
                        Este tomo aún no tiene documentos registrados.
                    </p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
