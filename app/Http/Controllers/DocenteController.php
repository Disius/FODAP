<?php

namespace App\Http\Controllers;

use App\Events\CalificacionEvent;
use App\Events\InscripcionEvent;
use App\Http\Requests\FichaTecnicaRequest;
use App\Models\Calificaciones;
use App\Models\CriteriosEvaluacion;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\FichaTecnica;
use App\Models\FilesCVU;
use App\Models\Temas;
use App\Models\User;
use App\Notifications\InscripcionDocente;
use App\Notifications\NewDeteccionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DocenteController extends Controller
{
    public function index_cursos(){

        //Actualiza el estado del curso
        CoursesController::state_curso();

        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
                ->where('aceptado', '=', 1)
                ->where('id_departamento', '=', auth()->user()->departamento_id)
                ->where(function($query) {
                    $query->where('estado', '=', 0)
                    ->orWhere('estado', '=', 1);
                })
                ->orderBy('id', 'desc')
                ->get();

        return Inertia::render('Views/cursos/docentes/CursosDocentes', [
            'cursos' => $cursos
        ]);
    }

    public function index_registros_docente(){
        CoursesController::state_curso();
        $docente = Docente::with('inscrito')->where('id', '=', auth()->user()->docente_id)->first();
        return Inertia::render('Views/cursos/docentes/RegistrosIndex', [
            'cursos' => $docente
        ]);
    }


    public function inscripcion_docente(Request $request, $id){
        $deteccion = DeteccionNecesidades::find($id);
        $deteccion->docente_inscrito()->attach($request->input('id_docente'));
        $syncDocente = DesarrolloController::consult_to_sync($id, $request->id_docente);
        event(new CalificacionEvent($syncDocente));
        return Redirect::route('index.cursos.docentes');
    }

    public function misCursos(){
        CoursesController::state_curso();

        $docente = Docente::with('inscrito', 'calificacion_docente')->where('id', '=', auth()->user()->docente_id)->first();

        $misCursos = DB::table('inscripcion')
            ->join('deteccion_necesidades', 'inscripcion.curso_id', '=', 'deteccion_necesidades.id')
            ->leftJoin('calificaciones', function ($join) {
                $join->on('calificaciones.curso_id', '=', 'inscripcion.curso_id')
                    ->where('calificaciones.docente_id', '=', auth()->user()->docente_id);
            })
            ->where('inscripcion.docente_id', '=', auth()->user()->docente_id)
            ->orderByRaw('deteccion_necesidades.estado ASC, ABS(DATEDIFF(NOW(), deteccion_necesidades.fecha_I)) ASC')
            ->select('deteccion_necesidades.*', 'inscripcion.id AS InscripcionID', 'calificaciones.calificacion AS calificacion', 'calificaciones.id AS calificacionID')
            ->get();


        return Inertia::render('Views/cursos/docentes/MisCursosDocentes', [
            'docente' => $docente,
            'misCursos' => $misCursos
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
        CoursesController::state_curso();
        $docente = Docente::with('cvu', 'facilitador_has_deteccion')->find($id);
        return Inertia::render('Views/cursos/facilitadores/Facilitadores', [
            'docente' => $docente
        ]);
    }

    public function facilitador_curso($facilitador, $id){
        $docente = Docente::find($facilitador);
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito', 'ficha_tecnica', 'calificaciones_curso'])->find($id);
        $ficha = $curso->ficha != null ? FichaTecnica::with( 'temas', 'evaluacion_criterio')->find($curso->ficha_tecnica->id) : null;
        $inscritos = DB::table('docente')
            ->join('inscripcion', 'inscripcion.docente_id', '=', 'docente.id')
            ->leftJoin('calificaciones', function ($join) {
                $join->on('calificaciones.docente_id', '=', 'docente.id')
                    ->on('calificaciones.curso_id', '=', 'inscripcion.curso_id');
            })
            ->where('inscripcion.curso_id', '=', $id)
            ->select('docente.*', 'calificaciones.calificacion', 'inscripcion.curso_id AS inscripcion_curso_id')
            ->get();
        return Inertia::render('Views/cursos/facilitadores/MiCursoFacilitador', [
            'curso' => $curso,
            'facilitador' => $docente,
            'ficha_tecnica' => $ficha,
            'inscritos' => $inscritos,
        ]);
    }

    public function crear_ficha_tecnica($facilitador, $id){
        $docente = Docente::find($facilitador);
        $curso = DeteccionNecesidades::with('deteccion_facilitador')->find($id);
        return Inertia::render('Views/cursos/facilitadores/CreateFicha', [
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
        $request->validate([
            'docente_id' => 'required'
        ]);
        $this->add_calificacion($request);

        $syncCalificacion = DesarrolloController::consult_to_sync($request->curso_id, $request->docente_id);

        event(new CalificacionEvent($syncCalificacion));

        return Redirect::route('show.curso.facilitador', [$request->docente_id, $request->curso_id]);
    }

    public static function add_calificacion($payload){
        if(isset($payload->curso_id)) {
            try {
                DB::beginTransaction();
                $calificacion = Calificaciones::create([
                    'calificacion' => $payload->calificacion,
                    'docente_id' => $payload->docente_id,
                    'curso_id' => $payload->curso_id
                ]);
                $calificacion->save();
                DB::commit();
                return "Ok";
            }catch (\Exception $exception){
                    DB::rollBack();
                    return Redirect::back()->withErrors('error', 'Error a la hora de crear el registro: ' . $exception->getMessage());
            }
        }
        return null;
    }

    public static function update_calificacion($payload, $id){
        $calificacion = Calificaciones::where('docente_id', $id)
            ->where('curso_id', $payload->curso_id)
            ->first();

        if($calificacion) {
            $calificacion->calificacion = $payload->calificacion;
            $calificacion->save();
            return $calificacion;
        }
        return null;
    }
    public static function create_instance_docente($request){
        $docente = Docente::create([
            'rfc' => $request->rfc,
            'curp' => $request->curp,
            'nombre' => $request->nombre,
            'apellidoPat' => $request->apellidoPat,
            'apellidoMat' => $request->apellidoMat,
            'sexo' => $request->sexo,
            'telefono' => $request->telefono,
            'carrera_id' => $request->carrera_id,
            'id_puesto' => $request->id_puesto,
            'tipo_plaza' => $request->tipo_plaza,
            'departamento_id' => $request->departamento_id,
            'user_id' => $request->id,
            'licenciatura' => $request->licenciatura,
            'id_posgrado' => $request->id_posgrado,
            'nombre_completo' => $request->nombre . " " . $request->apellidoPat . " " . $request->apellidoMat
        ]);

        $docente->save();

        return $docente;
    }
    public static function updated_instance_docente($request, $id){
        $docente = Docente::find($id);

        $docente->rfc = $request->rfc;
        $docente->curp = $request->curp;
        $docente->nombre = $request->nombre;
        $docente->apellidoPat = $request->apellidoPat;
        $docente->apellidoMat = $request->apellidoMat;
        $docente->sexo = $request->sexo;
        $docente->telefono = $request->telefono;
        $docente->carrera_id = $request->carrera_id;
        $docente->id_puesto = $request->id_puesto;
        $docente->tipo_plaza = $request->tipo_plaza;
        $docente->departamento_id = $request->departamento_id;
        $docente->user_id = $request->id;
        $docente->licenciatura = $request->licenciatura;
        $docente->id_posgrado = $request->id_posgrado;
        $docente->nombre_completo = $request->nombre . " " . $request->apellidoPat . " " . $request->apellidoMat;

        $docente->save();

        return $docente;
    }

    public static function delete_docente($id){
        $docente = Docente::find($id);
        $docente->delete();
    }
}
