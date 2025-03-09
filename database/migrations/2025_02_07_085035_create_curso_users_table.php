<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursoUsersTable extends Migration
{
    public function up()
    {
        Schema::create('curso_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con el alumno (usuario)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curso_users');
    }
}
