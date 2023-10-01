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
            ['nameDepartamento' => 'Departamento de Ciencias Básicas'],
            ['nameDepartamento' => 'Departamento de Desarrollo Académico'],
            ['nameDepartamento' => 'Departamento de Ingeniería Eléctrica y Electrónica'],
            ['nameDepartamento' => 'Departamento de Ingeniería Industrial'],
            ['nameDepartamento' => 'Departamento de Metal Mecánica'],
            ['nameDepartamento' => 'Departamento de Ingeniería Química y Bioquímica'],
            ['nameDepartamento' => 'Departamento de Sistemas y Computación'],
            ['nameDepartamento' => 'Departamento Económico Administrativo'],
            ['nameDepartamento' => 'Departamento de Ingenierías']
        ]);
    }
}
