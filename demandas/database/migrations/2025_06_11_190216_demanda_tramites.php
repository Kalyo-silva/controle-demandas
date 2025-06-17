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
        Schema::create('demanda_tramites', function (Blueprint $table) {
            $table->id();
            $table->integer('demanda_id')->unsigned();
            $table->text('complemento');
            $table->string('anexo')->nullable();
            $table->integer('user_id_tramitou')->unsigned();
            $table->integer('user_id_tramitado')->unsigned();
            $table->timestamp('data_tramite');
            $table->timestamp('data_atualizado');

            $table->foreign('demanda_id')->references('id')->on('demandas');
            $table->foreign('user_id_tramitou')->references('id')->on('users');
            $table->foreign('user_id_tramitado')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demanda_tramites');
    }
};
