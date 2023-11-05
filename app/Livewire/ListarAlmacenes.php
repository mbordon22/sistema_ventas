<?php

namespace App\Livewire;

use App\Models\Almacen;
use Livewire\Component;
use Livewire\Attributes\On;

class ListarAlmacenes extends Component
{

    #[On('eliminarAlmacen')]
    public function eliminarAlmacen(Almacen $almacen)
    {
        $almacen->delete();    
    }

    public function render()
    {
        $almacenes = Almacen::paginate(10);
        return view('livewire.listar-almacenes', [
            'almacenes' => $almacenes
        ]);
    }
}
