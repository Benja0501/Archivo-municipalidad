<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Documentos del archivo') }}
            </h2>
            <a href="{{ route('admin.documents.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + Nuevo documento
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md text-sm">
                {{ session('status') }}
            </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" class="grid gap-4 md:grid-cols-3 items-end">
                    <div>
                        <x-input-label for="tomo_id" value="Tomo" />
                        <select id="tomo_id" name="tomo_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— Todos los tomos —</option>
                            @foreach ($tomos as $tomo)
                            <option value="{{ $tomo->id }}"
                                @selected($tomoId==$tomo->id)>
                                {{ $tomo->area->name }} — {{ $tomo->description }} ({{ $tomo->year }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="search" value="Buscar" />
                        <div class="flex gap-2">
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full"
                                placeholder="Número, asunto..."
                                value="{{ $search }}" />
                            <x-primary-button class="mt-1">
                                Filtrar
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs md:text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Área / Tomo</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Folio</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">N° documento</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Fecha</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Asunto</th>
                                <th class="px-3 py-2 text-center font-semibold text-gray-600 uppercase">Hojas</th>
                                <th class="px-3 py-2 text-center font-semibold text-gray-600 uppercase">Archivo</th>
                                <th class="px-3 py-2 text-right font-semibold text-gray-600 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($documents as $doc)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2">
                                    <div class="text-gray-800 font-medium">
                                        {{ $doc->tomo->area->name }}
                                    </div>
                                    <div class="text-gray-600 text-xs">
                                        {{ $doc->tomo->description }} ({{ $doc->tomo->year }})
                                        — Tomo {{ $doc->tomo->tome_number }}
                                    </div>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    {{ $doc->folio_number }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $doc->number }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $doc->date ? $doc->date->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ \Illuminate\Support\Str::limit($doc->summary, 60) }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    {{ $doc->pages ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @php
                                    // $doc viene del foreach ($documents as $doc)
                                    $filesCount = $doc->files_count ?? $doc->files->count();
                                    $firstFile = $doc->files->first();
                                    @endphp

                                    @if ($filesCount > 0 && $firstFile)
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-700">
                                            {{ $filesCount }} archivo{{ $filesCount > 1 ? 's' : '' }}
                                        </span>

                                        <a href="{{ asset('storage/'.$firstFile->path) }}"
                                            target="_blank"
                                            class="text-xs text-indigo-600 hover:text-indigo-800">
                                            Ver primero
                                        </a>
                                    </div>
                                    @else
                                    <span class="text-xs text-gray-400">Sin archivo</span>
                                    @endif
                                </td>

                                <td class="px-3 py-2 text-right space-x-2">
                                    <a href="{{ route('admin.documents.edit', $doc) }}"
                                        class="text-indigo-600 hover:text-indigo-800 text-xs font-semibold">
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Eliminar este documento?')"
                                            class="text-red-600 hover:text-red-800 text-xs font-semibold">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-3 py-4 text-center text-gray-500">
                                    No se encontraron documentos.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 bg-gray-50">
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>