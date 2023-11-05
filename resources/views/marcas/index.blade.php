<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Listado Marcas') }}
            </h2>
            <x-primary-button onclick="Livewire.dispatch('openModal', { component: 'crear-marca' })">Nueva Marca</x-primary-button>
        </div>
    </x-slot>

    @if (session()->has('mensaje'))
        <div class="uppercase border border-green-600 bg-green-100 text-green-600 font-bold p-2 my-3 text-sm">
            {{session('mensaje')}}
        </div>
    @endif

    <div class="w-full max-w-screen-xl mx-auto py-6 sm:px-6 lg:px-8">    
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
            @livewire('listar-marcas')
        </div>
    </div>    
</x-app-layout>
