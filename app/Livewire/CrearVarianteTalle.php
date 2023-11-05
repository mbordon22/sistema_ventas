<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\ProductoVariante;
use App\Models\ProductoVarianteImagen;

class CrearVarianteTalle extends Component
{
    public Producto $producto;
    public $talles = [''];
    public $stock = [''];
    public $imagenes = [];

    use WithFileUploads;

    protected $rules = [
        'talles.*' => 'required|string',
        'stock.*' => 'required|numeric|min:0',
        'imagenes.*' => 'required|image|max:1024'
    ];

    #[On('agregarTalle')]
    public function agregarTalle()
    {
        $this->talles[] = '';
        $this->stock[] = '';
    }

    #[On('eliminarTalle')]
    public function eliminarTalle($key)
    {
        unset($this->talles[$key]);
        unset($this->stock[$key]);
    }

    public function crearVarianteTalle()
    {
        $data = $this->validate();

        //Guardamos las imagenes y el nombre genreado en un array
        $array_imagenes = [];
        foreach($data['imagenes'] as $imagen){
            $nombre_imagen = null;
            if($imagen != ''){
                $imagen = $imagen->store('public/productos');
                $nombre_imagen = str_replace('public/productos/', '', $imagen);
            }
            array_push($array_imagenes, $nombre_imagen);
        }

        //Guardo cada variante del producto (talle) en la tabla correspondiente con la referencia al producto
        foreach($data['talles'] as $key => $talle){
            $variante = ProductoVariante::create([
                'producto_id' => $this->producto->id,
                'talle' => $talle,
                'stock' => $data['stock'][$key]
            ]);

            // $this->producto->variantes()->save($variante);

            //Guardamos la referencia a las imagenes
            foreach($array_imagenes as $key => $imagen){
                $variante_imagen = ProductoVarianteImagen::create([
                    'variante_id' => $variante->id,
                    'imagen' => $imagen
                ]);
                $variante_imagen->save();
            }
        }

        //Mensaje a mostrar
        $this->dispatch('notificacionCreado');

        //redireccionamos al listado
        return redirect()->route('productos.index');
    }
    
    public function render()
    {
        return view('livewire.crear-variante-talle');
    }
}
