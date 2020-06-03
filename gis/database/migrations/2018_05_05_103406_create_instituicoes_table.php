<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituicoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituicoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id', 15);
            $table->string('sigla')->nullable();
            $table->string('sigla_uf', 10)->nullable();
            $table->string('sigla_pais', 10)->nullable();
            $table->string('nome_pais')->nullable();
            $table->string('flag_instituicao_ensino', 3)->nullable();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instituicoes');
    }
}
