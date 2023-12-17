<div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
    <form method="POST" wire:submit.prevent="editarProducto">

        <div class="grid grid-cols-2 gap-4">
            <!-- Categoria -->
            <div class="col-span-1">
                <x-input-label for="categoria_id" :value="__('Categoria')" />
                <x-select-input wire:model.live="categoria_id" id="categoria_id" class="block mt-1 w-full">
                    <option value="" selected>--Seleccionar--</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
            </div>

            <!-- Subategoria -->
            <div class="col-span-1">
                <x-input-label for="subcategoria_id" :value="__('Subategoria')" />
                <x-select-input wire:model.live="subcategoria_id" id="select_subcategoria" class="block mt-1 w-full">
                    @if ($subcategorias->count() == 0)
                        <option value="">--Seleccione primero una categoria--</option>
                    @else    
                    <option value="" selected>--Seleccionar--</option>
                    @foreach ($subcategorias as $subcategoria)
                        <option value="{{$subcategoria->id}}">{{$subcategoria->nombre}}</option>
                    @endforeach
                    @endif
                </x-select-input>
                <x-input-error :messages="$errors->get('subcategoria_id')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-4">
            <!-- Nombre -->
            <div class="col-span-1">
                <x-input-label for="nombre" :value="__('Nombre')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" wire:model="nombre" required />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- codigo -->
            <div class="col-span-1">
                <x-input-label for="codigo" :value="__('Código')" />
                <x-text-input id="codigo" class="block mt-1 w-full" type="text" wire:model="codigo" />
                <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
            </div>
        </div>

        <!-- Descripcion -->
        <div class="mt-4">
            <x-input-label for="descripcion" :value="__('Descripción')" />
            <textarea wire:model="descripcion" id="descripcion" cols="30" rows="10" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"></textarea>
            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
        </div>

        <div class="mt-4 mb-10 grid grid-cols-2 gap-4">
            <!-- Marca -->
            <div class="col-span-1">
                <x-input-label for="marca_id" :value="__('Marca')" />
                <x-select-input id="marca_id" class="block mt-1 w-full" wire:model="marca_id" >
                    <option value="">--Seleccionar--</option>
                    @foreach ($marcas as $marca)
                        <option value="{{$marca->id}}">{{$marca->nombre_marca}}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('marca_id')" class="mt-2" />
            </div>

            <!-- Precio -->
            <div class="col-span-1">
                <x-input-label for="precio" :value="__('Precio')" />
                <x-text-input id="precio" class="block mt-1 w-full" type="number" min="0" wire:model="precio" required />
                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{route('productos.variantes', $producto_id)}}" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'">
                {{ __('Ver/Modificar Variantes') }}
            </a>
            <x-primary-button>
                {{ __('Guardar') }}
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
            title: 'Producto modificado con exito'
            })
        })

        Livewire.on('cambiarSelectSubcategorias', (event) => {
            document.getElementById("select_subcategoria").value = "";
        })
    </script>
@endpush