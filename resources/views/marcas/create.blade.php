<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nueva Marca') }}
        </h2>
    </x-slot>

    <div class="w-3/4 max-w-screen-xl mx-auto py-6 sm:px-6 lg:px-8">    
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
            @livewire('crear-almacen')
        </div>
    </div>    
</x-app-layout>
