<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de usuarios') }}
            </h2>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                      transition ease-in-out duration-150">
                
                <!-- Icono añadido -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nuevo usuario
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <!-- Alerta con icono -->
                <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-md text-sm" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Filtros / búsqueda --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div class="flex-1">
                        <x-input-label for="search" value="Buscar" class="mb-1" />
                        <div class="flex gap-2">
                            <x-text-input id="search" name="search" type="text" class="w-full"
                                          placeholder="Nombre o correo"
                                          value="{{ $search }}" />
                            
                            <!-- Botón "Buscar" estilizado para ser consistente -->
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                                           font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700
                                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                           transition ease-in-out duration-150">
                                Buscar
                            </button>
                        </div>
                    </div>

                    <div class="text-sm text-gray-500 md:text-right">
                        <span class="font-semibold">{{ $users->total() }}</span> usuario(s) encontrados
                    </div>
                </form>
            </div>

            {{-- Tabla --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- Cabeceras de tabla refinadas -->
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nombre</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Correo</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Roles</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-500">{{ $user->id }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        @forelse ($user->roles as $role)
                                            <!-- "Pills" de Rol refinadas -->
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs
                                                       font-medium bg-indigo-100 text-indigo-800 mr-1 mb-1">
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400 italic">Sin rol</span>
                                        @endforelse
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-4">
                                        <!-- Acciones con iconos -->
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-xs font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"
                                                    class="inline-flex items-center text-red-600 hover:text-red-800 text-xs font-semibold">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 mr-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.54 0c-.275-.036-.55-.068-.828-.098m13.368 0A48.108 48.108 0 0012 5.4c-2.67 0-5.197.3-7.607.828" />
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500 text-sm">
                                        <!-- Estado vacío mejorado -->
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-4.682 2.72a3 3 0 01-4.682-2.72m-4.682 2.72a5.963 5.963 0 01-2.186-.81m2.186.81a5.963 5.963 0 00-2.186-.81m0 0a5.963 5.963 0 012.186-.81M6.082 15.23a5.963 5.963 0 012.186-.81m0 0H8.25m6.5 0h2.168a5.963 5.963 0 002.186-.81m-2.186.81a5.963 5.963 0 01-2.186-.81M14.75 15.23a5.963 5.963 0 002.186-.81m0 0a5.963 5.963 0 012.186-.81m0 0H16.5m-9.75 0h2.168a5.963 5.963 0 002.186-.81M6.082 15.23a5.963 5.963 0 012.186-.81m0 0H8.25m6.5 0h2.168m-9.75 0H8.25m0 0a3.001 3.001 0 003.75 0m0 0a3.001 3.001 0 003.75 0m0 0h1.5m-1.5 0a3.001 3.001 0 003.75 0m0 0a3.001 3.001 0 003.75 0m-9.75 0a3.001 3.001 0 003.75 0" />
                                            </svg>
                                            <span class="font-medium">No hay usuarios registrados.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>