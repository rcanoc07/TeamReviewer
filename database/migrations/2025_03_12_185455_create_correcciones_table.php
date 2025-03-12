<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreccionesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('correcciones', function (Blueprint $table) {
            $table->id(); // ID de la corrección
            $table->foreignId('respuesta_id')->constrained()->onDelete('cascade'); // Relación con la tabla respuestas
            $table->text('evaluacion'); // Almacena la evaluación generada por la IA
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('correcciones');
    }
}
