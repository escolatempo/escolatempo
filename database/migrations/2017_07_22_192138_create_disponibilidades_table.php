<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisponibilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibilidades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('professor_id');
            $table->date('dia');
            $table->time('horario');
            $table->enum('status', ['comAula', 'livre', 'passado'])->default('livre');
            $table->unique(['professor_id', 'dia', 'horario']);
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
        Schema::dropIfExists('disponibilidades');
    }
}
