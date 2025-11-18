<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar tomo') }}
            </h2>
            <a href="{{ route('admin.tomos.index') }}"
               class="text-sm text-indigo-600 hover:text-indigo-800">
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">
                    {{ $tomo->area->name }} — {{ $tomo->description }} ({{ $tomo->year }})
                </h3>

                <form method="POST" action="{{ route('admin.tomos.update', $tomo) }}">
                    @method('PUT')
                    @include('admin.tomos._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
