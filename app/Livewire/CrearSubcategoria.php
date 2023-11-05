<?php

namespace App\Livewire;

use App\Models\Categoria;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class CrearSubcategoria extends ModalComponent
{
    public $nombre;
    public $categoria_id;
    public $color;
    public $talle;

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function mount(Categoria $categoria)
    {
        $this->categoria_id = $categoria->id;
    }

    protected $rules = [
        'nombre' => 'required|string'
    ];

    public function crearSubcategoria()
    {
        $data = $this->validate();
        $data['talle'] = $this->talle ? 1 : 0;
        $data['color'] = $this->color ? 1 : 0;

        //Creamos la categoria
        Categoria::create([
            'nombre' => $data['nombre'],
            'slug' => Str::slug($data['nombre']),
            'parent_id' => $this->categoria_id,
            'color' => $data['color'],
            'talle' => $data['talle']
        ]);

        //Mensaje a mostrar
        $this->dispatch('notificacionCreado');

        //redireccionamos al listado
        $this->dispatch('refreshSubcategorias')->to(ListarSubcategorias::class);

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.crear-subcategoria');
    }
}
