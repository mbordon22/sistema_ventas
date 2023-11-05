<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Variantes de ') . $producto->nombre }}
            </h2>
            <a href="{{ route('productos.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="w-3/4 max-w-screen-xl mx-auto py-6 sm:px-6 lg:px-8">    
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
            {{-- Solo Talle --}}
            @if ($producto->subcategoria->talle == 1 && $producto->subcategoria->color == 0)
                @livewire('crear-variante-talle', ['producto' => $producto], key($producto->id))
            @endif

            {{-- Solo Color --}}
            @if ($producto->subcategoria->color == 1 && $producto->subcategoria->talle == 0)
                @livewire('crear-variante-color', ['producto' => $producto], key($producto->id))
            @endif

            {{-- Color y Talle --}}
            @if ($producto->subcategoria->color == 1 && $producto->subcategoria->talle == 1)
                Color y Talle
            @endif
        </div>
    </div>    
</x-app-layout>
