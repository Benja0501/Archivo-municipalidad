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
                                    @selected($areaId == $area->id)>
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
                                    <td class="px-3 py-2 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('admin.tomos.edit', $tomo) }}"
                                           class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.tomos.destroy', $tomo) }}" method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('¿Eliminar este tomo?')"
                                                class="text-red-600 hover:text-red-800 font-semibold">
                                                Eliminar
                                            </button>
                                        </form>
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
