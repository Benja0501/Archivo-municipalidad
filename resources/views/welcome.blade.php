<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Municipalidad Distrital de Guadalupe - Archivo Municipal</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white text-gray-900">
        <div class="min-h-screen flex flex-col">

            {{-- Barra superior tipo web institucional --}}
            <header class="w-full bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <img
                            src="https://www.muniguadalupe.gob.pe/web/images/logo.png"
                            alt="Municipalidad Distrital de Guadalupe"
                            class="h-12 w-auto"
                        >
                        <div class="leading-tight">
                            <p class="text-xs text-yellow-700 font-semibold uppercase tracking-[0.12em]">
                                GUADALUPE
                            </p>
                            <p class="text-sm text-gray-800 font-semibold">
                                Municipalidad Distrital
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Portada principal --}}
            <main class="flex-1">
                <section class="relative overflow-hidden">
                    {{-- Banner institucional como fondo --}}
                    <div class="absolute inset-0">
                        <img
                            src="https://www.muniguadalupe.gob.pe/web/images/banner/Portada_Principal_Mesa_de_trabajo_1_1.png"
                            alt="Municipalidad Distrital de Guadalupe"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-black/25"></div>
                    </div>

                    {{-- Contenido sobre el banner --}}
                    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 lg:py-20">
                        <div class="bg-white/95 rounded-2xl shadow-xl max-w-xl p-6 sm:p-8">
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">
                                Sistema de Archivo Municipal
                            </h1>
                            <p class="text-sm sm:text-base text-gray-700 mb-5">
                                Plataforma interna para la gestión del Archivo General de la
                                Municipalidad Distrital de Guadalupe: administración de tomos físicos,
                                documentos digitalizados y consulta archivística.
                            </p>

                            <ul class="text-sm text-gray-700 space-y-1 mb-6 list-disc list-inside">
                                <li>Control de tomos por área, año y ubicación física.</li>
                                <li>Registro y consulta de resoluciones, acuerdos y expedientes.</li>
                                <li>Acceso restringido mediante usuarios y roles.</li>
                            </ul>

                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('dashboard') }}"
                                       class="inline-flex items-center px-5 py-2.5 rounded-md bg-indigo-600
                                              text-sm font-semibold text-white hover:bg-indigo-700">
                                        Entrar al sistema
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="inline-flex items-center px-5 py-2.5 rounded-md bg-indigo-600
                                              text-sm font-semibold text-white hover:bg-indigo-700">
                                        Iniciar sesión
                                    </a>
                                @endauth
                            @endif
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
