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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("importe");
            $table->date("fechasorteo");
            $table->date("fechaentregaregalos");
            $table->date("fechasorteoreal")->nullable();
            $table->string("comentario")->nullable();
            $table->string("codigoacceso")->unique();
            $table->integer("estado")->default(0);
            $table->unsignedBigInteger("propietario_id");
            $table->foreign("propietario_id")->on("users")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     *             $table->foreignIdFor(User::class)->constrained()
    ->onUpdate('cascade')
    ->onDelete('cascade');
     */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupos');
    }
};
