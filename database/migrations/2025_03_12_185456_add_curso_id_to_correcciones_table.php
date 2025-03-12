<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('correcciones', function (Blueprint $table) {
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('correcciones', function (Blueprint $table) {
            $table->dropForeign(['curso_id']);
            $table->dropColumn('curso_id');
        });
    }
};
