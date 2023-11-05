<?php

namespace App\Livewire;

use App\Models\Marca;
use Livewire\Component;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class CrearCategoria extends Component
{
    public $nombre;
    public $slug = "";
    public $imagen;
    public $marcas_array = [];

    use WithFileUploads;

    protected $rules = [
        'nombre' => 'required|string',
        'slug' => 'required|string',
        'imagen' => 'nullable|image|max:1024'
    ];

    #[On('generarSlug')]
    public function generarSlug()
    {
        $this->slug = Str::slug($this->nombre);
    }


    public function crearCategoria()
    {
        $data = $this->validate();

        //Primero almacenamos la imagen si es que viene del formulario
        $nombre_imagen = null;
        if($this->imagen != ''){
            $imagen = $this->imagen->store('public/categorias');
            $nombre_imagen = str_replace('public/categorias/', '', $imagen);
        }

        //Creamos la categoria
        $categoria = Categoria::create([
            'nombre' => $data['nombre'],
            'slug' => Str::slug($data['nombre']),
            'imagen' => $nombre_imagen,
        ]);

        //Crear los registros en la tabla pivot categorias_tablas
        $categoria->marcas()->attach($this->marcas_array);

        //Mensaje a mostrar
        $this->dispatch('notificacionCreado');

        //redireccionamos al listado
        return redirect()->route('categorias.index');
    }

    public function render()
    {
        $marcas = Marca::all();

        return view('livewire.crear-categoria',[
            'marcas' => $marcas
        ]);
    }
}
