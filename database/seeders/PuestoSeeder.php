<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('puesto')->insert([
            ['nombre' => 'ADMINISTRATIVO'],
            ['nombre' => 'JEFE DE DEPARTAMENTO'],
            ['nombre' => 'DOCENTE'],
            ['nombre' => 'DIRECTOR'],
            ['nombre' => 'SUBDIRECCIÓN DE PLANEACIÓN Y VINCULACIÓN'],
            ['nombre' => 'SUBDIRECCIÓN DE SERVICIOS ADMINISTRATIVOS'],
            ['nombre' => 'AUXILIAR ADMINISTRATIVO'],
            ['nombre' => 'SUBDIRECCIÓN ACADÉMICA']
        ]);
    }
}
