<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    <form method="POST" wire:submit.prevent="crearMarca">

        <!-- Nombre Marca -->
        <div>
            <x-input-label for="nombre_marca" :value="__('Nombre Marca')" />
            <x-text-input id="nombre_marca" class="block mt-1 w-full" type="text" wire:model="nombre_marca" :value="old('nombre_marca')" required />
            <x-input-error :messages="$errors->get('nombre_marca')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Crear') }}
            </x-primary-button>
        </div>
    </form>
</div>