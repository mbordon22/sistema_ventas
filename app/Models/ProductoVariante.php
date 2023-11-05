<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoVariante extends Model
{
    use HasFactory;

    public $table = 'productos_variantes';

    public $fillable = [
        'producto_id',
        'talle',
        'color',
        'stock'
    ];

    public function imagenes()
    {
        return $this->hasMany(ProductoVariante::class, 'vacante_id', 'id');
    }
}
