<?php

namespace App\Livewire;

use App\Models\Almacen;
use Livewire\Component;

class MostrarAlmacen extends Component
{
    public Almacen $almacen;
    public function render()
    {
        return view('livewire.mostrar-almacen',[
            'almacen' => $this->almacen
        ]);
    }
}
