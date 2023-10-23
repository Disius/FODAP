<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\DeteccionNecesidades;
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
}
