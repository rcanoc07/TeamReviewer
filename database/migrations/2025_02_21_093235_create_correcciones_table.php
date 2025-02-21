<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreccionesTable extends Migration
{
    public function up()
    {
        Schema::create('correcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('rubrica_id')->constrained('rubricas')->onDelete('cascade');
            $table->integer('puntuacion');
            $table->text('comentarios');
            $table->json('detalles_correccion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('correcciones');
    }
}
