<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapituloDeLivroPublicadoPalavraChaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitulo_de_livro_publicado_palavra_chave', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('capitulo_de_livro_publicado_id')->unsigned();
            $table->integer('palavra_chave_id')->unsigned();

            $table->foreign('capitulo_de_livro_publicado_id', 'cap_livro_pal_cap_id_foreign')
                ->references('id')->on('capitulos_de_livros_publicados')
                ->onDelete('cascade');
            $table->foreign('palavra_chave_id', 'cap_livro_pub_pal_pal_id_foreign')
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
        Schema::dropIfExists('capitulo_de_livro_publicado_palavra_chave');
    }
}
