<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\On;

class ListarCategorias extends Component
{

    #[On('eliminarCategoria')]
    public function eliminarCategoria(Categoria $categoria)
    {
        $categoria->delete();
        $this->dispatch('refreshCategorias')->self();
    }
    
    #[On('refreshCategorias')]
    public function render()
    {
        //Las que no tengan un valor en la columna parent_id son las categorias principales
        $categorias = Categoria::where('parent_id',null)->paginate(10);
        return view('livewire.listar-categorias',[
            'categorias' => $categorias
        ]);
    }
}
