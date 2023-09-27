<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\User;
use App\Notifications\AceptadoNotification;
use App\Notifications\ObservacionNotification;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
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
        $detecciones = DeteccionNecesidades::with('carrera', 'deteccion_facilitador')
            ->where('aceptado', '=', 0)
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
                        ->get();
        return Inertia::render('Views/desarrollo/coordinacion/ShowRegistrosC', [
            'detecciones' => $detecciones,
        ]);
    }

    public function desarrollo_cursos(){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
            ->where('estado' , '=', 0)
            ->orWhere('estado' , '=', 1)
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

        $deteccion->deteccion_facilitador()->sync($request->input('facilitadores', []));

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
        $curso->id_jefe = $departamento->jefe_id;
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

        User::role(['Jefes Academicos'])->each(function(User $user) use ($detecciones){
            $user->notify(new AceptadoNotification($detecciones, $user));
        });

        return Redirect::route('index.detecciones');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deteccion = DeteccionNecesidades::with('carrera', 'deteccion_facilitador')->find($id);

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

        User::role(['Jefes Academicos'])->each(function(User $user) use ($deteccion){
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
        $deteccion = DeteccionNecesidades::find($id);
        $deteccion->docente_inscrito()->sync($request->input('id_docente', []));
        return redirect()->route('index.desarrollo.inscritos', ['id' => $deteccion->id]);
    }


}
