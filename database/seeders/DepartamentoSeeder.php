<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamento')->insert([
            ['nameDepartamento' => 'Departamento de Ciencias Básicas' , 'jefe_id' => 9],
            ['nameDepartamento' => 'Departamento de Desarrollo Académico', 'jefe_id' => 1],
            ['nameDepartamento' => 'Departamento de Ingeniería Eléctrica y Electrónica', 'jefe_id' => 2],
            ['nameDepartamento' => 'Departamento de Ingeniería Industrial', 'jefe_id' => 3],
            ['nameDepartamento' => 'Departamento de Metal Mecánica', 'jefe_id' => 4],
            ['nameDepartamento' => 'Departamento de Ingeniería Química y Bioquímica', 'jefe_id' => 5],
            ['nameDepartamento' => 'Departamento de Sistemas y Computación', 'jefe_id' => 6],
            ['nameDepartamento' => 'Departamento Económico Administrativo', 'jefe_id' => 7],
            ['nameDepartamento' => 'Departamento de Ingenierías', 'jefe_id' => 8]
        ]);
    }
}
