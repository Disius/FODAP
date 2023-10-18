<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeteccionNecesidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deteccion_necesidades', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->unsignedBigInteger('id_jefe')->nullable()->index('jefe_id_foreign');
            $table->string('asignaturaFA', 500);
            $table->string('contenidosTM', 500);
            $table->integer('numeroProfesores');
            $table->integer('periodo');
            $table->unsignedBigInteger('carrera_dirigido')->index('carrera_id_foreign');
            $table->bigInteger('id_departamento')->nullable();
            $table->string('nombreCurso', 500);
            $table->integer('tipo_FDoAP')->nullable();
            $table->integer('tipo_actividad')->nullable();
            $table->date('fecha_I');
            $table->date('fecha_F');
            $table->time('hora_I');
            $table->time('hora_F');
            $table->bigInteger('total_horas')->nullable();
            $table->string('objetivoEvento', 500);
            $table->bigInteger('modalidad')->nullable();
            $table->bigInteger('id_lugar')->nullable();
            $table->string('facilitador_externo', 500)->nullable();
            $table->string('observaciones', 500)->nullable();
            $table->integer('obs')->nullable();
            $table->integer('aceptado')->nullable();
            $table->bigInteger('estado')->nullable();
            $table->date('anio_realizacion')->nullable();
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
        Schema::dropIfExists('deteccion_necesidades');
    }
}
