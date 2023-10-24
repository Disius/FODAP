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
            ['name' => 'Jefe del Departamento de Desarrollo Academico', 'guard_name' => 'web'],
            ['name' => 'Coordinacion de FD y AP', 'guard_name' => 'web'],
            ['name' => 'Jefes Academicos', 'guard_name' => 'web'],
            ['name' => 'Docentes', 'guard_name' => 'web'],
            ['name' => 'Super Admin', 'guard_name' => 'web'],
        ]);

        DB::table('permissions')->insert([
            ['name' => 'edit profile', 'guard_name' => 'web'],
            ['name' => 'config app', 'guard_name' => 'web']
        ]);
    }
}
