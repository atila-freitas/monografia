<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtigoPublicadoAutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigo_publicado_autor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('artigo_publicado_id')->unsigned();
            $table->integer('autor_id')->unsigned();
            $table->integer('ordem_autoria')->nullable();

            $table->foreign('artigo_publicado_id')
                ->references('id')->on('artigos_publicados')
                ->onDelete('cascade');
            $table->foreign('autor_id')
                ->references('id')->on('autores')
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
        Schema::dropIfExists('artigo_publicado_autor');
    }
}
