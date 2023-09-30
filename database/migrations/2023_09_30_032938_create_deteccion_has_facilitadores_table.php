<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeteccionHasFacilitadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deteccion_has_facilitadores', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('deteccion_id')->nullable()->index('deteccion_has_facilitadores_deteccion_id_foreign');
            $table->unsignedBigInteger('docente_id')->nullable()->index('deteccion_has_facilitadores_docente_id_foreign');
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
        Schema::dropIfExists('deteccion_has_facilitadores');
    }
}
