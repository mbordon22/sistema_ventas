<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    <form method="POST" wire:submit.prevent="crearAlmacen">

        <div class="grid grid-cols-2 gap-4">
            <!-- Nombre -->
            <div class="col-span-1">
                <x-input-label for="nombre" :value="__('Nombre')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" wire:model="nombre" :value="old('nombre')" required autofocus />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>
    
            <!-- Telefono -->
            <div class="col-span-1">
                <x-input-label for="telefono" :value="__('Telefono')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="text" wire:model="telefono" :value="old('telefono')" required />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-4">
            <!-- Contacto Nombre -->
            <div class="col-span-1">
                <x-input-label for="contacto_nombre" :value="__('Contacto Nombre')" />
                <x-text-input id="contacto_nombre" class="block mt-1 w-full" type="text" wire:model="contacto_nombre" :value="old('contacto_nombre')" required />
                <x-input-error :messages="$errors->get('contacto_nombre')" class="mt-2" />
            </div>

            <!-- Contacto Mail -->
            <div class="col-span-1">
                <x-input-label for="contacto_email" :value="__('Contacto Email')" />
                <x-text-input id="contacto_email" class="block mt-1 w-full" type="email" wire:model="contacto_email" :value="old('contacto_email')" required />
                <x-input-error :messages="$errors->get('contacto_email')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-4">
            <!-- Ubicacion -->
            <div class="col-span-1">
                <x-input-label for="ubicacion" :value="__('Dirección')" />
                <x-text-input id="ubicacion" class="block mt-1 w-full" type="text" wire:model="ubicacion" :value="old('ubicacion')" required />
                <x-input-error :messages="$errors->get('ubicacion')" class="mt-2" />
            </div>

            <!-- Tipo -->
            <div class="col-span-1">
                <x-input-label for="tipo" :value="__('Tipo')" />
                <select wire:model="tipo" id="tipo" :value="old('tipo')" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">--Seleccionar--</option>
                    <option value="Local">Local</option>
                    <option value="Almacén central">Almacén central</option>
                    <option value="Sucursal">Sucursal</option>
                    <option value="Otros">Otros</option>
                </select>
                <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
            </div>
        </div>

        <!-- Descripcion -->
        <div class="mt-4">
            <x-input-label for="descripcion" :value="__('Descripción')" />
            <textarea wire:model="descripcion" id="descripcion" cols="30" rows="10" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{old('ubicacion')}}</textarea>
            <x-input-error :messages="$errors->get('ubicacion')" class="mt-2" />
        </div>

        

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Crear') }}
            </x-primary-button>
        </div>
    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('notificacionCreado', (event) => {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            icon: 'success',
            title: 'Almacen creado con exito'
            })
        })
    </script>
@endpush