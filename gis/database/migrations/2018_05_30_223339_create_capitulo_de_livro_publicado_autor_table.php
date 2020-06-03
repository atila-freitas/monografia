<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapituloDeLivroPublicadoAutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitulo_de_livro_publicado_autor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('capitulo_de_livro_publicado_id')->unsigned();
            $table->integer('autor_id')->unsigned();
            $table->integer('ordem_autoria')->nullable();

            $table->foreign('capitulo_de_livro_publicado_id', 'cap_livro_autor_cap_id_foreign')
                ->references('id')->on('capitulos_de_livros_publicados')
                ->onDelete('cascade');
            $table->foreign('autor_id', 'cap_livro_autor_autor_id_foreign')
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
        Schema::dropIfExists('capitulo_de_livro_publicado_autor');
    }
}
