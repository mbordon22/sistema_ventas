<div>
    <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="py-3 px-6 text-left border-b-2">Nombre</th>
                    <th class="py-3 px-6 text-left border-b-2">Ubicación</th>
                    <th class="py-3 px-6 text-left border-b-2">Teléfono</th>
                    <th class="py-3 px-6 text-left border-b-2">Tipo</th>
                    <th class="py-3 px-6 text-left border-b-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($almacenes as $almacen)
                <tr>
                    <td class="py-3 px-6">{{ $almacen->nombre }}</td>
                    <td class="py-3 px-6">{{ $almacen->ubicacion }}</td>
                    <td class="py-3 px-6">
                        {{ $almacen->telefono }}
                        {{-- <a href="tel:{{ $almacen->telefono }}" class="pl-3">
                            <i class="fa-solid fa-phone"></i>
                        </a> --}}
                    </td>
                    <td class="py-3 px-6">{{ $almacen->tipo }}</td>
                    <td class="py-3 px-6 w-3/4 flex justify-between items-center">
                        <a href="{{ route('almacenes.show', $almacen->id) }}" class="text-green-600 hover:underline"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('almacenes.edit', $almacen->id) }}" class="text-blue-600 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button class="text-red-600 hover:underline" onclick="alertEliminar({almacen:{{$almacen->id}}})"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6" align="center"> No hay almacenes para mostrar. </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">
        {{$almacenes->links()}}
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function alertEliminar(almacen)
        {
            Swal.fire({
            title: '¿Eliminar Almacen?',
            text: "Esta acción no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('eliminarAlmacen', almacen); 
                    Swal.fire(
                    'Eliminado!',
                    'El almacen fue eliminado.',
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
            title: 'Almacen creado con exito'
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
            title: 'Almacen modificado con exito'
            })
        })
    </script>
@endpush