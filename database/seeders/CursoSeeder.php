<?php

namespace Database\Seeders;

use App\Http\Controllers\CoursesController;
use App\Models\DeteccionNecesidades;
use App\Models\Director;
use App\Models\NombreInstituto;
use App\Models\Subdireccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Electrica electronica departamento 3 electronica 4 y 5 electrica

        Subdireccion::create([
            'name' => 'María Delina Culebro Farrera'
        ]);
        NombreInstituto::create([
            'name' => 'INSTITUTO TECNOLÓGICO DE TUXTLA GUTIÉRREZ'
        ]);
        Director::create([
            'nameDirector' => 'José Manuel Rosado Pérez'
        ]);


    }
}
