<?php

namespace App\Http\Controllers;

use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\FileFT;
use App\Models\FilesCVU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use function MongoDB\BSON\toRelaxedExtendedJSON;

class DocenteController extends Controller
{
    public function index_cursos(){

        $user_docente = auth()->user()->docente;
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

    public function show_facilitadores($id){
        $docente = Docente::with('cvu', 'facilitador_has_deteccion')->find($id);
        return Inertia::render('Views/cursos/facilitadores/Facilitadores', [
            'docente' => $docente
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

            return response()->json([
                'msg' => 'Su CVU se ha subido con exito'
            ]);
        }

        return response()->json([
            'msg' => 'No se ha podido subir su CVU'
        ]);
    }
    public function upload_ft(Request $request)
    {
        if ($request->hasFile('file')){
            $file_path = $request->file('file')->storeAs('/FTupload/', 'FICHA_TECNICA_curso_'.$request->id.'.docx', 'public');


            $file = FileFT::create([
                'id_curso' => $request->id,
                'path' => $file_path
            ]);


            $file->save();

//            throw new \Exception();

        }else{
            throw new \Exception('Error al subir la ficha técnica');
        }

    }

    public function crear_ficha_tecnica($facilitador, $id){
        $docente = Docente::find($facilitador);
        $curso = DeteccionNecesidades::find($id);
        return Inertia::render('Views/cursos/desarrollo/CreateFicha', [
            'docente' => $docente,
            'curso' => $curso
        ]);
    }
}
