<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidenciasMedicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residencias_medicas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('lattes_id', 20);
            $table->string('sequencia_formacao')->nullable();
            $table->string('nivel')->nullable();
            $table->string('codigo_instituicao')->nullable();
            $table->string('nome_instituicao')->nullable();
            $table->string('status_curso')->nullable();
            $table->string('ano_inicio')->nullable();
            $table->string('ano_conclusao')->nullable();
            $table->string('flag_bolsa', 3)->nullable();
            $table->string('codigo_agencia')->nullable();
            $table->string('nome_agencia')->nullable();
            $table->text('titulo_residencia_medica')->nullable();
            $table->text('titulo_residencia_medica_ingles')->nullable();
            $table->string('numero_registro')->nullable();
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
        Schema::dropIfExists('residencias_medicas');
    }
}
