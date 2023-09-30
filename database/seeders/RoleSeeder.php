<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Jefe del Departamento de Desarrollo Academico'],
            ['name' => 'Coordinacion de FD y AP'],
            ['name' => 'Jefes Academicos'],
            ['name' => 'Docentes'],
        ]);
    }
}
