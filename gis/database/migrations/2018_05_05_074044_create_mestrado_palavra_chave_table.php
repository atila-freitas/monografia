<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMestradoPalavraChaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mestrado_palavra_chave', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('mestrado_id')->unsigned();
            $table->integer('palavra_chave_id')->unsigned();

            $table->foreign('mestrado_id')
                ->references('id')->on('mestrados')
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
        Schema::dropIfExists('mestrado_palavra_chave');
    }
}
