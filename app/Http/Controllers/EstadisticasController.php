<?php

namespace App\Http\Controllers;

use App\Models\DeteccionNecesidades;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EstadisticasController extends Controller
{
    public function index_estadisticas(){
        return Inertia::render('Views/desarrollo/estadisticas/Estadisticas', [
            'cursos_anio' => $this->estadisticas_de_curso_por_anio(),
            'cursos_periodos' => $this->estadistica_cursos_periodo(),
            'cursos_tipo' => $this->estadistica_cursos_tipo(),
        ]);
    }

    public static function estadisticas_de_curso_por_anio(){
//            Cuantos cursos en general por anio
        $anio = date('Y');
        return DeteccionNecesidades::with('inscritos')
            ->whereYear('fecha_F', '=', $anio)
            ->where('estado', '=', 2)->count();
    }

    public static function estadistica_cursos_periodo(){
        $anio = date('Y');
        $cursos_enero_junio = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('periodo', '=', 1);
            })->count();
        $cursos_agosto_diciembre = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('periodo', '=', 2);
            })->count();

        return [$cursos_enero_junio, $cursos_agosto_diciembre];
    }
    public static function estadistica_cursos_tipo(){
        $anio = date('Y');
        $cursos_taller = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 1);
            })->count();
        $cursos_curso = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 2);
            })->count();
        $cursos_curso_taller = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 3);
            })->count();
        $cursos_foro = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 4);
            })->count();
        $cursos_seminario = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 5);
            })->count();
        $cursos_diplomado = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 6);
            })->count();

        return [$cursos_taller, $cursos_curso, $cursos_curso_taller, $cursos_foro, $cursos_seminario, $cursos_diplomado];
    }
}
