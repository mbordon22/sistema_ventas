<div>
    <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="py-3 px-6 text-left border-b-2">Categoria</th>
                    <th class="py-3 px-6 text-left border-b-2">Subcategorias</th>
                    <th class="py-3 px-6 text-left border-b-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                <tr>
                    <td class="py-3 px-6">{{ $categoria->nombre }}</td>
                    <td class="py-3 px-6">                        
                        <a href="{{ route('categorias.subcategorias', $categoria->id) }}" class="text-blue-600 hover:underline">Ver/Agregar</a>
                    </td>
                    <td class="py-3 px-6 w-5/12 flex justify-between items-center">
                        <a href="{{ route('categorias.show', $categoria->id) }}" title="Ver Detalles" class="text-green-600 hover:underline"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('categorias.edit', $categoria->id) }}" title="Modificar" class="text-blue-600 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button class="text-red-600 hover:underline" title="Eliminar" onclick="alertEliminar({categoria:{{$categoria->id}}})"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6" align="center"> No hay categorias para mostrar. </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">
        {{$categorias->links()}}
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function alertEliminar(categoria)
        {
            Swal.fire({
                title: '¿Eliminar Categoria?',
                text: "Esta acción no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // console.log(categoria)
                    Livewire.dispatch('eliminarCategoria', categoria); 
                    Swal.fire(
                    'Eliminado!',
                    'La categoria fue eliminada.',
                    'success'
                    )
                }
            })
        }
    </script>
@endpush