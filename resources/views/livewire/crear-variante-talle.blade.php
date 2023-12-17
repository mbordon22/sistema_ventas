<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    {{-- Solo Talle --}}
    <form method="POST" wire:submit.prevent="crearVarianteTalle">

        {{-- Filas de Talle y Stock --}}
        @foreach($talles as $key => $talle)
        <h3 class="font-bold text-lg mt-4 p-2 bg-gray-400">Variante {{$key+1}}</h3>
            <div class="mt-4 grid grid-cols-5 gap-4 items-center">
                <!-- Talle -->
                <div class="col-span-2">
                    <x-input-label :value="__('Talle')" />
                    <x-text-input id="talle-{{ $key }}" class="block mt-1 w-full" type="text" wire:model="talles.{{ $key }}" />
                    <x-input-error :messages="$errors->get('talles')" class="mt-2" />
                </div>

                <!-- Stock -->
                <div class="col-span-2">
                    <x-input-label :value="__('Stock')" />
                    <x-text-input class="block mt-1 w-full" type="number" min="0" wire:model="stock.{{ $key }}"/>
                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                </div>

                <div class="col-span-1">
                    @if($key > 0)
                        <button type="button" class="text-red-600 hover:underline" onclick='quitarTalle({{$key}})'>Eliminar</button>
                    @endif
                </div>
            </div>
        @endforeach

        <div>
            <button type="button" class="text-blue-600 hover:underline" wire:click='$dispatch("agregarTalle")'>+ Agregar Talle</button>
        </div>

        <!-- Imagenes -->
        <div class="my-4 py-4 border-y-2 border-y-white">
            <x-input-label for="imagenes" :value="__('Imagenes Producto')" />
            <input 
                id="imagenes" 
                type="file" 
                class="mt-1 block w-full" 
                wire:model="imagenes"
                accept="image/*"
                multiple
            />

            <div class="my-5 w-80">
                @if($imagenes)
                    Imagenes:
                    <div class="flex items-center gap-3">
                        @foreach ($imagenes as $imagen)    
                        <img 
                            src="{{$imagen->temporaryURL()}}" 
                            alt=""
                            width="200px"
                        >
                        @endforeach
                    </div>
                @endif
            </div>

            <x-input-error :messages="$errors->get('imagenes')" class="mt-2" />
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
        function quitarTalle(key)
        {
            Swal.fire({
                title: 'Eliminar Talle?',
                text: "Esta acción no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(key)
                    Livewire.dispatch('eliminarTalle', {key: key}); 
                    Swal.fire(
                    'Eliminado!',
                    'El talle fue eliminado.',
                    'success'
                    )
                }
            })
        }

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
            title: 'Variante/s creada/s con exito'
            })
        })
    </script>
@endpush