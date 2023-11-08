<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Calificaciones;
use App\Models\ConfigDates;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataResponseController extends Controller
{
    public function Deteccion_Desarrollo(){
        $detecciones = DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'jefe')
            ->where('aceptado', '=', 0)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'detecciones' => $detecciones
        ]);
    }

    public function deteccion_academicos(){
        $detecciones = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])
            ->where('id_jefe', auth()->user()->docente_id)
            ->where('aceptado', '=', 0)
            ->orderBy('id', 'desc')->get();
        return response()->json([
            'detecciones' => $detecciones,
        ]);
    }
    public function Cursos_Desarrollo(Request $request){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
            ->where('aceptado', '=', 1)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'cursos' => $cursos
        ]);
    }

    public function Curso_docente(){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
            ->where('aceptado', '=', 1)
            ->where('id_departamento', '=', auth()->user()->departamento_id)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'cursos_docentes' => $cursos
        ]);
    }

    public function facilitador_check(Request $request){
        $docente = Docente::find($request->id)->facilitador_has_deteccion;

        if (count($docente) == 0){
            return response()->json([
                'facilitador' => false,
            ]);
        }else {
            return response()->json([
                'facilitador' => true,
            ]);
        }
    }

    public function califications(Request $request){
        $calificacion = Docente::with('calificacion_docente')->where('id', $request->id)->first();
        return response()->json([
            'calificaciones' => $calificacion->calificacion_docente
        ]);
    }

    public function inscritos_show(Request $request){
        $inscritos = DB::table('docente')
            ->join('inscripcion', 'inscripcion.docente_id', '=', 'docente.id')
            ->leftjoin('calificaciones', 'calificaciones.docente_id', '=', 'docente.id')
            ->where('inscripcion.curso_id', '=', $request->id)
            ->select('docente.*', 'calificaciones.calificacion', 'inscripcion.id AS inscripcion')
            ->get();

        return response()->json([
            'inscritos_docente' => $inscritos,
        ]);

    }
    public static function if_enable_detecciones(){
        $dates = ConfigDates::latest('id')->first();

        if (empty($dates)){
            return response()->json([
                'fechas' => null
            ]);
        }else {
            $startDate = Carbon::parse($dates->fecha_inicio);
            $endDate = Carbon::parse($dates->fecha_final);
            $currentDate = Carbon::now('GMT-6');
            $tiemporestante = $currentDate->diff($endDate);
            $fechas = [$currentDate->between($startDate, $endDate), $tiemporestante];
            return response()->json([
                'fechas' => $fechas
            ]);
        }
    }
}
