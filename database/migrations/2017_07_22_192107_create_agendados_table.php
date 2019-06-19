<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendados', function (Blueprint $table) {
            $table->increments('id');
            $table->date('dia');
            $table->time('horario');
            $table->enum('sala', [1,2,3]);
            $table->text('observacao')->nullable(true);
            $table->integer('professor_id');
            $table->integer('aluno_id');
            $table->integer('materia_id');
            $table->enum('status',['agendado', 'cancelado', 'dada'])->default('agendado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendados');
    }
}
