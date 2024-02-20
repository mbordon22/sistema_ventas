<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\ProductoVariante;
use App\Models\ProductoVarianteImagen;
use Illuminate\Support\Facades\Storage;

class EditarVarianteColor extends Component
{
    public Producto $producto;
    public $stock = [];
    public $colores = [];
    public $imagenes = [[]];
    public $imagenes_nuevas = [[]];
    public $imagenes_cargadas = [];
    public $imagenes_eliminar = [];

    use WithFileUploads;

    public function mount(Producto $producto)
    {
        $producto_variantes = ProductoVariante::where('producto_id', $producto->id)->get();
        
        foreach($producto_variantes as $variante){
            $this->colores[] = $variante->color;
            $this->stock[] = $variante->stock;
        }
        foreach($producto_variantes as $variante){
            $this->imagenes_cargadas[] = $variante->imagenes()->pluck('imagen')->toArray();
        }
    }

    protected $rules = [
        'colores.*' => 'required|string',
        'stock.*' => 'required|numeric|min:0'
    ];

    public function updatedImagenes()
    {
        // Agrega las nuevas imágenes al arreglo de imágenes cargadas
        foreach ($this->imagenes as $key => $imagen) {
            if(count($imagen) > 0){
                if(isset($this->imagenes_nuevas[$key])){
                    $this->imagenes_nuevas[$key] = array_merge($this->imagenes_nuevas[$key], $imagen);
                    unset($this->imagenes[$key]);
                } else {
                    $this->imagenes_nuevas[$key] = $imagen;
                    unset($this->imagenes[$key]);
                }
            }
        }
    }

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

    //Elimina las imagenes de un array o del otro
    #[On('eliminarImagen')]
    public function eliminarImagen($key, $keyImagen, $tipo)
    {
        if($tipo == 'cargada'){
            $this->imagenes_eliminar[] = $this->imagenes_cargadas[$key][$keyImagen];
            unset($this->imagenes_cargadas[$key][$keyImagen]);
        } else {
            $this->imagenes_eliminar[] = $this->imagenes_nuevas[$key][$keyImagen];
            unset($this->imagenes_nuevas[$key][$keyImagen]);
        }
    }

    public function editarVarianteColor()
    {
        $data = $this->validate();

        //Guardamos las imagenes y el nombre genreado en un array
        $array_imagenes = [];
        for($i = 0; $i <= array_key_last($this->imagenes_nuevas); $i++){
            if(!isset($this->imagenes_nuevas[$i]) || count($this->imagenes_nuevas[$i]) == 0){
                if(!isset($this->imagenes_cargadas[$i]) || count($this->imagenes_cargadas[$i]) == 0){
                    //Mensaje a mostrar
                    $this->dispatch('notificacionImagen');
                    return true;
                }
            }

            if(isset($this->imagenes_nuevas[$i]) && count($this->imagenes_nuevas[$i]) > 0){
                $imagenes_variante = $this->imagenes_nuevas[$i];
    
                for($j = 0; $j < count($imagenes_variante); $j++){
                    $imagen = $imagenes_variante[$j];
                    $nombre_imagen = null;
                    if($imagen != ''){
                        $imagen = $imagen->store('public/productos');
                        $nombre_imagen = str_replace('public/productos/', '', $imagen);
                    }

                    $array_imagenes[$i][] = $nombre_imagen;
                }
            }
        }

        for ($i=0; $i < count($this->imagenes_cargadas); $i++) { 
            if(!isset($this->imagenes_cargadas[$i]) || count($this->imagenes_cargadas[$i]) == 0){
                if(!isset($this->imagenes_nuevas[$i]) || count($this->imagenes_nuevas[$i]) == 0){
                    //Mensaje a mostrar
                    $this->dispatch('notificacionImagen');
                    return true;
                }
            }        
        }


        //Elimino las variantes que no correspondan
        ProductoVariante::where('producto_id',$this->producto->id)->whereNotIn('color',$data['colores'])->delete();

        //Elimino las imagenes que no correspondan
        ProductoVarianteImagen::whereIn('imagen',$this->imagenes_eliminar)->delete();
        foreach ($this->imagenes_eliminar as $nombreImagen) {
            Storage::delete('public/productos/' . $nombreImagen);
        }


        //Guardo cada variante del producto (color) en la tabla correspondiente con la referencia al producto
        foreach($data['colores'] as $key => $color){
            $variante = ProductoVariante::where('producto_id', $this->producto->id)->where('color', $color)->first();
            if($variante){
                $variante->stock = $data['stock'][$key];
                $variante->save();
            } else {
                $variante = ProductoVariante::create([
                    'producto_id' => $this->producto->id,
                    'color' => $color,
                    'stock' => $data['stock'][$key]
                ]);
            }

            //Guardamos la referencia a las imagenes
            if(isset($array_imagenes[$key])){
                foreach($array_imagenes[$key] as $key_imagen => $imagen){
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
        return view('livewire.editar-variante-color');
    }
}
