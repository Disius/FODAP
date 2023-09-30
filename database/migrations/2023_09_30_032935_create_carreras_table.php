<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('nameCarrera', 60);
            $table->unsignedBigInteger('jefe_departamento')->nullable()->index('carreras_jefe_departamento_foreign');
            $table->unsignedBigInteger('presidente_academia')->nullable()->index('carreras_presidente_academia_foreign');
            $table->unsignedBigInteger('departamento_id')->nullable()->index('carreras_departamento_id_foreign');
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
        Schema::dropIfExists('carreras');
    }
}
