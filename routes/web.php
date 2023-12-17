<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Almacenes
    Route::get('/almacenes', [AlmacenController::class, 'index'])->name('almacenes.index');
    Route::get('/almacenes/create', [AlmacenController::class, 'create'])->name('almacenes.create');
    Route::get('/almacenes/{almacen}/edit', [AlmacenController::class, 'edit'])->name('almacenes.edit');
    Route::get('/almacenes/{almacen}', [AlmacenController::class, 'show'])->name('almacenes.show');

    //Marcas
    Route::get('/marcas', [MarcaController::class, 'index'])->name('marcas.index');
    Route::get('/marcas/create', [MarcaController::class, 'create'])->name('marcas.create');
    Route::get('/marcas/{marca}/edit', [MarcaController::class, 'edit'])->name('marcas.edit');

    //Categorias
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::get('/categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::get('/categorias/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');
    Route::get('/categorias/{categoria}/subcategorias', [CategoriaController::class, 'createSubcategoria'])->name('categorias.subcategorias');

    //Productos
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
    Route::get('/productos/{producto}/variantes', [ProductoController::class, 'variantes'])->name('productos.variantes');
    Route::get('/productos/{producto}/variantes/edit', [ProductoController::class, 'variantesEdit'])->name('productos.variantes.edit');

});


require __DIR__.'/auth.php';
