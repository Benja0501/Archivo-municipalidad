<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Series documentales') }}
            </h2>

            <a href="{{ route('admin.series.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + Nueva serie
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
                <form method="GET" class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div class="flex-1">
                        <x-input-label for="search" value="Buscar" class="mb-1" />
                        <div class="flex gap-2">
                            <x-text-input id="search" name="search" type="text" class="w-full"
                                          placeholder="Código o nombre de serie"
                                          value="{{ $search }}" />
                            <x-primary-button>Buscar</x-primary-button>
                        </div>
                    </div>

                    <div class="text-sm text-gray-500 md:text-right">
                        <span class="font-semibold">{{ $series->total() }}</span> serie(s) registradas
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Código</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Serie padre</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Estado</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($series as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 font-mono text-xs text-gray-700">{{ $item->code }}</td>
                                    <td class="px-4 py-2 font-medium text-gray-800">{{ $item->name }}</td>
                                    <td class="px-4 py-2 text-gray-700">
                                        @if ($item->parent)
                                            {{ $item->parent->code }} — {{ $item->parent->name }}
                                        @else
                                            <span class="text-xs text-gray-400 italic">Nivel superior</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($item->active)
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">
                                                Activa
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-gray-200 text-gray-700">
                                                Inactiva
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-right space-x-3">
                                        <a href="{{ route('admin.series.edit', $item) }}"
                                           class="text-indigo-600 hover:text-indigo-800 text-xs font-semibold">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.series.destroy', $item) }}" method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Eliminar esta serie?')"
                                                    class="text-red-600 hover:text-red-800 text-xs font-semibold">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 text-sm">
                                        No hay series registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 bg-gray-50">
                    {{ $series->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
