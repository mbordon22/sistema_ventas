<?php

namespace App\Livewire;

use App\Models\Marca;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EditarMarca extends ModalComponent
{
    public $nombre_marca;
    public $marca_id;

    protected $rules = [
        'nombre_marca' => 'required|string'
    ];

    public function mount(Marca $marca)
    {
        $this->nombre_marca = $marca->nombre_marca;
        $this->marca_id = $marca->id;
    }

    public function editarMarca()
    {
        $data = $this->validate();
        $marca = Marca::find($this->marca_id);

        $marca->nombre_marca = $data['nombre_marca'];
        $marca->save();

        //Mensaje a mostrar
        $this->dispatch('notificacionEditado');

        $this->dispatch('refreshMarcas')->to(ListarMarcas::class);
        
        $this->closeModal();

    }

    public function render()
    {
        return view('livewire.editar-marca');
    }
}
