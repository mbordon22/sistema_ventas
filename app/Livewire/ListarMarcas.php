<?php

namespace App\Livewire;

use App\Models\Marca;
use Livewire\Component;
use Livewire\Attributes\On;

class ListarMarcas extends Component
{

    #[On('eliminarMarca')]
    public function eliminarMarca(Marca $marca)
    {
        $marca->delete();  
        $this->reset();  
    }

    #[On('refreshMarcas')]
    public function refreshMarcas()
    {
        //Mensaje a mostrar
        session()->flash('mensaje', 'Marca creada con exito');
        $this->dispatch('renderizar')->self();
    }

    #[On('renderizar')]
    public function render()
    {
        $marcas = Marca::paginate(10);
        return view('livewire.listar-marcas', [
            'marcas' => $marcas
        ]);
    }
}
