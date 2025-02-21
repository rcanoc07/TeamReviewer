<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasesTable extends Migration
{

    public function up() {
        Schema::create('clases', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->foreignId('profesor_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
        });
   }

    public function down() {
        Schema::dropIfExists('clases');
    }
};
