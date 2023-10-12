<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('docente')->insert([
            ['nombre' => 'Salvador', 'apellidoPat' => 'Hernández', 'apellidoMat' => 'Garduza', 'user_id' => 1, 'nombre_completo' => 'Salvador Hernández Garduza', 'carrera_id'],
            ['nombre' => 'Karlos', 'apellidoPat' => 'Velázquez', 'apellidoMat' => 'Moreno', 'user_id' => 2, 'nombre_completo' => 'Karlos Velázquez Moreno'],
            ['nombre' => 'Carlos Venturino', 'apellidoPat' => 'de Coss', 'apellidoMat' => 'Pérez', 'user_id' => 3, 'nombre_completo' => 'Carlos Venturino de Coss Pérez'],
            ['nombre' => 'José Manuel', 'apellidoPat' => 'Rasgado', 'apellidoMat' => 'Bezares', 'user_id' => 4, 'nombre_completo' => 'José Manuel Rasgado Bezares'],
            ['nombre' => 'María Magdalena', 'apellidoPat' => 'Pérez', 'apellidoMat' => 'Salgado', 'user_id' => 5, 'nombre_completo' => 'María Magdalena Pérez Salgado'],
            ['nombre' => 'María Guadalupe', 'apellidoPat' => 'Monjarás', 'apellidoMat' => 'Velasco', 'user_id' => 6, 'nombre_completo' => 'María Guadalupe Monjarás Velasco'],
            ['nombre' => 'Adriana', 'apellidoPat' => 'Meza', 'apellidoMat' => 'León', 'user_id' => 7, 'nombre_completo' => 'Adriana Meza León'],
            ['nombre' => 'Gilberto', 'apellidoPat' => 'Hernández', 'apellidoMat' => 'Cruz', 'user_id' => 8, 'nombre_completo' => 'Gilberto Hernández Cruz'],
            ['nombre' => 'María Catalina', 'apellidoPat' => 'Salgado', 'apellidoMat' => 'Gutiérrez', 'user_id' => 9, 'nombre_completo' => 'María Catalina Salgado Gutiérrez'],
            ['nombre' => 'Adriana Cristina', 'apellidoPat' => 'Bonifaz', 'apellidoMat' => 'Hernández', 'user_id' => 10, 'nombre_completo' => 'Adriana Cristina Bonifaz Hernández'],
        ]);
    }
}
