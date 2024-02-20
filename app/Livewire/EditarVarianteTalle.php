<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\ProductoVariante;
use App\Models\ProductoVarianteImagen;
use Illuminate\Support\Facades\Storage;

class EditarVarianteTalle extends Component
{
    public Producto $producto;
    public $talles = [];
    public $stock = [];
    public $imagenes = [];
    public $imagenes_nuevas = [];
    public $imagenes_cargadas = [];
    public $imagenes_eliminar = [];

    use WithFileUploads;

    protected $rules = [
        'talles.*' => 'required|string',
        'stock.*' => 'required|numeric|min:0',
        'imagenes.*' => 'nullable|image|max:2048'
    ];

    public function mount(Producto $producto)
    {
        $producto_variantes = ProductoVariante::where('producto_id', $producto->id)->get();
        foreach($producto_variantes as $variante){
            $this->talles[] = $variante->talle;
            $this->stock[] = $variante->stock;
        }
        foreach($producto_variantes[0]->imagenes as $imagen){
            $this->imagenes_cargadas[] = $imagen->imagen;
        }
    }

    #[On('agregarTalle')]
    public function agregarTalle()
    {
        $this->talles[] = '';
        $this->stock[] = '';
    }

    public function updatedImagenes()
    {
        // Agrega las nuevas imágenes al arreglo de imágenes cargadas
        foreach ($this->imagenes as $imagen) {
            $this->imagenes_nuevas[] = $imagen;
        }
    }


    #[On('eliminarTalle')]
    public function eliminarTalle($key)
    {
        unset($this->talles[$key]);
        unset($this->stock[$key]);
        
    }

    //Elimina las imagenes de un array o del otro
    #[On('eliminarImagen')]
    public function eliminarImagen($key, $tipo)
    {
        if($tipo == 'cargada'){
            $this->imagenes_eliminar[] = $this->imagenes_cargadas[$key];
            unset($this->imagenes_cargadas[$key]);
        } else {
            $this->imagenes_eliminar[] = $this->imagenes_nuevas[$key];
            unset($this->imagenes_nuevas[$key]);
        }
    }

    public function editarVarianteTalle()
    {
        $data = $this->validate();

        //Guardamos las imagenes y el nombre genereado en un array
        $array_imagenes = [];
        if(count($this->imagenes_nuevas) > 0){
            foreach($this->imagenes_nuevas as $imagen){
                $nombre_imagen = null;
                if($imagen != ''){
                    $imagen = $imagen->store('public/productos');
                    $nombre_imagen = str_replace('public/productos/', '', $imagen);
                }
                array_push($array_imagenes, $nombre_imagen);
            }
        } else {
            if(count($this->imagenes_cargadas) == 0){
                //Mensaje a mostrar
                $this->dispatch('notificacionImagen');
                return true;
            }
        }

        //Elimino las variantes que no correspondan
        ProductoVariante::where('producto_id',$this->producto->id)->whereNotIn('talle',$data['talles'])->delete();

        //Elimino las imagenes que no correspondan
        ProductoVarianteImagen::whereIn('imagen',$this->imagenes_eliminar)->delete();
        foreach ($this->imagenes_eliminar as $nombreImagen) {
            Storage::delete('public/productos/' . $nombreImagen);
        }

        //Guardo cada variante del producto (talle) en la tabla correspondiente con la referencia al producto
        foreach($data['talles'] as $key => $talle){
            $variante = ProductoVariante::where('producto_id', $this->producto->id)->where('talle', $talle)->first();
            if($variante){
                $variante->stock = $data['stock'][$key];
                $variante->save();
            } else {
                $variante = ProductoVariante::create([
                    'producto_id' => $this->producto->id,
                    'talle' => $talle,
                    'stock' => $data['stock'][$key]
                ]);
            }

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
        $this->dispatch('notificacionEditado');

        //redireccionamos al listado
        return redirect()->route('productos.index');
    }

    public function render()
    {
        return view('livewire.editar-variante-talle');
    }
}
