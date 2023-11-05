<?php

namespace App\Livewire;

use App\Models\Almacen;
use Livewire\Component;

class CrearAlmacen extends Component
{
    public $nombre;
    public $telefono;
    public $contacto_nombre;
    public $contacto_email;
    public $ubicacion;
    public $tipo;
    public $descripcion;

    protected $rules = [
        'nombre' => 'required|string',
        'telefono' => 'required|numeric|min_digits:10',
        'contacto_nombre' => 'nullable|string',
        'contacto_email' => 'nullable|email',
        'tipo' => 'required',
        'ubicacion' => 'required|string'
    ];

    public function crearAlmacen()
    {
        $data = $this->validate();

        //Creamos al alumno
        Almacen::create([
            'nombre' => $data['nombre'],
            'telefono' => $data['telefono'],
            'contacto_nombre' => $data['contacto_nombre'],
            'contacto_email' => $data['contacto_email'],
            'tipo' => $data['tipo'],
            'ubicacion' => $data['ubicacion'],
            'descripcion' => $this->descripcion
        ]);

        //Mensaje a mostrar
        $this->dispatch('notificacionCreado');

        //redireccionamos al listado
        return redirect()->route('almacenes.index');
    }


    public function render()
    {
        return view('livewire.crear-almacen');
    }
}
