<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Categoria;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;

class EditarSubcategoria extends ModalComponent
{
    public $nombre;
    public $categoria_id;
    public $color;
    public $talle;

    public function mount(Categoria $subcategoria)
    {
        $this->nombre = $subcategoria->nombre;
        $this->categoria_id = $subcategoria->id;
        $this->color = $subcategoria->color;
        $this->talle = $subcategoria->talle;
    }

    protected $rules = [
        'nombre' => 'required|string'
    ];

    public function editarSubcategoria()
    {
        $data = $this->validate();
        $data['talle'] = $this->talle ? 1 : 0;
        $data['color'] = $this->color ? 1 : 0;


        $subcategoria = Categoria::find($this->categoria_id);

        $subcategoria->nombre = $data['nombre'];
        $subcategoria->slug = Str::slug($data['nombre']);
        $subcategoria->color = $data['color'];
        $subcategoria->talle = $data['talle'];
        $subcategoria->save();

        //Mensaje a mostrar
        $this->dispatch('notificacionEditado');

        $this->dispatch('refreshSubcategorias')->to(ListarSubcategorias::class);
        
        $this->closeModal();

    }

    public function render()
    {
        return view('livewire.editar-subcategoria');
    }
}
