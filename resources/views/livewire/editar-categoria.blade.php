<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    <form method="POST" wire:submit.prevent="editarCategoria">

        <div class="grid grid-cols-2 gap-4 pb-5 border-b-2 border-b-white">
            <!-- Nombre -->
            <div class="col-span-1">
                <x-input-label for="nombre" :value="__('Nombre Categoria')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" wire:change="$dispatch('generarSlug')" wire:model="nombre" required autofocus />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>
    
            <!-- Slug -->
            <div class="col-span-1">
                <x-input-label for="slug" :value="__('Slug')" />
                <x-text-input id="slug" class="block mt-1 w-full" type="text" wire:model="slug" value="{{$slug}}" readonly/>
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>
        </div>

        {{-- Marcas --}}
        <div class="py-5 border-b-2 border-b-white">
            <x-input-label for="marcas" :value="__('Marcas')" />
            <div class="grid grid-cols-4 gap-4 mt-5">
                @foreach ($marcas as $marca)    
                    <div class="col-span-1">
                        {{$marca->nombre_marca}}
                        <input type="checkbox" wire:model="marcas_array" value="{{$marca->id}}">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-5">
            <!-- imagen -->
            <div class="col-span-2 mt-4">
                <x-input-label for="nueva_imagen" :value="__('Imagen Categoria')" />
                <input 
                    id="nueva_imagen" 
                    type="file" 
                    class="mt-1 block w-full" 
                    wire:model="nueva_imagen"
                    accept="image/*"
                />

                <div class="grid grid-cols-2 gap-4">
                    {{-- imagen actual --}}
                    <div class="grid-span-1 my-5 w-80">
                        @if($imagen != '')
                            <p>Imagen Actual:</p>
                            <img 
                                src="{{asset('storage/categorias/'. $imagen )}}" 
                                alt=""
                            >
                        @else
                            Sin Imagen Cargada
                        @endif
                    </div>
    
                    {{-- Funcionalidad de livewire para poder previsualizar imagen antes de subirla, la variable toma el mismo nombre del wire:model --}}
                    <div class="grid-span-1 my-5 w-80">
                        @if($nueva_imagen)
                            <p>Imagen Nueva:</p>
                            <img 
                                src="{{$nueva_imagen->temporaryURL()}}" 
                                alt=""
                            >
                        @endif
                    </div>
                </div>

                <x-input-error :messages="$errors->get('nueva_imagen')" class="mt-2" />
            </div>
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Modificar') }}
            </x-primary-button>
        </div>
    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('notificacionEditado', (event) => {
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
            title: 'Categoria modificada con exito'
            })
        })
    </script>
@endpush