<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabalhosEmEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalhos_em_eventos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('lattes_id', 20);
            $table->string('natureza')->nullable();
            $table->text('titulo')->nullable();
            $table->text('titulo_ingles')->nullable();
            $table->string('ano')->nullable();
            $table->string('pais')->nullable();
            $table->string('idioma')->nullable();
            $table->string('meio_divulgacao')->nullable();
            $table->string('flag_relevancia', 3)->nullable();
            $table->string('flag_divulgacao_cientifica', 3)->nullable();
            $table->string('classificacao_evento')->nullable();
            $table->text('nome_evento')->nullable();
            $table->text('nome_evento_ingles')->nullable();
            $table->string('cidade_evento')->nullable();
            $table->string('ano_evento')->nullable();
            $table->text('titulo_anais_ou_proceedings')->nullable();
            $table->string('volume')->nullable();
            $table->string('fasciculo')->nullable();
            $table->string('serie')->nullable();
            $table->string('pagina_inicial')->nullable();
            $table->string('pagina_final')->nullable();
            $table->string('isbn')->nullable();
            $table->string('nome_editora')->nullable();
            $table->string('cidade_editora')->nullable();
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
        Schema::dropIfExists('trabalhos_em_eventos');
    }
}
