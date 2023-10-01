<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carreras')->insert([
            ['nameCarrera' => 'Ingeniería Mecánica'],
            ['nameCarrera' => 'Ingeniería en Sistemas Computacionales'],
            ['nameCarrera' => 'Ingeniería Industrial'],
            ['nameCarrera' => 'Ingeniería Electrónica'],
            ['nameCarrera' => 'Ingeniería Eléctrica'],
            ['nameCarrera' => 'Ingeniería Bioquímica'],
            ['nameCarrera' => 'Ingeniería Química'],
            ['nameCarrera' => 'Ingeniería en Gestión Empresarial'],
            ['nameCarrera' => 'Ingeniería en Logística'],
            ['nameCarrera' => 'Ingeniería en Mecatrónica'],
            ['nameCarrera' => 'Ciencias Basicas'],
            ['nameCarrera' => 'Ciencias Economico Administrativo'],
            ['nameCarrera' => 'Todas las carreras'],
        ]);
    }
}
