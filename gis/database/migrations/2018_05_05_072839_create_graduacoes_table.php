<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraduacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduacoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('lattes_id', 20);
            $table->string('sequencia_formacao')->nullable();
            $table->string('nivel')->nullable();
            $table->text('titulo_trabalho_conclusao')->nullable();
            $table->text('titulo_trabalho_conclusao_ingles')->nullable();
            $table->string('nome_orientador')->nullable();
            $table->string('codigo_instituicao')->nullable();
            $table->string('nome_instituicao')->nullable();
            $table->string('codigo_orgao')->nullable();
            $table->string('nome_orgao')->nullable();
            $table->string('codigo_curso')->nullable();
            $table->string('nome_curso')->nullable();
            $table->string('nome_curso_ingles')->nullable();
            $table->string('codigo_area_curso')->nullable();
            $table->string('status_curso')->nullable();
            $table->string('ano_inicio')->nullable();
            $table->string('ano_conclusao')->nullable();
            $table->string('flag_bolsa', 3)->nullable();
            $table->string('codigo_agencia')->nullable();
            $table->string('nome_agencia')->nullable();
            $table->string('id_orientador')->nullable();
            $table->string('codigo_curso_capes')->nullable();
            $table->string('titulacao')->nullable();
            $table->string('tipo_graduacao')->nullable();
            $table->string('codigo_instituicao_grad')->nullable();
            $table->string('nome_instituicao_grad')->nullable();
            $table->string('codigo_instituicao_outra_grad')->nullable();
            $table->string('nome_instituicao_outra_grad')->nullable();
            $table->string('nome_orientador_grad')->nullable();
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
        Schema::dropIfExists('graduacoes');
    }
}
