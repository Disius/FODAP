<?php

namespace Database\Seeders;

use App\Http\Controllers\CoursesController;
use App\Models\DeteccionNecesidades;
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

        $deteccion = DeteccionNecesidades::create([
            'asignaturaFA' => "Todas",
            'contenidosTM' => "Atributos del Egresado e instrumentos de evaluación. 1.- Introducción a los conceptos atributos del egresado en ingenieria electrónica (CACEI)
            2.- Determinación del atributo de egresado a desarrollar en cada asignatura.  3.- Diseño de los instrumentos de evaluación",
            'numeroProfesores' => 30,
            'periodo' => 2,
            'nombreCurso' => "Asignación y evaluación por asignatura de los atributos del egresado en ingeniería electrónica.",
            'fecha_I' => "2023-10-16",
            'fecha_F' => "2023-10-20",
            'hora_I' => "08:00",
            'hora_F' => "14:00",
            'objetivoEvento' => "Desarrollar en trabajo colegiado los atributos y los instrumentos de evaluación de cada uno de ellos, en cada asignatura de la carrera de ingenieria.",
            'tipo_FDoAP' => 1,
            'tipo_actividad' => 3,
            'carrera_dirigido' => 4,
            'id_jefe' => 2,
            'aceptado' => 0,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-16", "2023-10-20", "08:00", "14:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 3
        ]);
        $deteccion->deteccion_facilitador()->toggle([32, 33]);

        $deteccion->save();

        $deteccion2 = DeteccionNecesidades::create([
            'asignaturaFA' => "Especialidad de Telecomunicaciones",
            'contenidosTM' => "Redes de Telecomunicaciones.
                1.- Análisis de señales. Espectro en frecuencia LOS (linea de vista) MO. Perfil topográfico
                Diseño de enlace MO.
                2.- Satélites caracteristicas tipos de orbita, segmento espacial
                Diseño de enlace satelital:
                Up link, Down link
                Enrutamiento: azimuth y elevación.
                3.- Medios de transmisión. Antenas
            ",
            'numeroProfesores' => 6,
            'periodo' => 2,
            'nombreCurso' => "Comunicación por MO y Satélites",
            'fecha_I' => "2023-10-16",
            'fecha_F' => "2023-10-20",
            'hora_I' => "08:00",
            'hora_F' => "14:00",
            'objetivoEvento' => "Conocer los procesos de ENLACES Terreste (LOS) microondas y espaciales (satélites)",
            'tipo_FDoAP' => 2,
            'tipo_actividad' => 3,
            'carrera_dirigido' => 4,
            'id_jefe' => 2,
            'aceptado' => 0,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-16", "2023-10-20", "08:00", "14:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 3
        ]);
        $deteccion2->deteccion_facilitador()->toggle([34]);

        $deteccion2->save();

        //quimica departamento 6, carrera 7

        $deteccion3 = DeteccionNecesidades::create([
            'asignaturaFA' => "Laboratorios integrales I, II y III",
            'contenidosTM' => "Competencias para el desarrollo de prácticas en el laboratorio",
            'numeroProfesores' => 21,
            'periodo' => 2,
            'nombreCurso' => "Métodos numéricos aplicados a ingeniería química",
            'fecha_I' => "2023-10-16",
            'fecha_F' => "2023-10-20",
            'hora_I' => "09:00",
            'hora_F' => "15:00",
            'objetivoEvento' => "Aplicar métodos numéricos en la resolución de problemas de ingenieria química",
            'tipo_FDoAP' => 1,
            'tipo_actividad' => 2,
            'carrera_dirigido' => 7,
            'id_jefe' => 5,
            'aceptado' => 0,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-16", "2023-10-20", "09:00", "15:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 6
        ]);
        $deteccion3->deteccion_facilitador()->toggle([29]);

        $deteccion3->save();

        //industrial departamento 4 carrera 3
        $deteccion4 = DeteccionNecesidades::create([
            'asignaturaFA' => "Algoritmo y lenguaje de programación",
            'contenidosTM' => "Uso de lenguaje de programación",
            'numeroProfesores' => 15,
            'periodo' => 2,
            'nombreCurso' => "Diplomado de programación 'R' y Python - Modulo 1",
            'fecha_I' => "2023-10-16",
            'fecha_F' => "2023-10-20",
            'hora_I' => "09:00",
            'hora_F' => "15:00",
            'objetivoEvento' => "Conocer el lenguaje de programación de vanguardia en la formación del ingeniero industrial",
            'tipo_FDoAP' => 1,
            'tipo_actividad' => 2,
            'carrera_dirigido' => 3,
            'id_jefe' => 3,
            'aceptado' => 0,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-16", "2023-10-20", "09:00", "15:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 4
        ]);
        $deteccion4->deteccion_facilitador()->toggle([26, 27]);

        $deteccion4->save();

        $deteccion4 = DeteccionNecesidades::create([
            'asignaturaFA' => "Algoritmo y lenguaje de programación",
            'contenidosTM' => "Uso de lenguaje de programación",
            'numeroProfesores' => 15,
            'periodo' => 2,
            'nombreCurso' => "Diplomado de programación 'R' y Python - Modulo 2",
            'fecha_I' => "2023-10-23",
            'fecha_F' => "2023-10-27",
            'hora_I' => "09:00",
            'hora_F' => "15:00",
            'objetivoEvento' => "Conocer el lenguaje de programación de vanguardia en la formación del ingeniero industrial",
            'tipo_FDoAP' => 1,
            'tipo_actividad' => 2,
            'carrera_dirigido' => 3,
            'id_jefe' => 3,
            'aceptado' => 0,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-23", "2023-10-27", "09:00", "15:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 4
        ]);
        $deteccion4->deteccion_facilitador()->toggle([26, 27]);

        $deteccion4->save();

        $deteccion4 = DeteccionNecesidades::create([
            'asignaturaFA' => "Algoritmo y lenguaje de programación",
            'contenidosTM' => "Uso de lenguaje de programación",
            'numeroProfesores' => 15,
            'periodo' => 2,
            'nombreCurso' => "Diplomado de programación 'R' y Python - Modulo 3",
            'fecha_I' => "2023-10-30",
            'fecha_F' => "2023-11-03",
            'hora_I' => "09:00",
            'hora_F' => "15:00",
            'objetivoEvento' => "Conocer el lenguaje de programación de vanguardia en la formación del ingeniero industrial",
            'tipo_FDoAP' => 1,
            'tipo_actividad' => 2,
            'carrera_dirigido' => 3,
            'id_jefe' => 3,
            'aceptado' => 0,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-30", "2023-11-03", "09:00", "15:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 4
        ]);
        $deteccion4->deteccion_facilitador()->toggle([26, 27]);

        $deteccion4->save();

        //gestion departamento 9 carrera 8

        $deteccion5 = DeteccionNecesidades::create([
            'asignaturaFA' => "Todas las asignaturas de la retícula",
            'contenidosTM' => "Todos los contenidos de las asignaturas",
            'numeroProfesores' => 25,
            'periodo' => 2,
            'nombreCurso' => "Metodologias activas en el proceso de Enseñanza Aprendizaje",
            'fecha_I' => "2023-10-23",
            'fecha_F' => "2023-10-27",
            'hora_I' => "09:00",
            'hora_F' => "15:00",
            'objetivoEvento' => "Busca aportar las habilidades necesarias para transformar el aula aplicando metodologias activas y sistemas de aprendizaje personalizado.
            Las metodologias activas de enseñanza se aplican cada dia en las aulas complementando y sustituyendo las fórmulas de la enseñanza tradicional para mejorar y fortalecer el proceso de enseñanza-aprendizaje",
            'tipo_FDoAP' => 1,
            'tipo_actividad' => 1,
            'carrera_dirigido' => 8,
            'id_jefe' => 8,
            'aceptado' => 0,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-23", "2023-10-27", "09:00", "15:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 9
        ]);
        $deteccion5->deteccion_facilitador()->toggle([20]);

        $deteccion5->save();

        Subdireccion::create([
            'name' => 'María Delina Culebro Farrera'
        ]);

        $deteccion6 = DeteccionNecesidades::create([
            'asignaturaFA' => "Todas las asignaturas de la retícula",
            'contenidosTM' => "Todos los contenidos de las asignaturas",
            'numeroProfesores' => 20,
            'periodo' => 2,
            'nombreCurso' => "Elaboración de practicas de laboratorio de métodos y sistemas manufactura",
            'fecha_I' => "2023-10-16",
            'fecha_F' => "2023-10-20",
            'hora_I' => "08:00",
            'hora_F' => "14:00",
            'objetivoEvento' => "Capacitar a los docentes en la realización de prácticas en los laboratorios
            de: Métodos y, sistemas de manufactura; a fin de transmitir a los estudiantes la experiencia de participación
            en procesos de producción y manufactura de materiales, asi como las competencias de habilidades correspondientes a laboratorio afines",
            'tipo_FDoAP' => 1,
            'tipo_actividad' => 3,
            'carrera_dirigido' => 8,
            'id_jefe' => 8,
            'aceptado' => 1,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-16", "2023-10-20", "08:00", "14:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 9
        ]);
        $deteccion6->deteccion_facilitador()->toggle([24, 25]);

        $deteccion6->save();

        //sistemas

        $deteccion7 = DeteccionNecesidades::create([
            'asignaturaFA' => "Fundamentos de programación, POO, Estructura de datos, base de datos, redes, programacion de dispositivos móviles",
            'contenidosTM' => "TODAS",
            'numeroProfesores' => 25,
            'periodo' => 2,
            'nombreCurso' => "Metodologías activas en el proceso de enseñanza-aprendizaje",
            'fecha_I' => "2023-10-16",
            'fecha_F' => "2023-10-20",
            'hora_I' => "09:00",
            'hora_F' => "15:00",
            'objetivoEvento' => "Desarrollar y mejorar competencias y destrezas del alumnado a través de Aprendizaje Basado en Proyectos, Aprendizaje cooperativo,
            Aprendizaje Colaborativo, Flipped Learning, etc.",
            'tipo_FDoAP' => 1,
            'tipo_actividad' => 2,
            'carrera_dirigido' => 2,
            'id_jefe' => 6,
            'aceptado' => 1,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-16", "2023-10-20", "09:00", "15:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 7
        ]);
        $deteccion7->deteccion_facilitador()->toggle([20]);

        $deteccion7->save();

        $deteccion8 = DeteccionNecesidades::create([
            'asignaturaFA' => "Fundamentos de programación, POO, Estructura de datos, base de datos, redes, programacion de dispositivos móviles",
            'contenidosTM' => "TODAS",
            'numeroProfesores' => 25,
            'periodo' => 2,
            'nombreCurso' => "Tratamiento de datos con pandas en Python",
            'fecha_I' => "2023-10-18",
            'fecha_F' => "2023-10-25",
            'hora_I' => "09:00",
            'hora_F' => "15:00",
            'objetivoEvento' => "Conocer y tratar datos mediante la libreria de Pandas para realizar
            aplicaciones de procesamiento de datos y Machine Learning",
            'tipo_FDoAP' => 2,
            'tipo_actividad' => 2,
            'carrera_dirigido' => 2,
            'id_jefe' => 6,
            'aceptado' => 1,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-18", "2023-10-25", "09:00", "15:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 7
        ]);
        $deteccion8->deteccion_facilitador()->toggle([21]);

        $deteccion8->save();

        $deteccion9 = DeteccionNecesidades::create([
            'asignaturaFA' => "Fundamentos de programación, POO, Estructura de datos, base de datos, redes, programacion de dispositivos móviles, ingenieria software",
            'contenidosTM' => "TODAS",
            'numeroProfesores' => 20,
            'periodo' => 2,
            'nombreCurso' => "E-BUSINESS",
            'fecha_I' => "2023-10-23",
            'fecha_F' => "2023-10-27",
            'hora_I' => "09:00",
            'hora_F' => "15:00",
            'objetivoEvento' => "Desarrollar con las tecnologías de la información y la comunicación (TIC) que asisten a los procesos comerciales en venta en todas sus fases (planificacion, negociación y ejecución) en una tienda online",
            'tipo_FDoAP' => 2,
            'tipo_actividad' => 3,
            'carrera_dirigido' => 2,
            'id_jefe' => 6,
            'aceptado' => 1,
            'obs' => 0,
            'total_horas' => CoursesController::total_horas("2023-10-23", "2023-10-27", "09:00", "15:00"),
            'modalidad' => 2,
            'facilitador_externo' =>  null,
            'id_departamento' => 7
        ]);
        $deteccion9->deteccion_facilitador()->toggle([22]);

        $deteccion9->save();

    }
}
