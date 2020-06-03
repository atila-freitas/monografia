<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosDoutoradoPalavraChaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_doutorado_palavra_chave', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pos_doutorado_id')->unsigned();
            $table->integer('palavra_chave_id')->unsigned();

            $table->foreign('pos_doutorado_id')
                ->references('id')->on('pos_doutorados')
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
        Schema::dropIfExists('pos_doutorado_palavra_chave');
    }
}
