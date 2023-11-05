<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\On;

class ListarSubcategorias extends Component
{
    public $categoria_id;

    public function mount(Categoria $categoria)
    {
        $this->categoria_id = $categoria->id;
    }

    #[On('eliminarSubategoria')]
    public function eliminarSubategoria(Categoria $categoria)
    {
        $categoria->delete();
    }

    #[On('refreshSubcategorias')]
    public function render()
    {
        $subcategorias = Categoria::where('parent_id', $this->categoria_id)->get();
        return view('livewire.listar-subcategorias', [
            'subcategorias' => $subcategorias
        ]);
    }
}
