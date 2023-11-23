<?php

namespace App\Http\Controllers;

use App\Events\CalificacionEvent;
use App\Events\CursosAceptados;
use App\Events\DeleteDeteccionEvent;
use App\Events\InscripcionEvent;
use App\Events\ObservacionEvent;
use App\Http\Requests\CursoRequest;
use App\Models\Calificaciones;
use App\Models\Carrera;
use App\Models\ClaveCurso;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\User;
use App\Notifications\AceptadoNotification;
use App\Notifications\ObservacionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DesarrolloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carrera = Carrera::all();
        $detecciones = DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'jefe')
            ->where('aceptado', '=', 0)
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('Views/desarrollo/coordinacion/DeteccionCoordinacion', [
            'detecciones' => $detecciones,
            'carrera' => $carrera
        ]);
    }

    public function index_registros(){
        $detecciones = DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'docente_inscrito')
            ->where('aceptado', '=', 1)
            ->where('estado', '=', 2)
            ->orderBy('id', 'desc')
            ->get();
        return Inertia::render('Views/desarrollo/coordinacion/ShowRegistrosC', [
            'cursos' => $detecciones,
        ]);
    }

    public function desarrollo_cursos(){

        CoursesController::state_curso();

        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
            ->where('aceptado', '=', 1)
            ->where(function($query) {
                $query->where('estado', '=', 0)
                    ->orWhere('estado', '=', 1);
            })
            ->orderBy('id', 'desc')
            ->get();


        return Inertia::render('Views/cursos/desarrollo/DesarrolloCursos', [
            'cursos' => $cursos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $docentes = Docente::select('nombre_completo', 'id')->get();
        $carrera = Carrera::all();
        $departamento = Departamento::all();
        $lugar = Lugar::with('curso')->get();
        return Inertia::render('Views/cursos/desarrollo/registros/CreateCurso', [
            'docente' => $docentes,
            'carrera' => $carrera,
            'todos_los_departamentos' => $departamento,
            'lugar' => $lugar
        ]);
    }
    public function store_cursos(CursoRequest $request)
    {

        $totalHoras = CoursesController::total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F);

        $departamento = $this->query_carrera($request->carrera_dirigido);

        $deteccion = DeteccionNecesidades::create($request->validated() + [
                'id_jefe' => $departamento->departamento->jefe_id,
                'aceptado' => 1,
                'obs' => $request->observaciones != null ? 1 : 0,
                'total_horas' => $totalHoras,
                'id_departamento' => $departamento->departamento->id,
                'facilitador_externo' =>  $request->facilitador_externo,
                'observaciones' => $request->observaciones,
            ]);

        $deteccion->deteccion_facilitador()->toggle($request->input('facilitadores', []));

        $deteccion->save();

        return Redirect::route('index.desarrollo.cursos');
    }

    public function edit_curso($id){
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->find($id);
        $carrera = Carrera::all();
        $docente = Docente::all();
        $departamento = Departamento::all();
        $lugar = Lugar::with('curso')->get();
        return Inertia::render('Views/cursos/desarrollo/registros/EditCurso', [
            'curso' => $curso,
            'carrera' => $carrera,
            'docentes' => $docente,
            'todos_los_departamentos' => $departamento,
            'lugar' => $lugar,
        ]);

    }

    public function update_curso(CursoRequest $request, $id){
        $totalHoras = CoursesController::total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F);
        $departamento = $this->query_carrera($request->carrera_dirigido);

        $curso = DeteccionNecesidades::find($id);
        $curso->id_jefe = $departamento->departamento->jefe_id;
        $curso->total_horas = $totalHoras;
        $curso->id_departamento = $departamento->departamento->id;
        $curso->facilitador_externo = $request->facilitador_externo;
        $curso->observaciones = $request->observaciones;
        $curso->obs = $request->observaciones != null ? 1 : 0;
        $curso->deteccion_facilitador()->sync($request->input('facilitadores', []));
        $curso->update($request->validated());

        $curso->save();

        return Redirect::route('index.desarrollo.inscritos', ['id' => $curso->id]);
    }

    public static function query_carrera($query){
        return Carrera::with('departamento')->where('id', '=', $query)->first();
    }
    public static function query_consult_carrera(){
        return Carrera::with('departamento')->get();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'aceptado' => ['required']
        ]);


        $detecciones = DeteccionNecesidades::find($id);

        $detecciones->aceptado = $request->aceptado;

        $detecciones->save();

        event(new CursosAceptados($detecciones));

        User::where('departamento_id', $detecciones->id_departamento)->role(['Jefes Academicos'])->each(function(User $user) use ($detecciones){
            $user->notify(new AceptadoNotification($detecciones, $user));
        });

        $this->clave_generar($id);

        return Redirect::route('index.detecciones');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deteccion = DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'jefe')->find($id);

        return Inertia::render('Views/desarrollo/coordinacion/ShowDeteccionCoordinacion', [
            'deteccion' => $deteccion
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'observaciones' => ['required']
        ]);

        $deteccion = DeteccionNecesidades::where('id', $id)->first();

        $deteccion->update([
            'observaciones' => $request->observaciones,
            'obs' => 1
        ]);

        User::where('departamento_id', $deteccion->id_departamento)->role(['Jefes Academicos'])->each(function(User $user) use ($deteccion){
            $user->notify(new ObservacionNotification($deteccion, $user));
        });

        event(new ObservacionEvent($deteccion));

        return Redirect::route('show.Cdetecciones', ['id' => $id]);
    }

    public function index_curso_inscrito_desarrollo($id){
        $docente = Docente::orderBy('nombre', 'asc')->get();
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
            ->find($id);
        return Inertia::render('Views/cursos/desarrollo/InscritosDesarrollo', [
            'curso' => $curso,
            'docente' => $docente,
        ]);
    }

    public function delete($id){
        $deteccion = DeteccionNecesidades::find($id);

        event(new DeleteDeteccionEvent($deteccion));


        $deteccion->delete();

        if ($deteccion->aceptado == 1){
            return Redirect::route('index.desarrollo.cursos');
        }

        return Redirect::route('index.detecciones');
    }


    public function inscripcion_por_desarrollo($id, Request $request)
    {
        $deteccion = DeteccionNecesidades::find($id);
        $num = count($deteccion->docente_inscrito) + 1;


        if ($num <= $deteccion->numeroProfesores) {


            $this->itareble_inscritos($request->id_docente, $deteccion);

            $syncDeteccion = DB::table('docente')
                ->join('inscripcion', 'inscripcion.docente_id', '=', 'docente.id')
                ->leftJoin('calificaciones', function ($join) {
                    $join->on('calificaciones.docente_id', '=', 'docente.id')
                        ->on('calificaciones.curso_id', '=', 'inscripcion.curso_id');
                })
                ->where('inscripcion.curso_id', '=', $request->id)
                ->select('docente.*', 'calificaciones.calificacion', 'inscripcion.curso_id AS inscripcion_curso_id')
                ->get();

            event(new InscripcionEvent($syncDeteccion));

            return redirect()->route('index.desarrollo.inscritos', ['id' => $deteccion->id]);
        } else {
            return redirect()->route('index.desarrollo.inscritos', ['id' => $deteccion->id])->withErrors('Llego al maximo de docentes que el curso permite inscribir');
        }
    }
    public function itareble_inscritos($docente_id, $deteccion){
        foreach ($docente_id as $docente){
            if(!$deteccion->docente_inscrito()->where('docente_id', $docente)->exists()){
                $deteccion->docente_inscrito()->attach($docente);
            }else{
                return back()->withErrors('Este docente ya esta inscrito');
            }
            }
        }


    public function docentes(){
        $docentes = Docente::with('usuario')->orderBy('nombre')->get();
        $user = User::with('docente')->get();
        return Inertia::render('Views/desarrollo/Docentes', [
            'docentes' => $docentes,
            'user' => $user,
        ]);
    }
    public function create_docentes(){
        $carrera = Carrera::all();
        $departamento = Departamento::select('nameDepartamento', 'id')->get();
        $tipoPlaza = DB::table('tipo_plaza')->select('id', 'nombre')->get();
        $puesto = DB::table('puesto')->select('id', 'nombre')->get();
        $posgrado = DB::table('posgrado')->select('id', 'nombre')->get();
        return Inertia::render('Views/desarrollo/docente/CreateDocente', [
            'carrera' => $carrera->except(['13']),
            'departamento' => $departamento,
            'tipo_plaza' => $tipoPlaza,
            'puesto' => $puesto,
            'posgrado' => $posgrado,
        ]);
    }
    public function store_docentes(Request $request){
        AcademicosController::create_instance_docente($request);
        return Redirect::route('index.docentes');
    }
    public function edit_docente($id){
        $carrera = $this->query_consult_carrera();
        $tipoPlaza = DB::table('tipo_plaza')->select('id', 'nombre')->get();
        $puesto = DB::table('puesto')->select('id', 'nombre')->get();
        $posgrado = DB::table('posgrado')->select('id', 'nombre')->get();
        $docente = Docente::with('carrera', 'plaza', 'puesto', 'departamento', 'posgrado')->find($id);
        $departamento = Departamento::select('nameDepartamento', 'id')->get();
        return Inertia::render('Views/desarrollo/docente/EditDocente', [
            'carrera' => $carrera->except(['13']),
            'departamento' => $departamento,
            'tipo_plaza' => $tipoPlaza,
            'puesto' => $puesto,
            'posgrado' => $posgrado,
            'docente' => $docente
        ]);
    }

    public function update_docente(Request $request, $id){
        $docente = AcademicosController::updated_instance_docente($request, $id);
        return Redirect::route('edit.docentes', ['id' => $docente->id]);
    }
    //revisar este otro metodo
    public function calificaciones_desarrollo(Request $request){
        $request->validate([
            'docente_id' => 'required',
            'calificacion' => 'required',
            'curso_id' => 'required',
        ]);

        if (Calificaciones::where('curso_id', $request->curso_id)->exists()){
            DocenteController::update_calificacion($request, $request->docente_id);
        }else{
            DocenteController::add_calificacion($request);
        }
            $syncCalificacion = $this->consult_to_sync($request->curso_id, $request->docente_id);
            event(new CalificacionEvent($syncCalificacion));

        return Redirect::route('index.desarrollo.inscritos', ['id' => $request->curso_id]);
    }

    public static function consult_to_sync($curso_id, $docente_id){
        $syncCalificacion = DB::table('docente')
            ->join('inscripcion', 'inscripcion.docente_id', '=', 'docente.id')
            ->leftJoin('calificaciones', function($join) {
                $join->on('calificaciones.docente_id', '=', 'docente.id')
                    ->on('calificaciones.curso_id', '=', 'inscripcion.curso_id'); // Agregar esta condición
            })
            ->where('inscripcion.curso_id', '=', $curso_id)
            ->where('docente.id', '=', $docente_id)
            ->select('docente.*', 'calificaciones.calificacion', 'inscripcion.id AS inscripcion')
            ->get();
        return $syncCalificacion;
    }

    public static function clave_generar($curso_id){
        $anioActual = date('Y');

        $claveCurso = 'TNM-021-' . $curso_id . '-' . $anioActual;

        return ClaveCurso::create([
            'curso_id' => $curso_id,
            'clave' => $claveCurso,
        ]);

    }
}
