<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\User;
use App\Notifications\AceptadoNotification;
use App\Notifications\ObservacionNotification;
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
                        ->get();
        return Inertia::render('Views/desarrollo/coordinacion/ShowRegistrosC', [
            'detecciones' => $detecciones,
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

    public function store_cursos(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'AsignaturasFA' => 'required',
            'ContenidoTFA' => 'required',
            'Numprofesores' => 'required',
            'periodo' => 'required',
            'nombreCT' => 'required',
            'fecha_I' => 'required',
            'fecha_F' => 'required',
            'hora_I' => 'required',
            'hora_F' => 'required',
            'objetivo' => 'required',
            'tipo' => 'required',
            'tipo_act' => 'required',
            'dirigido' => 'required',
            'id_jefe' => 'required',
            'modalidad' => ['required'],
            'id_departamento' => ['required'],
            'id_lugar' => ['required'],
        ]);

        $totalHoras = CoursesController::total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F);

        $deteccion = DeteccionNecesidades::create([
            'asignaturaFA' => $request->AsignaturasFA,
            'contenidosTM' => $request->ContenidoTFA,
            'numeroProfesores' => $request->Numprofesores,
            'periodo' => $request->periodo,
            'nombreCurso' => $request->nombreCT,
            'fecha_I' => $request->fecha_I,
            'fecha_F' => $request->fecha_F,
            'hora_I' => $request->hora_I,
            'hora_F' => $request->hora_F,
            'objetivoEvento' => $request->objetivo,
            'tipo_FDoAP' => $request->tipo,
            'tipo_actividad' => $request->tipo_act,
            'carrera_dirigido' => $request->dirigido,
            'id_jefe' => $request->id_jefe,
            'aceptado' => 1,
            'obs' => 0,
            'total_horas' => $totalHoras,
            'modalidad' => $request->modalidad,
            'facilitador_externo' =>  $request->facilitador_externo,
            'id_departamento' => $request->id_departamento,
            'id_lugar' => $request->id_lugar,
        ]);

        $deteccion->save();

        return Redirect::route('index.desarrollo.cursos');
    }

    public function edit_curso($id){
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->find($id);
        $carrera = Carrera::all();
        $docente = Docente::select('id', 'nombre_completo')->get();
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

    public function update_curso(Request $request, $id){
        $totalHoras = CoursesController::total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F);
        
        $curso = DeteccionNecesidades::find($id);

        $curso->asignaturaFA = $request->AsignaturasFA;
        $curso->contenidosTM = $request->ContenidoTFA;
        $curso->numeroProfesores = $request->Numprofesores;
        $curso->periodo = $request->periodo;
        $curso->nombreCurso = $request->nombreCT;
        $curso->fecha_I = $request->fecha_I;
        $curso->fecha_F = $request->fecha_F;
        $curso->hora_I = $request->hora_I;
        $curso->hora_F = $request->hora_F;
        $curso->tipo_FDoAP = $request->tipo;
        $curso->tipo_actividad = $request->tipo_act;
        $curso->objetivoEvento = $request->objetivo;
        $curso->carrera_dirigido = $request->dirigido;
        $curso->id_jefe = $request->id_jefe;
        $curso->modalidad = $request->modalidad;
        $curso->total_horas = $totalHoras;
        $curso->deteccion_facilitador()->sync($request->input('facilitadores', []));

        $curso->save();


        return Redirect::route('detecciones.index');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
