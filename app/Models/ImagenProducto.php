<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    use HasFactory;

    public $table = 'imagenes_productos';

    protected $fillable = [
        'producto_id',
        'imagen'
    ];

    public function imagenes()
    {
        return $this->hasOne(Producto::class);  
    }
}
