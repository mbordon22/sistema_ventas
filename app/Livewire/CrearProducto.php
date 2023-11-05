<?php

namespace App\Livewire;

use App\Models\Marca;
use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\ImagenProducto;

class CrearProducto extends Component
{
    public $categorias;
    public $subcategorias = [];
    public $categoria_id;
    public $subcategoria_id = NULL;
    public $nombre;
    public $codigo;
    public $descripcion;
    public $marca_id;
    public $precio;
    // public $imagenes = [];
    // public $subcategoria_selected = NULL;

    use WithFileUploads;

    public function mount()
    {
        $this->categorias = Categoria::where('parent_id', null)->get();
        $this->subcategorias = collect();
    }

    public function updatedCategoriaId($value)
    {
        //Obtenemos las subcategorias
        $this->subcategorias = collect();
        $this->subcategorias = Categoria::where('parent_id',$value)->get();
        $this->subcategoria_id = NULL;
        
        //Actualizamos la opción del select de categorias, que livewire no lo esta haciendo
        $this->dispatch('cambiarSelectSubcategorias');
    }

    protected $rules = [
        'nombre' => 'required|string',
        'codigo' => 'nullable|string',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric|min:0',
        'categoria_id' => 'required',
        'subcategoria_id' => 'required',
        'marca_id' => 'required',
    ];

    public function crearProducto()
    {
        $data = $this->validate();
        // dd($data);
        //Guardamos el producto
        $producto = Producto::create([
            'nombre' => $data['nombre'],
            'categoria_id' => $data['categoria_id'],
            'subcategoria_id' => $data['subcategoria_id'],
            'codigo' => $data['codigo'],
            'descripcion' => $data['descripcion'],
            'marca_id' => $data['marca_id'],
            'precio' => $data['precio'],
            'slug' => Str::slug($data['nombre'])
        ]);

        //Redirigimos a crear las variantes del producto
        return redirect()->route('productos.variantes', $producto);
    }

    public function render()
    {
        $marcas = Marca::all();
        return view('livewire.crear-producto', [
            'marcas' => $marcas
        ]);
    }
}
