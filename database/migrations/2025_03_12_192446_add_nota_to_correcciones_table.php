<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaToCorreccionesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('correcciones', function (Blueprint $table) {
            $table->decimal('nota', 5, 2)->nullable(); // Campo para la nota (puede ser nulo)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('correcciones', function (Blueprint $table) {
            $table->dropColumn('nota'); // Eliminar el campo si se revierte la migración
        });
    }
}
