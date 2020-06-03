<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoutoradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doutorados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('lattes_id', 20);
            $table->string('sequencia_formacao')->nullable();
            $table->string('nivel')->nullable();
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
            $table->string('ano_obtencao_titulo')->nullable();
            $table->text('titulo_dissertacao_tese')->nullable();
            $table->text('titulo_dissertacao_tese_ingles')->nullable();
            $table->string('nome_completo_orientador')->nullable();
            $table->string('tipo_doutorado')->nullable();
            $table->string('codigo_instituicao_dout')->nullable();
            $table->string('nome_instituicao_dout')->nullable();
            $table->string('codigo_instituicao_outra_dout')->nullable();
            $table->string('nome_instituicao_outra_dout')->nullable();
            $table->string('nome_orientador_dout')->nullable();
            $table->string('id_orientador')->nullable();
            $table->string('codigo_curso_capes')->nullable();
            $table->string('nome_orientador_co_tutela')->nullable();
            $table->string('codigo_instituicao_co_tutela')->nullable();
            $table->string('codigo_instituicao_outra_co_tutela')->nullable();
            $table->string('nome_orientador_sanduiche')->nullable();
            $table->string('codigo_instituicao_sanduiche')->nullable();
            $table->string('codigo_instituicao_outra_sanduiche')->nullable();
            $table->string('nome_co_orientador')->nullable();
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
        Schema::dropIfExists('doutorados');
    }
}
