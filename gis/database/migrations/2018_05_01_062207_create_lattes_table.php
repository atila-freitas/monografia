<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLattesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lattes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id', 20);
            $table->integer('curso_faculdade_id')->unsigned()->nullable();
            $table->string('data_atualizacao');
            $table->string('hora_atualizacao');
            $table->string('nome_completo')->nullable();
            $table->text('nome_citacao')->nullable();
            $table->string('nacionalidade')->nullable();
            $table->string('pais_nacimento')->nullable();
            $table->string('uf_nascimento')->nullable();
            $table->string('cidade_nascimento')->nullable();
            $table->string('sigla_pais_nacionalidade')->nullable();
            $table->string('pais_nacionalidade')->nullable();
            $table->text('resumo_cv')->nullable();
            $table->text('resumo_cv_ingles')->nullable();
            $table->timestamps();

            $table->primary('id');

            $table->foreign('curso_faculdade_id')
                ->references('id')->on('cursos_faculdade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lattes');
    }
}
