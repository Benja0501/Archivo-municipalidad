@csrf

<div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <x-input-label for="name" value="Nombre" />
            <x-text-input id="name" name="name" type="text"
                          class="mt-1 block w-full"
                          value="{{ old('name', $user->name ?? '') }}" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" name="email" type="email"
                          class="mt-1 block w-full"
                          value="{{ old('email', $user->email ?? '') }}" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
    </div>

    <div class="max-w-md">
        <x-input-label for="password" value="Contraseña" />
        <x-text-input id="password" name="password" type="password"
                      class="mt-1 block w-full"
                      @if (!isset($user)) required @endif />
        <p class="text-xs text-gray-500 mt-1">
            @isset($user)
                Déjelo en blanco si no desea cambiar la contraseña.
            @else
                Mínimo 8 caracteres.
            @endisset
        </p>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="roles" value="Roles asignados" />
        <div class="mt-2 grid gap-2 md:grid-cols-3">
            @foreach ($roles as $role)
                <label class="inline-flex items-center text-sm text-gray-700">
                    <input type="checkbox" name="roles[]"
                           value="{{ $role->name }}"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                           @if (isset($user) && $user->roles->pluck('name')->contains($role->name)) checked @endif>
                    <span class="ml-2">{{ ucfirst($role->name) }}</span>
                </label>
            @endforeach
        </div>
        <x-input-error :messages="$errors->get('roles')" class="mt-2" />
    </div>
</div>

<div class="mt-8 flex items-center justify-end gap-x-3">
    <a href="{{ route('admin.users.index') }}"
       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold
              text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
        Cancelar
    </a>

    <x-primary-button>
        Guardar
    </x-primary-button>
</div>
