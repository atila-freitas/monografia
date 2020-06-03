<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitulosDeLivrosPublicadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitulos_de_livros_publicados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('lattes_id', 20);
            $table->string('tipo')->nullable();
            $table->text('titulo_do_capitulo_do_livro')->nullable();
            $table->string('ano')->nullable();
            $table->string('pais_de_publicacao')->nullable();
            $table->string('idioma')->nullable();
            $table->string('meio_de_divulgacao')->nullable();
            $table->string('flag_relevancia')->nullable();
            $table->string('flag_divulgacao_cientifica')->nullable();
            $table->text('titulo_do_livro')->nullable();
            $table->string('cidade_da_editora')->nullable();
            $table->string('nome_da_editora')->nullable();
            $table->timestamps();

            $table->foreign('lattes_id')
                ->references('id')->on('lattes')
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
        Schema::dropIfExists('capitulos_de_livros_publicados');
    }
}
