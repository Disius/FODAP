<?php

namespace App\Http\Controllers;

use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DocenteController extends Controller
{
    public function index_cursos(){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
//            ->where('id_jefe', auth()->user()->docente_id)
            ->get();
        //Actualiza el estado del curso
        CoursesController::state_curso();
        return Inertia::render('Views/cursos/docentes/CursosDocentes', [
            'cursos' => $cursos
        ]);
    }


    public function inscripcion_docente(Request $request, $id){
        $deteccion = DeteccionNecesidades::find($id);
        $deteccion->docente_inscrito()->sync($request->input('id_docente'));
        return Redirect::route('index.cursos.docentes');
    }

    public function misCursos(){
        $docente = Docente::with('inscrito')->where('id', '=', auth()->user()->docente_id)->first();
        CoursesController::state_curso();
        return Inertia::render('Views/cursos/docentes/MisCursosDocentes', [
            'docente' => $docente,
        ]);
    }

    public function facilitadores(Request $request){
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

    public function show_facilitadores(){
        return Inertia::render('Views/cursos/facilitadores/Facilitadores');
    }

    public function upload_cvu(Request $request){

        $path = '/storage/CVUupload/';

        PDFController::save_file($request->file_name, $path);


        return response()->json([
           'file_name' => $request->file_name,
            'file_size' => $request->file_size,
            'id' => $request->id
        ]);
    }


}
