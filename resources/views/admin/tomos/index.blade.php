<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tomos del archivo físico') }}
            </h2>

            <a href="{{ route('admin.tomos.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + Nuevo tomo
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

            {{-- Filtros --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" class="grid gap-4 md:grid-cols-4 items-end">
                    <div class="md:col-span-2">
                        <x-input-label for="area_id" value="Área" />
                        <select id="area_id" name="area_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— Todas las áreas —</option>
                            @foreach ($areas as $area)
                            <option value="{{ $area->id }}"
                                @selected($areaId==$area->id)>
                                {{ $area->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="year" value="Año" />
                        <x-text-input id="year" name="year" type="number" class="mt-1 block w-full"
                            value="{{ $year }}" />
                    </div>

                    <div>
                        <x-input-label for="search" value="Buscar" />
                        <div class="flex gap-2">
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full"
                                placeholder="Descripción, desde, hasta..."
                                value="{{ $search }}" />
                            <x-primary-button class="mt-1">
                                Filtrar
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tabla tipo Excel --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs md:text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Área</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Item</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Descripción</th>
                                <th class="px-3 py-2 text-center font-semibold text-gray-600 uppercase">Año</th>
                                <th class="px-3 py-2 text-center font-semibold text-gray-600 uppercase">Tomo</th>
                                <th class="px-3 py-2 text-center font-semibold text-gray-600 uppercase">Folios</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Desde</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-600 uppercase">Hasta</th>
                                <th class="px-3 py-2 text-center font-semibold text-gray-600 uppercase">N° Andamio</th>
                                <th class="px-3 py-2 text-center font-semibold text-gray-600 uppercase">N° Fila</th>
                                <th class="px-3 py-2 text-right font-semibold text-gray-600 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($tomos as $tomo)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-700 whitespace-nowrap">
                                    {{ $tomo->area->name }}
                                </td>
                                <td class="px-3 py-2 text-gray-700 text-center">
                                    {{ $tomo->item }}
                                </td>
                                <td class="px-3 py-2 text-gray-800">
                                    {{ $tomo->description }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    {{ $tomo->year }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    {{ $tomo->tome_number }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    {{ $tomo->folios }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ Str::limit($tomo->from_ref, 60) }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ Str::limit($tomo->to_ref, 60) }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    {{ $tomo->shelf_number }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    {{ $tomo->shelf_row }}
                                </td>
                                <td class="px-3 py-2 text-center space-x-2 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-3">

                                        <a href="{{ route('admin.tomos.show', $tomo) }}"
                                            class="text-indigo-600 hover:text-indigo-800"
                                            title="Ver documentos">
                                            {{-- Heroicon: Eye --}}
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.5"
                                                class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('admin.tomos.edit', $tomo) }}"
                                            class="text-yellow-500 hover:text-yellow-600"
                                            title="Editar tomo">
                                            {{-- Heroicon: Pencil Square --}}
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.5"
                                                class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487 19.5 7.125M4.5 19.5l3.75-.938L19.5 7.125 16.875 4.5 7.125 14.25 6.187 18z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5.25 5.25h5.25" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.tomos.destroy', $tomo) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este tomo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800"
                                                title="Eliminar tomo">
                                                {{-- Heroicon: Trash --}}
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.75 9.75v6.75M14.25 9.75v6.75M4.5 6.75h15M9 4.5h6l-.75 2.25H9.75L9 4.5zM6.75 6.75l.75 12h9l.75-12" />
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="px-3 py-4 text-center text-gray-500">
                                    No se encontraron tomos con los filtros aplicados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 bg-gray-50">
                    {{ $tomos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>