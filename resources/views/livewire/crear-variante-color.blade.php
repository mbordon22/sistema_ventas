<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    {{-- Solo Color --}}
    <form method="POST" wire:submit.prevent="crearVarianteColor">

        {{-- Filas de Color y Stock --}}
        @foreach($colores as $key => $color)
        <h3 class="font-bold text-lg">Variante {{$key}}</h3>
            <div class="py-4 my-4 border-b-2 border-b-white">
                <div class="mt-4 grid grid-cols-5 gap-4 items-center">
                    <!-- Colores -->
                    <div class="col-span-2">
                        <x-input-label :value="__('Color')" />
                        <x-text-input id="color-{{ $key }}" class="block mt-1 w-full" type="text" wire:model="colores.{{ $key }}" />
                        <x-input-error :messages="$errors->get('colores')" class="mt-2" />
                    </div>
    
                    <!-- Stock -->
                    <div class="col-span-2">
                        <x-input-label :value="__('Stock')" />
                        <x-text-input class="block mt-1 w-full" type="number" min="0" wire:model="stock.{{ $key }}"/>
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>
    
                    <div class="col-span-1">
                        @if($key > 0)
                            <button type="button" class="text-red-600 hover:underline" onclick='quitarColor({{$key}})'>Eliminar</button>
                        @endif
                    </div>
                </div>
    
                <!-- Imagenes -->
                <div class="my-4 py-4">
                    <x-input-label for="imagenes" :value="__('Imagenes Producto')" />
                    <input 
                        id="imagen-{{ $key }}" 
                        type="file" 
                        class="mt-1 block w-full" 
                        wire:model="imagenes.{{ $key }}"
                        accept="image/*"
                        multiple
                    />
                
                    <div class="my-5 w-80">
                        @if($imagenes[$key])
                            Imagenes:
                            <div class="flex items-center gap-3">
                                @foreach ($imagenes[$key] as $imagen)  
                                    {{-- @foreach ($imagenes_key as $imagen) --}}
                                        <div>
                                            <img 
                                                src="{{$imagen->temporaryURL()}}" 
                                                alt=""
                                                width="200px"
                                            >
                                            {{-- <button type="button" wire:click="eliminarImagen({{$key}}, '{{$imagen->getFilename()}}')">Eliminar</button> --}}
                                        </div>
                                    {{-- @endforeach --}}
                                @endforeach
                            </div>
                        @endif
                    </div>
                
                    <x-input-error :messages="$errors->get('imagenes.{{$key}}')" class="mt-2" />
                </div>
            </div>
        @endforeach

        <div>
            <button type="button" class="text-blue-600 hover:underline" wire:click='$dispatch("agregarColor")'>+ Agregar Color</button>
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
        function quitarColor(key)
        {
            Swal.fire({
                title: 'Eliminar Color?',
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
                    Livewire.dispatch('eliminarColor', {key: key}); 
                    Swal.fire(
                    'Eliminado!',
                    'El color fue eliminado.',
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