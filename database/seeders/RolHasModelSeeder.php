<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolHasModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $desarrollo = User::find(1);
        $desarrollo->assignRole('Jefe del Departamento de Desarrollo Academico');
        $coordinacion = User::find(10);
        $coordinacion->assignRole('Coordinacion de FD y AP');
        $jefe1 = User::find(2);
        $jefe1->assignRole('Jefes Academicos');
        $jefe2 = User::find(3);
        $jefe2->assignRole('Jefes Academicos');
        $jefe3 = User::find(4);
        $jefe3->assignRole('Jefes Academicos');
        $jefe4 = User::find(5);
        $jefe4->assignRole('Jefes Academicos');
        $jefe5 = User::find(6);
        $jefe5->assignRole('Jefes Academicos');
        $jefe6 = User::find(7);
        $jefe6->assignRole('Jefes Academicos');
        $jefe6 = User::find(8);
        $jefe6->assignRole('Jefes Academicos');
        $jefe7 = User::find(9);
        $jefe7->assignRole('Jefes Academicos');

        $desarrollo->givePermissionTo('edit profile');

        $docente_facilitador = User::find(11);
        $docente_facilitador->assignRole('Docentes');
    }
}
