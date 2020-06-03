<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtigosPublicadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigos_publicados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('lattes_id', 20);
            $table->string('natureza')->nullable();
            $table->text('titulo_do_artigo')->nullable();
            $table->text('titulo_do_artigo_ingles')->nullable();
            $table->string('ano_do_artigo')->nullable();
            $table->string('pais_de_publicacao')->nullable();
            $table->string('idioma')->nullable();
            $table->string('flag_relevancia', 3)->nullable();
            $table->string('flag_divulgacao_cientifica', 3)->nullable();
            $table->string('meio_de_divulgacao')->nullable();
            $table->text('titulo_periodico_revista')->nullable();
            $table->string('issn')->nullable();
            $table->string('volume')->nullable();
            $table->string('fasciculo')->nullable();
            $table->string('pagina_inicial')->nullable();
            $table->string('pagina_final')->nullable();
            $table->string('local_publicacao')->nullable();
            $table->char('estrato', 2);
            $table->boolean('buscou_estrato')->default(false);
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
        Schema::dropIfExists('artigos_publicados');
    }
}

//	CPF CDATA  #IMPLIED
//  NRO-ID-CNPQ CDATA  #IMPLIED
//  DESCRICAO-INFORMACOES-ADICIONAIS-INGLES CDATA
//  TITULO-DO-ARTIGO CDATA  #IMPLIED
//	ANO-DO-ARTIGO CDATA  #IMPLIED
//	PAIS-DE-PUBLICACAO CDATA  #IMPLIED
//	IDIOMA CDATA  #IMPLIED
//	MEIO-DE-DIVULGACAO (IMPRESSO | WEB | MEIO_MAGNETICO | MEIO_DIGITAL | FILME | HIPERTEXTO | OUTRO | VARIOS | NAO_INFORMADO) "NAO_INFORMADO"
//  TITULO-DO-ARTIGO-INGLES CDATA