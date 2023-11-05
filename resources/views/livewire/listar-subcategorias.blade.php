<div>
    <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="py-3 px-6 text-left border-b-2">Subcategoria</th>
                    <th class="py-3 px-6 text-left border-b-2">Color</th>
                    <th class="py-3 px-6 text-left border-b-2">Talle</th>
                    <th class="py-3 px-6 text-left border-b-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subcategorias as $subcategoria)
                <tr>
                    <td class="py-3 px-6">{{ $subcategoria->nombre }}</td>
                    <td class="py-3 px-6">{{ ($subcategoria->color == 1) ? 'Si' : 'No' }}</td>
                    <td class="py-3 px-6">{{ ($subcategoria->talle == 1) ? 'Si' : 'No' }}</td>
                    <td class="py-3 px-6 w-5/12 flex justify-between items-center gap-2">
                        <button class="text-blue-600 hover:underline" onclick="Livewire.dispatch('openModal', { component: 'editar-subcategoria', arguments: { subcategoria: {{ $subcategoria->id }} }})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="text-red-600 hover:underline" title="Eliminar" onclick="alertEliminar({categoria:{{$subcategoria->id}}})"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6" align="center"> No hay subcategorias para mostrar. </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function alertEliminar(categoria)
        {
            Swal.fire({
                title: '¿Eliminar Subategoria?',
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
                    Livewire.dispatch('eliminarSubategoria', categoria); 
                    Swal.fire(
                    'Eliminado!',
                    'La subcategoria fue eliminada.',
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
            title: 'Subcategoria creada con exito'
            })
        })

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
            title: 'Subcategoria modificada con exito'
            })
        })
    </script>
@endpush