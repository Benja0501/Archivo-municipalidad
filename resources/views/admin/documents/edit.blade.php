<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar documento') }}
            </h2>
            <a href="{{ route('admin.documents.index') }}"
                class="text-sm text-indigo-600 hover:text-indigo-800">
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.documents.update', $document) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @include('admin.documents._form')
                </form>
                {{-- Bloque de archivos del documento (fuera del form principal) --}}
                @if($document->files && $document->files->count())
                <div class="mt-6 bg-white shadow-sm rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-2">Archivos actuales:</p>

                    <ul class="mt-1 space-y-1 text-xs">
                        @foreach($document->files as $file)
                        <li class="flex items-center justify-between gap-2">
                            <a href="{{ asset('storage/'.$file->path) }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-800">
                                {{ $file->original_name ?? basename($file->path) }}
                            </a>

                            <form method="POST"
                                action="{{ route('admin.documents.files.destroy', [$document, $file]) }}"
                                onsubmit="return confirm('¿Seguro que deseas eliminar este archivo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    Eliminar
                                </button>
                            </form>
                        </li>
                        @endforeach
                    </ul>

                    {{-- Un solo botón para eliminar TODOS los archivos --}}
                    <form method="POST"
                        action="{{ route('admin.documents.files.destroyAll', $document) }}"
                        onsubmit="return confirm('¿Seguro que deseas eliminar TODOS los archivos de este documento?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="mt-3 text-xs text-red-600 hover:text-red-800">
                            Eliminar todos los archivos
                        </button>
                    </form>
                </div>

                @elseif($document->pdf_path)
                {{-- Soporte para un único archivo del esquema anterior --}}
                <div class="mt-6 bg-white shadow-sm rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-2">
                        Archivo único registrado con el esquema anterior:
                    </p>
                    <a href="{{ asset('storage/'.$document->pdf_path) }}" target="_blank"
                        class="text-xs text-indigo-600 hover:text-indigo-800">
                        Ver archivo actual
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>