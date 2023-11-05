<?php

namespace App\Livewire;

use App\Models\Marca;
use Livewire\Attributes\On;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class CrearMarca extends ModalComponent
{
    public $nombre_marca;

    protected $rules = [
        'nombre_marca' => 'required|string'
    ];

    public function crearMarca()
    {
        $data = $this->validate();

        Marca::create([
            'nombre_marca' => $data['nombre_marca']
        ]);

        $this->dispatch('notificacionCreado');
        $this->dispatch('refreshMarcas')->to(ListarMarcas::class);
        $this->closeModal();

    }

    public function render()
    {
        return view('livewire.crear-marca');
    }
}
