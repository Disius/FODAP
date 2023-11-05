<?php

namespace App\Http\Controllers;

use App\Http\Requests\FichaTecnicaRequest;
use App\Models\Calificaciones;
use App\Models\CriteriosEvaluacion;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\FichaTecnica;
use App\Models\FileFT;
use App\Models\FilesCVU;
use App\Models\Temas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class DocenteController extends Controller
{
    public function index_cursos(){

        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
                ->where('aceptado', '=', 1)
                ->orWhere('estado', '=', 0)
                ->where('id_departamento', '=', auth()->user()->departamento_id)
                ->where('estado', '=', 1)
                ->get();
        //Actualiza el estado del curso
        CoursesController::state_curso();
        return Inertia::render('Views/cursos/docentes/CursosDocentes', [
            'cursos' => $cursos
        ]);
    }

    public function index_registros_docente(){
        $docente = Docente::with('inscrito')->where('id', '=', auth()->user()->docente_id)->first();
        CoursesController::state_curso();
        return Inertia::render('Views/cursos/docentes/RegistrosIndex', [
            'cursos' => $docente
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

    public function upload_cvu(Request $request){

        if ($request->hasFile('file')){
            $file_path = $request->file('file')->storeAs('/CVUupload/', 'CVU_'.$request->id.'.pdf', 'public');


            $file = FilesCVU::create([
                'id_docente' => $request->id,
                'path' => $file_path
            ]);


            $file->save();

            return redirect()->route('show.facilitadores', [$request->id]);
        }

        return back()->withErrors('No se subio correctamente el CVU');
    }

    public function show_facilitadores($id){
        $docente = Docente::with('cvu', 'facilitador_has_deteccion')->find($id);
        return Inertia::render('Views/cursos/facilitadores/Facilitadores', [
            'docente' => $docente
        ]);
    }

    public function facilitador_curso($facilitador, $id){
        $docente = Docente::find($facilitador);
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito', 'ficha_tecnica', 'calificaciones_curso'])->find($id);
        $ficha = FichaTecnica::with( 'temas', 'evaluacion_criterio')->find($curso->ficha_tecnica->id);
        return Inertia::render('Views/cursos/facilitadores/MiCursoFacilitador', [
            'curso' => $curso,
            'facilitador' => $docente,
            'ficha_tecnica' => $ficha,

        ]);
    }

    public function crear_ficha_tecnica($facilitador, $id){
        $docente = Docente::find($facilitador);
        $curso = DeteccionNecesidades::with('deteccion_facilitador')->find($id);
        return Inertia::render('Views/cursos/desarrollo/CreateFicha', [
            'docente' => $docente,
            'curso' => $curso
        ]);
    }

    public function store_ficha_tecnica(FichaTecnicaRequest $request){
       $ficha_tecnica = FichaTecnica::create($request->validated());

       $ficha_tecnica->save();

        foreach($request->input('temas') as $item){
            $temas = Temas::create([
                'ficha_id' => $ficha_tecnica->id,
                'name_tema' => $item[0],
                'tiempo_programado' => $item[1],
                'act_aprendizaje' => $item[2]
            ]);
            $temas->save();
        }

        foreach($request->input('criterio_eval') as $element){
            $criterio_evaluacion = CriteriosEvaluacion::create([
                'ficha_id' => $ficha_tecnica->id,
                'criterio' => $element[0],
                'valor' => $element[1],
                'instrumento_evaluacion' => $element[2],
            ]);
            $criterio_evaluacion->save();
        }

        return redirect()->route('show.curso.facilitador', [$request->id_docente, $request->id_curso]);
    }

    public function calificaciones(Request $request){
        $calificacion = Calificaciones::create($request->all());
        $calificacion->save();
        return Redirect::route('show.curso.facilitador', [$request->docente_id, $request->curso_id]);
    }
}
