<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosFaculdadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos_faculdade', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('centro_faculdade_id')->unsigned()->nullable();;
            $table->string('nome', 30);
            $table->timestamps();

            $table->foreign('centro_faculdade_id')
                ->references('id')->on('centros_faculdades')
                ->onDelete('set null');

            $table->unique(['centro_faculdade_id', 'nome']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos_faculdade');
    }
}
