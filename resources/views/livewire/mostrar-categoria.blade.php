<div class="w-full max-w-screen-xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 dark:text-gray-100 overflow-hidden shadow-sm sm:rounded-lg mt-4">
        <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100 border-b border-gray-200">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Imagen Categoria:</h3>
                <div class="flex justify-center">
                    @if ($categoria->imagen)
                        <div class="w-full bg-contain" style="background-image: url('{{ asset('storage/categorias/' . $categoria->imagen) }}'); height: 300px; background-repeat:no-repeat;"></div>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Nombre de la Categoria:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $categoria->nombre }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Slug:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $categoria->slug }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Subcategorias asociadas:</h3>
                <div class="grid grid-cols-2 gap-4">
                    @forelse ($categoria->subcategorias as $subcategoria)
                        <li class="grid-span-2">
                            {{ $subcategoria->nombre }}
                        </li>
                    @empty
                        <p class="grid-span-2 text-center">No hay Subcategorias asociadas a la categoria</p>
                    @endforelse
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Marcas asociadas:</h3>
                <div class="grid grid-cols-2 gap-4">
                    @forelse ($categoria->marcas as $marca)
                        <li class="grid-span-2">
                            {{ $marca->nombre_marca }}
                        </li>
                    @empty
                        <p class="grid-span-2 text-center">No hay Marcas asociadas a la categoria</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
