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
            $table->longText('introduccion');
            $table->longText('justificacion');
            $table->longText('objetivo_general');
            $table->longText('descripcion_servicio')->nullable();
            $table->integer('tipo_servicio');
            $table->integer('duracion');
            $table->longText('elementos_didacticos');
            $table->longText('competencias_desarrollar');
            $table->longText('fuentes_informacion');
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
