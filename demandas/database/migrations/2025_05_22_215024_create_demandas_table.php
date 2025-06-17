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
        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('user_id_atual')->unsigned();
            $table->string('titulo');
            $table->integer('situacao');
            $table->timestamp('data_abertura');
            $table->timestamp('data_atualizado');

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_id_atual')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandas');
    }
};
