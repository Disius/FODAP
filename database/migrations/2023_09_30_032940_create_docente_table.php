<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docente', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('rfc', 50)->nullable();
            $table->string('curp', 45)->nullable();
            $table->string('nombre', 60)->nullable();
            $table->string('apellidoPat', 60)->nullable();
            $table->string('apellidoMat', 60)->nullable();
            $table->bigInteger('sexo')->nullable();
            $table->string('telefono', 45)->nullable();
            $table->tinyInteger('interno')->nullable();
            $table->unsignedBigInteger('carrera_id')->nullable()->index('fk_docente_carrera1_idx');
            $table->bigInteger('id_posgrado')->nullable()->index('fk_docente_posgrado1_idx');
            $table->bigInteger('id_puesto')->nullable()->index('fk_Docente_Puesto1_idx');
            $table->string('clavePresup', 45)->nullable();
            $table->time('horarioEntrada')->nullable();
            $table->time('horarioSalida')->nullable();
            $table->bigInteger('tipo_plaza')->nullable()->index('fk_docente_tipoPlaza');
            $table->string('licenciatura', 60)->nullable()->index('fk_Docente_Nivel1_idx');
            $table->string('prodep', 45)->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable()->index('fk_Docente_Departamento1_idx');
            $table->string('empresa', 75)->nullable();
            $table->string('tipodecurso')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id_foreign');
            $table->timestamps();
            $table->string('nombre_completo')->nullable();
            
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docente');
    }
}
