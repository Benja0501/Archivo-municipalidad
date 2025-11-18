{{-- resources/views/admin/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Administrativo - Archivo Municipal') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Mensaje de bienvenida --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Bienvenido, Administrador General.
                </h3>
                <p class="text-sm text-gray-600">
                    Desde este panel puedes administrar usuarios, áreas, series documentales,
                    tomos físicos y documentos digitalizados del Archivo Municipal.
                </p>
            </div>

            {{-- Tarjetas principales --}}
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3 items-stretch">

                {{-- Gestión de usuarios --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col">
                    <h4 class="text-base font-semibold text-gray-800 mb-1">
                        Gestión de usuarios
                    </h4>
                    <p class="text-sm text-gray-600 mb-4 flex-1">
                        Crear, editar y asignar roles y permisos a los usuarios del sistema
                        (super-admin, archivista, consulta, etc.).
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                     bg-indigo-50 text-indigo-700 font-medium">
                            Seguridad y accesos
                        </span>
                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent
                                  rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                  hover:bg-indigo-700">
                            Ir a usuarios
                        </a>
                    </div>
                </div>

                {{-- Series documentales --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col">
                    <h4 class="text-base font-semibold text-gray-800 mb-1">
                        Series documentales
                    </h4>
                    <p class="text-sm text-gray-600 mb-4 flex-1">
                        Definir la estructura archivística (series y subseries) para clasificar
                        resoluciones, decretos, expedientes, etc.
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                     bg-emerald-50 text-emerald-700 font-medium">
                            Clasificación archivística
                        </span>
                        <a href="{{ route('admin.series.index') }}"
                           class="inline-flex items-center px-3 py-1.5 bg-emerald-600 border border-transparent
                                  rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                  hover:bg-emerald-700">
                            Ver series
                        </a>
                    </div>
                </div>

                {{-- Áreas del archivo --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col">
                    <h4 class="text-base font-semibold text-gray-800 mb-1">
                        Áreas del archivo
                    </h4>
                    <p class="text-sm text-gray-600 mb-4 flex-1">
                        Mantener el listado de áreas productoras de documentos:
                        Secretaría General, RRHH, Gerencias, etc.
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                     bg-amber-50 text-amber-700 font-medium">
                            Organización institucional
                        </span>
                        <a href="{{ route('admin.areas.index') }}"
                           class="inline-flex items-center px-3 py-1.5 bg-amber-500 border border-transparent
                                  rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                  hover:bg-amber-600">
                            Ver áreas
                        </a>
                    </div>
                </div>

                {{-- Tomos del archivo físico --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-base font-semibold text-gray-800">
                            Tomos del archivo físico
                        </h4>
                        <a href="{{ route('admin.tomos.create') }}"
                           class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent
                                  rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                  hover:bg-indigo-700">
                            + Nuevo tomo
                        </a>
                    </div>

                    <p class="text-sm text-gray-600 mb-4 flex-1">
                        Registrar los tomos físicos: descripción, año, número de tomo,
                        rango de documentos (&laquo;desde / hasta&raquo;), cantidad de documentos
                        y ubicación física (andamio y fila).
                    </p>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.tomos.index') }}"
                           class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md
                                  text-xs font-semibold text-gray-700 uppercase tracking-widest
                                  hover:bg-gray-50">
                            Ver todos los tomos
                        </a>

                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                     bg-gray-100 text-gray-700">
                            Consulta rápida de ubicación física
                        </span>
                    </div>
                </div>

                {{-- Documentos digitalizados (fila completa) --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col md:col-span-2 xl:col-span-3">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-base font-semibold text-gray-800">
                            Documentos digitalizados
                        </h4>
                        <a href="{{ route('admin.documents.create') }}"
                           class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent
                                  rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                  hover:bg-indigo-700">
                            + Nuevo documento
                        </a>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">
                        Registrar resoluciones, acuerdos, convenios u otros documentos dentro de un tomo,
                        asignándoles número, fecha, asunto, folio dentro del tomo y archivo digital (PDF o imagen).
                        El sistema actualiza automáticamente el rango &laquo;desde / hasta&raquo; y el conteo de
                        documentos de cada tomo.
                    </p>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.documents.index') }}"
                           class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md
                                  text-xs font-semibold text-gray-700 uppercase tracking-widest
                                  hover:bg-gray-50">
                            Ver todos los documentos
                        </a>

                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                     bg-gray-100 text-gray-700">
                            Búsqueda por área, tomo, serie y número
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                     bg-gray-100 text-gray-700">
                            Soporta archivos PDF / imagen
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
