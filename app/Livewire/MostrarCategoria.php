<?php

namespace App\Livewire;

use App\Models\Categoria;
use Livewire\Component;

class MostrarCategoria extends Component
{
    public Categoria $categoria;

    public function render()
    {
        return view('livewire.mostrar-categoria',[
            'categoria' => $this->categoria
        ]);
    }
}
