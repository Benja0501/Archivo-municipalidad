<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nuevo usuario') }}
            </h2>
            <a href="{{ route('admin.users.index') }}"
               class="text-sm text-indigo-600 hover:text-indigo-800">
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">
                    Datos del usuario
                </h3>

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @include('admin.users._form', ['user' => null])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
