<div>
    <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="py-3 px-6 text-left border-b-2">Marca</th>
                    <th class="py-3 px-6 text-left border-b-2">Estado</th>
                    <th class="py-3 px-6 text-left border-b-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($marcas as $marca)
                <tr>
                    <td class="py-3 px-6">{{ $marca->nombre_marca }}</td>
                    <td class="py-3 px-6">{{ ($marca->habilitado == 1) ? 'Habilitado' : 'Deshabilitado' }}</td>
                    <td class="py-3 px-6 w-1/4 flex justify-between items-center">
                        <a href="{{ route('marcas.edit', $marca->id) }}" class="text-blue-600 hover:underline"></a>
                        <button class="text-blue-600 hover:underline" onclick="Livewire.dispatch('openModal', { component: 'editar-marca', arguments: { marca: {{ $marca->id }} }})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="text-red-600 hover:underline" onclick="alertEliminar({marca:{{$marca->id}}})"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6" align="center"> No hay marcas para mostrar. </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">
        {{$marcas->links()}}
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function alertEliminar(marca)
        {
            Swal.fire({
                title: '¿Eliminar Marca?',
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
                    Livewire.dispatch('eliminarMarca', marca); 
                    Swal.fire(
                    'Eliminado!',
                    'La marca fue eliminada.',
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
            title: 'Marca creada con exito'
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
            title: 'Marca modificada con exito'
            })
        })
    </script>
@endpush