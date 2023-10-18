<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\Posgrado;
use App\Models\User;
use App\Notifications\AceptadoNotification;
use App\Notifications\ObservacionNotification;
use http\Env\Response;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
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
            'detecciones' => $detecciones,
        ]);
    }

    public function desarrollo_cursos(){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
            ->where('aceptado', '=', 1)
            ->orWhere('estado' , '=', 0)
            ->Where('estado' , '=', 1)
            ->orderBy('id', 'desc')
            ->get();

        CoursesController::state_curso();

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

        User::where('departamento_id', $detecciones->id_departamento)->role(['Jefes Academicos'])->each(function(User $user) use ($detecciones){
            $user->notify(new AceptadoNotification($detecciones, $user));
        });

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

        return Redirect::route('index.detecciones');
    }

    public function index_curso_inscrito_desarrollo($id){
        $docente = Docente::all();
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
            ->find($id);
        return Inertia::render('Views/cursos/desarrollo/InscritosDesarrollo', [
            'curso' => $curso,
            'docente' => $docente,
        ]);
    }

    public function inscripcion_por_desarrollo($id, Request $request){
        $request->validate([
            Rule::unique('inscripcion')->where(function ($query) use ($request) {
                return $query->where('curso_id', $request->id);
            }),
        ]);
        $deteccion = DeteccionNecesidades::find($id);
        $num = count($deteccion->docente_inscrito) + 1;

        if ($num <= $deteccion->numeroProfesores){
            $deteccion->docente_inscrito()->toggle($request->input('id_docente', []));

            return redirect()->route('index.desarrollo.inscritos', ['id' => $deteccion->id]);
        }else{
            return redirect()->route('index.desarrollo.inscritos', ['id' => $deteccion->id])->withErrors('Llego al maximo de docentes que el curso permite inscribir');
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
            'licenciatura' => $request->licenciatura,
            'id_posgrado' => $request->id_posgrado,
            'nombre_completo' => $request->nombre . " " . $request->apellidoPat . " " . $request->apellidoMat
        ]);

        $docente->save();
        return Redirect::route('index.docentes');
    }
    public function edit_docente($id){
        $carrera = Carrera::all();
        $departamento = Departamento::select('nameDepartamento', 'id')->get();
        $tipoPlaza = DB::table('tipo_plaza')->select('id', 'nombre')->get();
        $puesto = DB::table('puesto')->select('id', 'nombre')->get();
        $posgrado = DB::table('posgrado')->select('id', 'nombre')->get();
        $docente = Docente::with('carrera', 'plaza', 'puesto', 'departamento', 'posgrado')->find($id);
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
        $docente->licenciatura = $request->licenciatura;
        $docente->id_posgrado = $request->id_posgrado;
        $docente->nombre_completo = $request->nombre . " " . $request->apellidoPat . " " . $request->apellidoMat;

        $docente->save();

        return Redirect::route('edit.docentes', ['id' => $docente->id]);
    }
}
