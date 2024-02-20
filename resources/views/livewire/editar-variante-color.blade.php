<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    {{-- Solo Color --}}
    <form method="POST" wire:submit.prevent="editarVarianteColor">

        {{-- Filas de Color y Stock --}}
        @foreach($colores as $key => $color)
            <h3 class="font-bold text-lg p-2 bg-gray-400">Variante {{$key+1}}</h3>
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
                
                    <div class="my-5 w-full">
                        Imagenes:
                        <div class="flex flex-wrap items-center gap-3">
                            @if(isset($imagenes_cargadas[$key]))
                                @foreach ($imagenes_cargadas[$key] as $key_imagen => $imagen_c)
                                    <div class="relative">
                                        <img 
                                            src="{{ asset('storage/productos/' . $imagen_c) }}" 
                                            alt=""
                                            width="200px"
                                            onclick="mostrarImagenModal('{{ asset('storage/productos/' . $imagen_c) }}')"
                                        >
                                        <button 
                                            onclick="eliminarImagen('{{ $key }}', '{{$key_imagen}}', 'cargada')" 
                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center -mt-1 -mr-1 hover:bg-red-600 focus:outline-none"
                                            type="button"
                                        >
                                            <span class="sr-only">Eliminar</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                            @if(isset($imagenes_nuevas[$key]))
                                {{-- Imagenes Nuevas --}}
                                @foreach ($imagenes_nuevas[$key] as $key_imagen => $imagen)    
                                <div class="relative">
                                    <img 
                                        src="{{$imagen->temporaryURL()}}"  
                                        alt=""
                                        width="200px"
                                        onclick="mostrarImagenModal('{{$imagen->temporaryURL()}}')"
                                    >
                                    <button 
                                        onclick="eliminarImagen('{{ $key }}','{{$key_imagen}}', 'nueva')" 
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center -mt-1 -mr-1 hover:bg-red-600 focus:outline-none"
                                        type="button"
                                    >
                                        <span class="sr-only">Eliminar</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                        </div>
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

    <!-- Modal -->
    <div id="modal" onclick="cerrarImagenModal()" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 flex items-center justify-center">
        <!-- Contenido del modal -->
        <div class="bg-white p-8 rounded-lg max-w-md">
            <!-- Botón para cerrar el modal -->
            <button class="absolute top-0 right-0 m-4 text-gray-200 hover:text-gray-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Imagen en el modal -->
            <img id="imagenModal" src="" alt="Imagen" class="w-full">
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function quitarColor(key){
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

        function eliminarImagen(key, keyImagen, tipo){
            Swal.fire({
                title: 'Eliminar Imagen?',
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
                    Livewire.dispatch('eliminarImagen', {key: key, keyImagen: keyImagen, tipo: tipo}); 
                    Swal.fire(
                    'Eliminado!',
                    'La imagen fue eliminada.',
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

        Livewire.on('notificacionImagen', (event) => {
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
            icon: 'warning',
            title: 'Una o mas variantes no tienen imagenes cargadas'
            })
        })

        function mostrarImagenModal(rutaImagen){
            // Obtiene referencias a los elementos HTML
            const modal = document.getElementById('modal');
            const imagenModal = document.getElementById('imagenModal');

            // Obtiene la ruta de la imagen y la asigna al src de la imagen en el modal
            imagenModal.setAttribute('src', rutaImagen);

            // Muestra el modal
            modal.classList.remove('hidden');

        }

        function cerrarImagenModal() {
            // Oculta el modal
            document.getElementById('modal').classList.add('hidden');
        };
    </script>
@endpush