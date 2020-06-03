<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabalhoEmEventoPalavraChaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalho_em_evento_palavra_chave', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('trabalho_em_evento_id')->unsigned();
            $table->integer('palavra_chave_id')->unsigned();

            $table->foreign('trabalho_em_evento_id', 'trab_event_palavra_trab_id_foreign')
                ->references('id')->on('trabalhos_em_eventos')
                ->onDelete('cascade');
            $table->foreign('palavra_chave_id', 'trab_event_palavra_chave_id_foreign')
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
        Schema::dropIfExists('trabalho_em_evento_palavra_chave');
    }
}
