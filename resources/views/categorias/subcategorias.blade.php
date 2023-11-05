<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Subcategorias de: ') . $categoria->nombre }}
            </h2>
            <a href="{{ route('categorias.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'">
                Volver
            </a>
        </div>
    </x-slot> 
    
    <div class="w-3/4 max-w-screen-xl mx-auto py-6 sm:px-6 lg:px-8">    
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
            <div class="px-6 py-4 flex justify-between items-center">
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{__('Listado Subcategorias')}}</h3>
                <x-secondary-button onclick="Livewire.dispatch('openModal', { component: 'crear-subcategoria', arguments: { categoria: {{ $categoria->id }} } })">Nueva</x-secondary-button>
            </div>
            @livewire('listar-subcategorias', ['categoria' => $categoria], key($categoria->id))
        </div>
    </div>  
</x-app-layout>