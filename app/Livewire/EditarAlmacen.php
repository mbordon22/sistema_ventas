<?php

namespace App\Livewire;

use App\Models\Almacen;
use Livewire\Component;

class EditarAlmacen extends Component
{

    public $nombre;
    public $telefono;
    public $contacto_nombre;
    public $contacto_email;
    public $ubicacion;
    public $tipo;
    public $descripcion;
    public $almacen_id;

    public function mount(Almacen $almacen)
    {
        $this->nombre = $almacen->nombre;
        $this->telefono = $almacen->telefono;
        $this->contacto_nombre = $almacen->contacto_nombre;
        $this->contacto_email = $almacen->contacto_email;
        $this->ubicacion = $almacen->ubicacion;
        $this->tipo = $almacen->tipo;
        $this->descripcion = $almacen->descripcion;
        $this->almacen_id = $almacen->id;
    }

    protected $rules = [
        'nombre' => 'required|string',
        'telefono' => 'required|numeric|min_digits:10',
        'contacto_nombre' => 'nullable|string',
        'contacto_email' => 'nullable|email',
        'tipo' => 'required',
        'ubicacion' => 'required|string'
    ];


    public function editarAlmacen()
    {
        $data = $this->validate();

        $almacen = Almacen::find($this->almacen_id);
        $almacen->nombre = $data['nombre'];
        $almacen->telefono = $data['telefono'];
        $almacen->contacto_nombre = $data['contacto_nombre'];
        $almacen->contacto_email = $data['contacto_email'];
        $almacen->tipo = $data['tipo'];
        $almacen->ubicacion = $data['ubicacion'];
        $almacen->descripcion = $this->descripcion;

        $almacen->save();

        //Mensaje a mostrar
        $this->dispatch('notificacionEditado');

        //redireccionamos al listado
        return redirect()->route('almacenes.index');
    }

    public function render()
    {
        return view('livewire.editar-almacen');
    }
}
