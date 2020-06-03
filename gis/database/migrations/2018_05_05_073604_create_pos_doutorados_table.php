<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosDoutoradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_doutorados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('lattes_id', 20);
            $table->string('sequencia_formacao')->nullable();
            $table->string('nivel')->nullable();
            $table->string('codigo_instituicao')->nullable();
            $table->string('nome_instituicao')->nullable();
            $table->string('ano_inicio')->nullable();
            $table->string('ano_conclusao')->nullable();
            $table->string('ano_obtencao_titulo')->nullable();
            $table->string('flag_bolsa', 3)->nullable();
            $table->string('codigo_agencia')->nullable();
            $table->string('nome_agencia')->nullable();
            $table->string('status_estagio')->nullable();
            $table->string('status_curso')->nullable();
            $table->string('id_orientador')->nullable();
            $table->string('codigo_curso_capes')->nullable();
            $table->text('titulo_trabalho')->nullable();
            $table->text('titulo_trabalho_ingles')->nullable();
            $table->string('nome_curso_ingles')->nullable();
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
        Schema::dropIfExists('pos_doutorados');
    }
}
