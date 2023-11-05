<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Calificaciones;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use Illuminate\Http\Request;

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
    public function Cursos_Desarrollo(Request $request){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
            ->where('aceptado', '=', 1)
//            ->orWhere('estado' , '=', 0)
//            ->Where('estado' , '=', 1)
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
        $docente = Docente::with('facilitador_has_deteccion')->find($request->id);

        if (count($docente->facilitador_has_deteccion) == 0){
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

    public function curso_show(Request $request){
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito', 'ficha_tecnica', 'calificaciones_curso'])->find($request->id);

        return response()->json([
            'curso' => $curso
        ]);

    }
}
