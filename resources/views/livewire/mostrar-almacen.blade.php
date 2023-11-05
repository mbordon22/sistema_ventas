<div class="w-full max-w-screen-xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 dark:text-gray-100 overflow-hidden shadow-sm sm:rounded-lg mt-4">
        <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-100 border-b border-gray-200">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Nombre del Almacén:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->nombre }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ubicación:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->ubicacion }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Teléfono:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->telefono }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Tipo de Almacén:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->tipo }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Descripción:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->descripcion ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Capacidad de Almacenamiento:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->capacidad ? $almacen->capacidad . __(' Unidades') : __('N/A') }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Estado del Almacén:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->habilitado ? 'Activo' : 'Inactivo' }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Contacto Nombre:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->contacto_nombre ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Contacto Mail:</h3>
                <a href="mailto:{{$almacen->contacto_email}}" class="text-blue-600 dark:text-blue-300">{{ $almacen->contacto_email ?? 'N/A' }}</a>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Coordenadas GPS:</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $almacen->coordenadas ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
