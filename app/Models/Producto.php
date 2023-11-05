<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    public $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'categoria_id',
        'subcategoria_id',
        'marca_id',
        'codigo_barras',
        'codigo',
        'habilitado',
        'slug'
    ];

    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class);    
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Categoria::class, 'subcategoria_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function variantes()
    {
        return $this->hasMany(ProductoVariante::class);
    }
}
