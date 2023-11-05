<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    <h3 class="py-2 border-b-2 border-b-white text-center font-bold text-lg">Modificar Subcategoria</h3>
    <form method="POST" wire:submit.prevent="editarSubcategoria">

        <div class="grid grid-cols-2 gap-4 py-5">
            <!-- Nombre -->
            <div class="col-span-2">
                <x-input-label for="nombre" :value="__('Nombre Subcategoria')" />
                <x-text-input class="block mt-1 w-full" wire:model="nombre" required />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 pb-5">
            <!-- Color -->
            <div class="col-span-2">
                {{-- <div class="flex items-center gap-4"> --}}
                <div class="w-full grid grid-cols-4 items-center gap-4">
                    <x-input-label class="col-span-3" :value="__('¿Esta subcategoría necesita que especifiquemos color?')" />
                    <div class="col-span-1">
                        <input type="checkbox" id="color" wire:model="color" {{$color ? 'checked' : ''}}>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('color')" class="mt-2" />
            </div>
    
            <!-- Talle -->
            <div class="col-span-2">
                <div class="w-full grid grid-cols-4 items-center gap-4">
                    <x-input-label class="col-span-3" :value="__('¿Esta subcategoría necesita que especifiquemos talle? ')" />
                    <div class="col-span-1">
                        <input type="checkbox" id="talle" wire:model="talle" {{$talle ? 'checked' : ''}}>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('talle')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Modificar') }}
            </x-primary-button>
        </div>
    </form>
</div>