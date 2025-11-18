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
            </div>
        </div>
    </div>
</x-app-layout>
