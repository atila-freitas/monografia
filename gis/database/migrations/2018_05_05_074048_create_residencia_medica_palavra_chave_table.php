<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidenciaMedicaPalavraChaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residencia_medica_palavra_chave', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('residencia_medica_id')->unsigned();
            $table->integer('palavra_chave_id')->unsigned();

            $table->foreign('residencia_medica_id')
                ->references('id')->on('residencias_medicas')
                ->onDelete('cascade');
            $table->foreign('palavra_chave_id')
                ->references('id')->on('palavras_chave')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residencia_medica_palavra_chave');
    }
}
