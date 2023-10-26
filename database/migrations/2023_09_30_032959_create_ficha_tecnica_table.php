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
            $table->id();
            $table->unsignedBigInteger('id_curso');
            $table->string('introduccion');
            $table->string('justificacion');
            $table->string('objetivo_general');
            $table->string('descripcion_servicio');
            $table->string('elementos_didacticos');
            $table->string('competencias_desarrollar');
            $table->string('fuentes_informacion');
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
        Schema::dropIfExists('ficha_tecnica');
    }
}
