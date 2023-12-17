<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\ProductoVariante;
use App\Models\ProductoVarianteImagen;

class CrearVarianteColorTalle extends Component
{
    public Producto $producto;
    public $colores = [''];
    public $talles = [[0 => []]];
    public $stock = [[0 => []]];
    public $imagenes = [[]];

    protected $rules = [
        'colores.*' => 'required|string',
        'talles.*.*' => 'required|string',
        'stock.*.*' => 'required|string',
        'imagenes.*.*' => 'required|image|max:1024'
    ];

    use WithFileUploads;

    #[On('agregarTalle')]
    public function agregarTalle($key_color)
    {
        $this->talles[$key_color][] = '';
        $this->stock[$key_color][] = '';
    }

    #[On('eliminarTalle')]
    public function eliminarTalle($key_color, $key_talle)
    {
        unset($this->talles[$key_color][$key_talle]);
        unset($this->stock[$key_color][$key_talle]);
    }

    #[On('agregarColor')]
    public function agregarColor()
    {
        $this->colores[] = '';
        $this->stock[] = [0 => []];
        $this->talles[] = [0 => []];
        $this->imagenes[] = [];
    }

    #[On('eliminarColor')]
    public function eliminarColor($key_color)
    {
        unset($this->colores[$key_color]);
        unset($this->talles[$key_color]);
        unset($this->stock[$key_color]);
        unset($this->imagenes[$key_color]);
    }

    public function crearVarianteConColorYTalles()
    {
        $data = $this->validate();
        // dd(array_key_last($data['imagenes']));
        
        //Guardamos las imagenes y el nombre genreado en un array
        $array_imagenes = [];
        for($i = 0; $i <= array_key_last($data['imagenes']); $i++){
            if(array_key_exists($i, $data['imagenes'])){
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
        }

        //Guardo cada variante del producto (talle) en la tabla correspondiente con la referencia al producto
        foreach($data['colores'] as $key_color => $color){
            foreach($data['talles'][$key_color] as $key_talle => $talle){
                $variante = ProductoVariante::create([
                    'producto_id' => $this->producto->id,
                    'color' => $color,
                    'talle' => $talle,
                    'stock' => $data['stock'][$key_color][$key_talle]
                ]);
    
                //Guardamos la referencia a las imagenes
                foreach($array_imagenes[$key_color] as $key_imagen => $imagen){
                    $variante_imagen = ProductoVarianteImagen::create([
                        'variante_id' => $variante->id,
                        'imagen' => $imagen
                    ]);
                    $variante_imagen->save();
                }
            }
        }

        //Mensaje a mostrar
        $this->dispatch('notificacionCreado');

        //redireccionamos al listado
        return redirect()->route('productos.index');
    }
    
    public function render()
    {
        return view('livewire.crear-variante-color-talle');
    }
}
