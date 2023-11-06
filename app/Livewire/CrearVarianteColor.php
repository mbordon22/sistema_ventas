<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\ProductoVariante;
use App\Models\ProductoVarianteImagen;

class CrearVarianteColor extends Component
{
    public Producto $producto;
    public $colores = [''];
    public $stock = [''];
    public $imagenes = [[]];

    use WithFileUploads;

    protected $rules = [
        'colores.*' => 'required|string',
        'stock.*' => 'required|numeric|min:0',
        'imagenes.*.*' => 'required|image|max:1024'
    ];

    #[On('agregarColor')]
    public function agregarColor()
    {
        $this->colores[] = '';
        $this->stock[] = '';
        $this->imagenes[] = [];
    }

    #[On('eliminarColor')]
    public function eliminarColor($key)
    {
        unset($this->colores[$key]);
        unset($this->stock[$key]);
        unset($this->imagenes[$key]);
    }

    #[On('eliminarImagen')]
    public function eliminarImagen($key, $imagenNombre)
    {
        if (isset($this->imagenes[$key]) && is_array($this->imagenes[$key])) {
            // Filtramos las imágenes y eliminamos la imagen seleccionada
            $this->imagenes[$key] = array_filter($this->imagenes[$key], function ($imagen) use ($imagenNombre) {
                return $imagen->getFilename() !== $imagenNombre;
            });
        }
    }

    public function crearVarianteColor()
    {
        $data = $this->validate();

        //Guardamos las imagenes y el nombre genreado en un array
        $array_imagenes = [];
        for($i = 0; $i < count($data['imagenes']); $i++){
            $imagenes_variante = $data['imagenes'][$i];
            for($j = 0; $j < count($imagenes_variante); $j++){
                $imagen = $imagenes_variante[$j];
                $nombre_imagen = null;
                if($imagen != ''){
                    $imagen = $imagen->store('public/productos');
                    $nombre_imagen = str_replace('public/productos/', '', $imagen);
                }
                if(array_key_exists($i,$array_imagenes)){
                    array_push($array_imagenes[$i], $nombre_imagen);
                } else {
                    array_push($array_imagenes, [$i => $nombre_imagen]);
                }
            }
        }

        //Guardo cada variante del producto (talle) en la tabla correspondiente con la referencia al producto
        foreach($data['colores'] as $key => $color){
            $variante = ProductoVariante::create([
                'producto_id' => $this->producto->id,
                'color' => $color,
                'stock' => $data['stock'][$key]
            ]);

            //Guardamos la referencia a las imagenes
            foreach($array_imagenes[$key] as $key_imagen => $imagen){
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
        return view('livewire.crear-variante-color');
    }
}
