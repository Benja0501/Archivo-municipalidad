<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nueva área del archivo') }}
            </h2>
            <a href="{{ route('admin.areas.index') }}"
               class="text-sm text-indigo-600 hover:text-indigo-800">
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.areas.store') }}">
                    @include('admin.areas._form', ['area' => null])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
