<?php

namespace App\Livewire;

use App\Models\Marca;
use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Str;

class EditarProducto extends Component
{
    public $marcas;
    public $categorias;
    public $subcategorias = [];
    public $categoria_id;
    public $subcategoria_id = NULL;
    public $nombre;
    public $codigo;
    public $descripcion;
    public $marca_id;
    public $precio;
    public $producto_id;


    protected $rules = [
        'nombre' => 'required|string',
        'codigo' => 'nullable|string',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric|min:0',
        'categoria_id' => 'required',
        'subcategoria_id' => 'required',
        'marca_id' => 'required',
    ];

    public function mount(Producto $producto)
    {
        $this->categorias = Categoria::where('parent_id', null)->get();
        $this->subcategorias = Categoria::where('parent_id', $producto->categoria_id)->get();
        $this->marcas = Marca::all();

        $this->categoria_id = $producto->categoria_id;
        $this->subcategoria_id = $producto->subcategoria_id;
        $this->nombre = $producto->nombre;
        $this->codigo = $producto->codigo;
        $this->descripcion = $producto->descripcion;
        $this->marca_id = $producto->marca_id;
        $this->precio = $producto->precio;
        $this->producto_id = $producto->id;
    }

    public function editarProducto()
    {
        $data = $this->validate();
        
        //Guardamos el producto
        $producto = Producto::find($this->producto_id);
        $producto->nombre = $data['nombre'];
        $producto->codigo = $data['codigo'];
        $producto->descripcion = $data['descripcion'];
        $producto->precio = $data['precio'];
        $producto->categoria_id = $data['categoria_id'];
        $producto->marca_id = $data['marca_id'];
        $producto->slug = Str::slug($data['nombre']);
        $producto->save();

        //Mensaje a mostrar
        $this->dispatch('notificacionEditado');

        //Redirigimos a crear las variantes del producto
        // return redirect()->route('productos.variantes', $producto);
    }

    public function render()
    {
        return view('livewire.editar-producto');
    }
}
