<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    public $table = 'almacenes';
    protected $fillable = [
        'nombre',
        'ubicacion',
        'telefono',
        'contacto_nombre',
        'contacto_email',
        'descripcion',
        'capacidad',
        'tipo',
        'habilitado',
        'coordenadas',
    ];
}
