<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    public $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
        'parent_id',
        'talle',
        'color',
        'imagen'
    ];


    public function subcategorias()
    {
        return $this->hasMany(Categoria::class, 'parent_id');
    }

    public function marcas()
    {
        return $this->belongsToMany(Marca::class);
    }
}
