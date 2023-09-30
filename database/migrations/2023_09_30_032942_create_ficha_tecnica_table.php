<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaTecnicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficha_tecnica', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('id_curso');
            $table->longText('introduccion');
            $table->longText('justificacion');
            $table->longText('objetivo_general');
            $table->longText('temas');
            $table->longText('subtemas');
            $table->longText('actividades_aprendizaje');
            $table->longText('elementos_didacticos');
            $table->text('criterio_evaluacion');
            $table->text('competencias');
            $table->text('bibliografia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ficha_tecnica');
    }
}
