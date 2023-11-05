<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\Attributes\On;

class ListarProductos extends Component
{
    #[On('eliminarProducto')]
    public function eliminarProducto(Producto $producto)
    {
        $producto->delete();    
    }

    public function render()
    {
        $productos = Producto::paginate(10);
        return view('livewire.listar-productos', [
            'productos' => $productos
        ]);
    }
}
