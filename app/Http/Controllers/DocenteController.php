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
        $this->state_curso();
        return Inertia::render('Views/cursos/docentes/MisCursosDocentes', [
            'docente' => $docente,
        ]);
    }
}
