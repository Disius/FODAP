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
            ['nameCarrera' => 'Ingeniería Mecánica', 'departamento_id' => 5],
            ['nameCarrera' => 'Ingeniería en Sistemas Computacionales', 'departamento_id' => 7],
            ['nameCarrera' => 'Ingeniería Industrial', 'departamento_id' => 4],
            ['nameCarrera' => 'Ingeniería Electrónica', 'departamento_id' => 3],
            ['nameCarrera' => 'Ingeniería Eléctrica', 'departamento_id' => 3],
            ['nameCarrera' => 'Ingeniería Bioquímica', 'departamento_id' => 6],
            ['nameCarrera' => 'Ingeniería Química', 'departamento_id' => 6],
            ['nameCarrera' => 'Ingeniería en Gestión Empresarial', 'departamento_id' => 9],
            ['nameCarrera' => 'Ingeniería en Logística', 'departamento_id' => 9],
            ['nameCarrera' => 'Ingeniería en Mecatrónica', 'departamento_id' => 3],
            ['nameCarrera' => 'Ciencias Basicas', 'departamento_id' => 1],
            ['nameCarrera' => 'Ciencias Economico Administrativo' , 'departamento_id' => 8],
            ['nameCarrera' => 'Todas las carreras', 'departamento_id' => null],
        ]);
    }
}
