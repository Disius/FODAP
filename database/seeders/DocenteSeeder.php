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
            ['nombre' => 'Adriana Cristina', 'apellidoPat' => 'Bonifaz', 'apellidoMat' => 'Hernández', 'user_id' => 10, 'nombre_completo' => 'Adriana Cristina Bonifaz Hernández', 'carrera_id' => null, 'departamento_id' => 2],
            ['nombre' => 'Joel', 'apellidoPat' => 'Gómez', 'apellidoMat' => 'Pérez', 'user_id' => null, 'nombre_completo' => 'Joel Gómez Pérez', 'carrera_id' => null, 'departamento_id' => 1],
            ['nombre' => 'Oscar Emmanuel', 'apellidoPat' => 'Aguilar', 'apellidoMat' => 'Vera', 'user_id' => null,  'nombre_completo' => 'Oscar Emmanuel Aguilar Vera', 'carrera_id' => null, 'departamento_id' => 1],
            ['nombre' => 'Ildeberto', 'apellidoPat' => 'De Los Santos', 'apellidoMat' => 'Ruiz', 'user_id' => null, 'nombre_completo' => 'Ildeberto De Los Santos Ruiz', 'carrera_id' => null, 'departamento_id' => 1],
            ['nombre' => 'Julio Antonio', 'apellidoPat' => 'Moreno', 'apellidoMat' => 'Gordillo', 'user_id' => null, 'nombre_completo' => 'Julio Antonio Moreno Gordillo', 'carrera_id' => null, 'departamento_id' => 1],
            ['nombre' => 'José del Carmen', 'apellidoPat' => 'Vázquez', 'apellidoMat' => 'Hernández', 'user_id' => null, 'nombre_completo' => 'José del Carmen Vázquez Hernández', 'carrera_id' => null, 'departamento_id' => 3],
            ['nombre' => 'Luis Alberto', 'apellidoPat' => 'Morales', 'apellidoMat' => 'Alias', 'user_id' => null, 'nombre_completo' => 'Luis Alberto Morales Alias', 'carrera_id' => null, 'departamento_id' => 5],
            ['nombre' => 'Jaime Eduardo', 'apellidoPat' => 'Gálvez', 'apellidoMat' => 'Reyes', 'user_id' => null, 'nombre_completo' => 'Jaime Eduardo Gálvez Reyes', 'carrera_id' => null, 'departamento_id' => 5],
            ['nombre' => 'Patricia del Pilar', 'apellidoPat' => 'Gómez', 'apellidoMat' => 'Galdámez', 'user_id' => null, 'nombre_completo' => 'Patricia del Pilar Gómez Galdámez', 'carrera_id' => null, 'departamento_id' => 9],
            ['nombre' => 'Sabino', 'apellidoPat' => 'Vélazquez', 'apellidoMat' => 'Trujillo', 'user_id' => null, 'nombre_completo' => 'Sabino Vélazquez Trujillo', 'carrera_id' => null, 'departamento_id' => 9],
            ['nombre' => 'Elfer Isaías', 'apellidoPat' => 'Clemente', 'apellidoMat' => 'Camacho', 'user_id' => null,  'nombre_completo' => 'Elfer Isaías Clemente Camacho', 'carrera_id' => null, 'departamento_id' => 7],
            ['nombre' => 'Néstor Antonio', 'apellidoPat' => 'Morales', 'apellidoMat' => 'Navarro', 'user_id' => null,  'nombre_completo' => 'Néstor Antonio Morales Navarro', 'carrera_id' => null, 'departamento_id' => 7],
            ['nombre' => 'Jesús Carlos', 'apellidoPat' => 'Sánchez', 'apellidoMat' => 'Guzmán', 'user_id' => null, 'nombre_completo' => 'Jesús Carlos Sánchez Guzmán', 'carrera_id' => null, 'departamento_id' => 7],
            ['nombre' => 'Rosy Ilda', 'apellidoPat' => 'Basave', 'apellidoMat' => 'Torres', 'user_id' => null, 'nombre_completo' => 'Rosy Ilda Basave Torres', 'carrera_id' => null, 'departamento_id' => 7],
            ['nombre' => 'Jorge Arturo', 'apellidoPat' => 'Sarmiento', 'apellidoMat' => 'Torres', 'user_id' => null, 'nombre_completo' => 'Jorge Arturo Sarmiento Torres', 'carrera_id' => null, 'departamento_id' => 9],
            ['nombre' => 'Itzel Elvira', 'apellidoPat' => 'Juárez', 'apellidoMat' => 'Martinez', 'user_id' => null, 'nombre_completo' => 'Itzel Elvira Juárez Martinez', 'carrera_id' => null, 'departamento_id' => 9],
            ['nombre' => 'Jorge Antonio', 'apellidoPat' => 'Mijangos', 'apellidoMat' => 'López', 'user_id' => null, 'nombre_completo' => 'Jorge Antonio Mijangos López', 'carrera_id' => null, 'departamento_id' => 4],
            ['nombre' => 'Jorge Antonio', 'apellidoPat' => 'Orozco', 'apellidoMat' => 'Torres', 'user_id' => null, 'nombre_completo' => 'Jorge Antonio Orozco Torres', 'carrera_id' => null, 'departamento_id' => 4],
            ['nombre' => 'Amado', 'apellidoPat' => 'Castillejos', 'apellidoMat' => 'Brindis', 'user_id' => null, 'nombre_completo' => 'Amado Castillejos Brindis', 'carrera_id' => null, 'departamento_id' => 4],
            ['nombre' => 'Linda Viviana', 'apellidoPat' => 'Lopez', 'apellidoMat' => 'Pablo', 'user_id' => null, 'nombre_completo' => 'Linda Viviana Lopéz Pablo', 'carrera_id' => null, 'departamento_id' => 6],
            ['nombre' => 'Marco Antonio', 'apellidoPat' => 'Aguilar', 'apellidoMat' => 'Suárez', 'user_id' => null, 'nombre_completo' => 'Marco Antonio Aguilar Suárez', 'carrera_id' => null, 'departamento_id' => 6],
            ['nombre' => 'Ricardo', 'apellidoPat' => 'Suárez', 'apellidoMat' => 'Castillejos', 'user_id' => null, 'nombre_completo' => 'Ricardo Suárez Castillejos', 'carrera_id' => null, 'departamento_id' => 6],
            ['nombre' => 'Raúl', 'apellidoPat' => 'Moreno', 'apellidoMat' => 'Rincón', 'user_id' => null, 'nombre_completo' => 'Raúl Moreno Rincón', 'carrera_id' => null, 'departamento_id' => 3],
            ['nombre' => 'Alvaro', 'apellidoPat' => 'Hernández', 'apellidoMat' => 'Sol', 'user_id' => null, 'nombre_completo' => 'Alvaro Hernández Sol', 'carrera_id' => null, 'departamento_id' => 3],
            ['nombre' => 'Francisco Ramón', 'apellidoPat' => 'Sánchez', 'apellidoMat' => 'Rodriguez', 'user_id' => null, 'nombre_completo' => 'Francisco Ramón Sánchez Rodriguez', 'carrera_id' => null, 'departamento_id' => 3],
            ['nombre' => 'Osbaldo Ysaac', 'apellidoPat' => 'García', 'apellidoMat' => 'Ramos', 'user_id' => null, 'nombre_completo' => 'Osbaldo Ysaac García Ramos', 'carrera_id' => null, 'departamento_id' => 3],
            ['nombre' => 'Daniel Eduardo', 'apellidoPat' => 'Fernández', 'apellidoMat' => 'Pérez', 'user_id' => 11, 'nombre_completo' => 'Daniel Eduardo Fernández Pérez', 'carrera_id' => 2, 'departamento_id' => 7]
        ]);
    }
}
