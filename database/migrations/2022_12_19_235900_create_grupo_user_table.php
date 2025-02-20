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
        Schema::create('grupo_user', function (Blueprint $table) {
            $table->unsignedBigInteger("grupo_id");
            $table->foreign('grupo_id')->references('id')->on('grupos')->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onUpdate("cascade")->onDelete("cascade");
            $table->primary(["grupo_id", "user_id"]);
            $table->unsignedBigInteger("amigo_id")->nullable();
            $table->foreign("amigo_id")->references('id')->on('users')->onUpdate("cascade")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupo_user');
    }
};
