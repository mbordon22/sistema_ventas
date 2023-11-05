<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('almacenes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ubicacion');
            $table->string('telefono');
            $table->string('contacto_nombre')->nullable();
            $table->string('contacto_email')->nullable();
            $table->longText('descripcion')->nullable();
            $table->integer('capacidad')->nullable();
            $table->enum('tipo', ['Local', 'Almacén central', 'Sucursal', 'Otros']);
            $table->integer('habilitado')->default(1);
            $table->point('coordenadas')->nullable(); // Campo para la dirección GPS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacenes');
    }
};
