<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoVarianteImagen extends Model
{
    use HasFactory;

    public $table = 'productos_variantes_imagenes';

    protected $fillable = [
        'variante_id',
        'imagen'
    ];
}
