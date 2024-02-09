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
            'cursos_periodos' => $this->estadistica_cursos_periodo()
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
}
