<?php

namespace App\Livewire;

use App\Models\Marca;
use Livewire\Component;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class EditarCategoria extends Component
{
    public $categoria_id;
    public $nombre;
    public $slug = "";
    public $imagen;
    public $nueva_imagen;
    public $marcas_array = [];

    use WithFileUploads;

    public function mount(Categoria $categoria)
    {
        $this->nombre = $categoria->nombre;
        $this->slug = $categoria->slug;
        $this->imagen = $categoria->imagen;
        $this->marcas_array = $categoria->marcas->pluck('id');  //Para que me traiga solo los id de las marcas relacionadas
        $this->categoria_id = $categoria->id;
    }

    protected $rules = [
        'nombre' => 'required|string',
        'slug' => 'required|string',
        'nueva_imagen' => 'nullable|image|max:1024'
    ];

    #[On('generarSlug')]
    public function generarSlug()
    {
        $this->slug = Str::slug($this->nombre);
    }

    public function editarCategoria()
    {
        $data = $this->validate();

        //Primero almacenamos la imagen si es que viene del formulario
        $nombre_imagen = null;
        if($this->nueva_imagen != ''){
            $imagen = $this->nueva_imagen->store('public/categorias');
            $nombre_imagen = str_replace('public/categorias/', '', $imagen);
            $data['nueva_imagen'] = $nombre_imagen;
        }

        $categoria = Categoria::find($this->categoria_id);
        $categoria->nombre = $data['nombre'];
        $categoria->slug = Str::slug($data['nombre']);
        $categoria->imagen = $data['nueva_imagen'] ?? $categoria->imagen;
        $categoria->save();

        //Actualiza los registros en la tabla pivot categorias_tablas
        $categoria->marcas()->sync($this->marcas_array);

        //Mensaje a mostrar
        $this->dispatch('notificacionEditado');

        //redireccionamos al listado
        return redirect()->route('categorias.index');
    }
    
    public function render()
    {
        $marcas = Marca::all();
        return view('livewire.editar-categoria', [
            'marcas' => $marcas
        ]);
    }
}
