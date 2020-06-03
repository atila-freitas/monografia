<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoutoradoPalavraChaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doutorado_palavra_chave', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('doutorado_id')->unsigned();
            $table->integer('palavra_chave_id')->unsigned();

            $table->foreign('doutorado_id')
                ->references('id')->on('doutorados')
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
        Schema::dropIfExists('doutorado_palavra_chave');
    }
}
