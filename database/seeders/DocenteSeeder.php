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
            ['nombre' => 'Salvador', 'apellidoPat' => 'Hernández', 'apellidoMat' => 'Garduza', 'user_id' => 1, 'nombre_completo' => 'Salvador Hernández Garduza', 'carrera_id' => 8, 'departamento_id' => 1],
            ['nombre' => 'Karlos', 'apellidoPat' => 'Velázquez', 'apellidoMat' => 'Moreno', 'user_id' => 2, 'nombre_completo' => 'Karlos Velázquez Moreno', 'carrera_id' => 4, 'departamento_id' => 3],
            ['nombre' => 'Carlos Venturino', 'apellidoPat' => 'de Coss', 'apellidoMat' => 'Pérez', 'user_id' => 3, 'nombre_completo' => 'Carlos Venturino de Coss Pérez', 'carrera_id' => 3, 'departamento_id' => 4],
            ['nombre' => 'José Manuel', 'apellidoPat' => 'Rasgado', 'apellidoMat' => 'Bezares', 'user_id' => 4, 'nombre_completo' => 'José Manuel Rasgado Bezares', 'carrera_id' => 1, 'departamento_id' => 5],
            ['nombre' => 'María Magdalena', 'apellidoPat' => 'Pérez', 'apellidoMat' => 'Salgado', 'user_id' => 5, 'nombre_completo' => 'María Magdalena Pérez Salgado', 'carrera_id' => 6, 'departamento_id' => 6],
            ['nombre' => 'María Guadalupe', 'apellidoPat' => 'Monjarás', 'apellidoMat' => 'Velasco', 'user_id' => 6, 'nombre_completo' => 'María Guadalupe Monjarás Velasco', 'carrera_id' => 2, 'departamento_id' => 7],
            ['nombre' => 'Adriana', 'apellidoPat' => 'Meza', 'apellidoMat' => 'León', 'user_id' => 7, 'nombre_completo' => 'Adriana Meza León', 'carrera_id' => 12, 'departamento_id' => 8],
            ['nombre' => 'Gilberto', 'apellidoPat' => 'Hernández', 'apellidoMat' => 'Cruz', 'user_id' => 8, 'nombre_completo' => 'Gilberto Hernández Cruz', 'carrera_id' => 8, 'departamento_id' => 9],
            ['nombre' => 'María Catalina', 'apellidoPat' => 'Salgado', 'apellidoMat' => 'Gutiérrez', 'user_id' => 9, 'nombre_completo' => 'María Catalina Salgado Gutiérrez', 'carrera_id' => 8, 'departamento_id' => 1],
            ['nombre' => 'Adriana Cristina', 'apellidoPat' => 'Bonifaz', 'apellidoMat' => 'Hernández', 'user_id' => 10, 'nombre_completo' => 'Adriana Cristina Bonifaz Hernández', 'departamento_id' => 2],
            ['nombre' => 'Joel', 'apellidoPat' => 'Gómez', 'apellidoMat' => 'Pérez', 'nombre_completo' => 'Joel Gómez Pérez', 'departamento_id' => 1],
            ['nombre' => 'Oscar Emmanuel', 'apellidoPat' => 'Aguilar', 'apellidoMat' => 'Vera', 'nombre_completo' => 'Oscar Emmanuel Aguilar Vera', 'departamento_id' => 1],
            ['nombre' => 'Ildeberto', 'apellidoPat' => 'De Los Santos', 'apellidoMat' => 'Ruiz', 'nombre_completo' => 'Ildeberto De Los Santos Ruiz', 'departamento_id' => 1],
            ['nombre' => 'Julio Antonio', 'apellidoPat' => 'Moreno', 'apellidoMat' => 'Gordillo', 'nombre_completo' => 'Julio Antonio Moreno Gordillo', 'departamento_id' => 1],
            ['nombre' => 'José del Carmen', 'apellidoPat' => 'Vázquez', 'apellidoMat' => 'Hernández', 'nombre_completo' => 'José del Carmen Vázquez Hernández', 'departamento_id' => 3],
            ['nombre' => 'Luis Alberto', 'apellidoPat' => 'Morales', 'apellidoMat' => 'Alias', 'nombre_completo' => 'Luis Alberto Morales Alias', 'departamento_id' => 5],
            ['nombre' => 'Jaime Eduardo', 'apellidoPat' => 'Gálvez', 'apellidoMat' => 'Reyes', 'nombre_completo' => 'Jaime Eduardo Gálvez Reyes', 'departamento_id' => 5],
            ['nombre' => 'Patricia del Pilar', 'apellidoPat' => 'Gómez', 'apellidoMat' => 'Galdámez', 'nombre_completo' => 'Patricia del Pilar Gómez Galdámez', 'departamento_id' => 9],
            ['nombre' => 'Sabino', 'apellidoPat' => 'Vélazquez', 'apellidoMat' => 'Trujillo', 'nombre_completo' => 'Sabino Vélazquez Trujillo', 'departamento_id' => 9],
            ['nombre' => 'Elfer Isaías', 'apellidoPat' => 'Clemente', 'apellidoMat' => 'Camacho', 'nombre_completo' => 'Elfer Isaías Clemente Camacho', 'departamento_id' => 7],
            ['nombre' => 'Néstor Antonio', 'apellidoPat' => 'Morales', 'apellidoMat' => 'Navarro', 'nombre_completo' => 'Néstor Antonio Morales Navarro', 'departamento_id' => 7],
            ['nombre' => 'Jesús Carlos', 'apellidoPat' => 'Sánchez', 'apellidoMat' => 'Guzmán', 'nombre_completo' => 'Jesús Carlos Sánchez Guzmán', 'departamento_id' => 7],
            ['nombre' => 'Rosy Ilda', 'apellidoPat' => 'Basave', 'apellidoMat' => 'Torres', 'nombre_completo' => 'Rosy Ilda Basave Torres', 'departamento_id' => 7],
        ]);
    }
}
