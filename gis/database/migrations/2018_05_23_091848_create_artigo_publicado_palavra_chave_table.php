<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtigoPublicadoPalavraChaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigo_publicado_palavra_chave', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('artigo_publicado_id')->unsigned();
            $table->integer('palavra_chave_id')->unsigned();

            $table->foreign('artigo_publicado_id')
                ->references('id')->on('artigos_publicados')
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
        Schema::dropIfExists('artigo_publicado_palavra_chave');
    }
}
