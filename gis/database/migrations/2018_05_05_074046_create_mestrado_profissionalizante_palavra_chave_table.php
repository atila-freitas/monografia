<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMestradoProfissionalizantePalavraChaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mestrado_profissionalizante_palavra_chave', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('mestrado_profissionalizante_id')->unsigned();
            $table->integer('palavra_chave_id')->unsigned();

            $table->foreign('mestrado_profissionalizante_id', 'mest_prof_palavra_mest_id_foreign')
                ->references('id')->on('mestrados_profissionalizantes')
                ->onDelete('cascade');
            $table->foreign('palavra_chave_id', 'mest_prof_palavra_chave_id_foreign')
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
        Schema::dropIfExists('mestrado_profissionalizante_palavra_chave');
    }
}
