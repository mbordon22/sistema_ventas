<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    {{-- Formulario de Variante con Color y Talles --}}
    <form method="POST" wire:submit.prevent="crearVarianteConColorYTalles">
        @php
            $contador = 1;
        @endphp
        @foreach($colores as $key_colores => $color)
            <div class="flex justify-between items-center gap-x-2">
                <h3 class="flex-1 font-bold text-lg mt-4 p-2 bg-gray-400">Variante {{$contador}}</h3>
                <div class="col-span-1">
                    @if($key_colores > 0)
                        <button type="button" class="text-red-600 hover:underline" onclick='quitarColor({{$key_colores}})'>Eliminar</button>
                    @endif
                </div>
            </div>
            <div class="my-4 py-4 border-b-2 border-b-white">

                {{-- Selección de Color --}}
                <div class="mt-4 grid grid-cols-5 gap-4 items-center">
                    <!-- Color -->
                    <div class="col-span-4">
                        <x-input-label :value="__('Color')" />
                        <x-text-input id="color-{{$key_colores}}" class="block mt-1 w-full" type="text" wire:model="colores.{{$key_colores}}" />
                        <x-input-error :messages="$errors->get('colorres')" class="mt-2" />
                    </div>
                </div>

                <!-- Campos de Talle y Stock -->
                @foreach($talles[$key_colores] as $key_talles => $talle)
                    <div class="mt-4 grid grid-cols-5 gap-4 items-center color-container">
                        <!-- Talle -->
                        <div class="col-span-2">
                            <x-input-label :value="__('Talle')" />
                            <x-text-input id="talle-{{ $key_colores }}-{{$key_talles}}" class="block mt-1 w-full" type="text" wire:model="talles.{{ $key_colores }}.{{$key_talles}}" />
                            <x-input-error :messages="$errors->get('talles')" class="mt-2" />
                        </div>

                        <!-- Stock -->
                        <div class="col-span-2">
                            <x-input-label :value="__('Stock')" />
                            <x-text-input class="block mt-1 w-full" type="number" min="0" wire:model="stock.{{ $key_colores }}.{{$key_talles}}"/>
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>

                        <div class="col-span-1">
                            @if($key_talles > 0)
                                <button type="button" class="text-red-600 hover:underline" onclick='quitarTalle({{$key_colores}},{{$key_talles}})'>Eliminar</button>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Botón para Agregar Talle -->
                <div>
                    <button type="button" class="text-blue-600 hover:underline" wire:click='$dispatch("agregarTalle", {key_color: {{$key_colores}}})'>+ Agregar Talle</button>
                </div>

                <!-- Imagenes -->
                <div class="my-4 py-4">
                    <x-input-label for="imagenes" :value="__('Imagenes Producto')" />
                    <input 
                        id="imagen-{{ $key_colores }}" 
                        type="file" 
                        class="mt-1 block w-full" 
                        wire:model="imagenes.{{ $key_colores }}"
                        accept="image/*"
                        multiple
                    />

                    <div class="my-5 w-80">
                        @if($imagenes[$key_colores])
                            Imagenes:
                            <div class="flex items-center gap-3">
                                @foreach ($imagenes[$key_colores] as $imagen)    
                                <img 
                                    src="{{$imagen->temporaryURL()}}" 
                                    alt=""
                                    width="200px"
                                >
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <x-input-error :messages="$errors->get('imagenes.{{$key_colores}}')" class="mt-2" />
                </div>
            </div>
            @php
                $contador++;
            @endphp
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
        function quitarTalle(key_color, key_talle)
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
                    // console.log(key)
                    Livewire.dispatch('eliminarTalle', {key_color: key_color, key_talle: key_talle}); 
                    Swal.fire(
                    'Eliminado!',
                    'El talle fue eliminado.',
                    'success'
                    )
                }
            })
        }

        function quitarColor(key_color)
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
                    // console.log(key)
                    Livewire.dispatch('eliminarColor', {key_color: key_color}); 
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
                title: 'Variante/s creada/s con éxito'
            })
        })
    </script>
@endpush
