<div>
    <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="py-3 px-6 text-left border-b-2">Nombre</th>
                    <th class="py-3 px-6 text-left border-b-2">Categoria</th>
                    <th class="py-3 px-6 text-left border-b-2">Subcategoria</th>
                    <th class="py-3 px-6 text-left border-b-2">Marca</th>
                    <th class="py-3 px-6 text-left border-b-2">Precio</th>
                    <th class="py-3 px-6 text-left border-b-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                <tr>
                    <td class="py-3 px-6">{{ $producto->nombre }}</td>
                    <td class="py-3 px-6">{{ $producto->categoria->nombre }}</td>
                    <td class="py-3 px-6">{{ $producto->subcategoria->nombre }}</td>
                    <td class="py-3 px-6">{{ $producto->marca->nombre_marca }}</td>
                    <td class="py-3 px-6">${{ $producto->precio }}</td>
                    <td class="py-3 px-6 w-3/4 flex justify-between items-center">
                        <a href="{{ route('productos.show', $producto->id) }}" class="text-green-600 hover:underline"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('productos.edit', $producto->id) }}" class="text-blue-600 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button class="text-red-600 hover:underline" onclick="alertEliminar({producto:{{$producto->id}}})"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6" align="center"> No hay productos para mostrar. </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">
        {{$productos->links()}}
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function alertEliminar(producto)
        {
            Swal.fire({
            title: '¿Eliminar Producto?',
            text: "Esta acción no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('eliminarProducto', producto); 
                    Swal.fire(
                    'Eliminado!',
                    'El producto fue eliminado.',
                    'success'
                    )
                }
            })
        }
    </script>
@endpush