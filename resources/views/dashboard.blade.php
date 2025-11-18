<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel principal') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Bienvenida --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Bienvenido al sistema de Archivo Municipal.
                </h3>
                <p class="text-sm text-gray-600">
                    Desde aquí puedes acceder rápidamente a las funciones según tus permisos.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">

                {{-- Acceso al panel admin (solo para super-admin) --}}
                @role('super-admin')
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col">
                    <h4 class="text-base font-semibold text-gray-800 mb-1">
                        Administración del archivo
                    </h4>
                    <p class="text-sm text-gray-600 mb-4 flex-1">
                        Gestión completa de usuarios, áreas, series documentales, tomos
                        y documentos digitalizados.
                    </p>
                    <div class="flex justify-end">
                        <a href="{{ route('admin.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                      rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                      hover:bg-indigo-700">
                            Ir al panel administrativo
                        </a>
                    </div>
                </div>
                @endrole

                {{-- Consulta de documentos --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col">
                    <h4 class="text-base font-semibold text-gray-800 mb-1">
                        Consulta de documentos
                    </h4>
                    <p class="text-sm text-gray-600 mb-4 flex-1">
                        Buscar resoluciones, acuerdos y otros documentos por número,
                        tomo, área o año.
                    </p>
                    <div class="flex justify-end">
                        <a href="{{ route('admin.documents.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent
                  rounded-md font-semibold text-xs text-white uppercase tracking-widest
                  hover:bg-gray-800">
                            Ver / buscar documentos
                        </a>
                    </div>
                </div>


                {{-- Atajo a tomos --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col">
                    <h4 class="text-base font-semibold text-gray-800 mb-1">
                        Tomos del archivo físico
                    </h4>
                    <p class="text-sm text-gray-600 mb-4 flex-1">
                        Consultar la ubicación física de los tomos y el rango de documentos
                        que contiene cada uno.
                    </p>
                    <div class="flex justify-end">
                        <a href="{{ route('admin.tomos.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300
                                  rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest
                                  hover:bg-gray-200">
                            Ver tomos
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>