<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabalhoEmEventoAutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalho_em_evento_autor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('trabalho_em_evento_id')->unsigned();
            $table->integer('autor_id')->unsigned();
            $table->integer('ordem_autoria')->nullable();

            $table->foreign('trabalho_em_evento_id', 'trab_event_aut_trab_id_foreign')
                ->references('id')->on('trabalhos_em_eventos')
                ->onDelete('cascade');
            $table->foreign('autor_id', 'trab_event_aut_autor_id_foreign')
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
        Schema::dropIfExists('trabalho_em_evento_autor');
    }
}
