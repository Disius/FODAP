<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\User;
use App\Notifications\DeteccionEditadaNotification;
use App\Notifications\NewDeteccionNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use PhpParser\Node\Stmt\Return_;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $detecciones = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])
            ->where('id_jefe', auth()->user()->docente_id)
            ->where('aceptado', '=', 0)
            ->orderBy('id', 'desc')->get();

        $carrera = Carrera::select('id', 'nameCarrera')->get();
        return Inertia::render('Views/academicos/Index.Detecciones',[
            'detecciones' => $detecciones,
            'carrera' => $carrera,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $docentes = Docente::select('nombre', 'id')->get();
        $carrera = Carrera::where('departamento_id', auth()->user()->departamento_id)->select('nameCarrera', 'id', 'departamento_id')->get();
        $departamento = Departamento::all();
//        $lugar = Lugar::select('id', 'nombreAula')->get();
        $lugar = DB::table('lugar')->get();
        return Inertia::render('Views/academicos/Create.Detecciones', [
            'base_docente' => $docentes,
            'carrera_filtro' => $carrera,
            'todos_los_departamentos' => $departamento,
            'lugar' => $lugar
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        ]);

        $totalHoras = $this->total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F);

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
            'aceptado' => 0,
            'obs' => 0,
            'total_horas' => $totalHoras,
            'modalidad' => $request->modalidad,
            'facilitador_externo' =>  $request->facilitador_externo,
            'id_departamento' => $request->id_departamento
        ]);

        $deteccion->save();

        $deteccion->deteccion_facilitador()->sync($request->input('facilitadores', []));

        User::role(['Coordinacion de FD y AP'])->each(function(User $user) use ($deteccion){
            $user->notify(new NewDeteccionNotification($deteccion, $user));
        });

        return redirect()->route('detecciones.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deteccion = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])->where('id', $id)->first();

        return Inertia::render('Views/academicos/Show.Detecciones', [
            'deteccion' => $deteccion,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deteccion = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])->where('id', $id)->first();
        $carrera = Carrera::where('departamento_id', auth()->user()->departamento_id)->select('nameCarrera', 'id', 'departamento_id')->get();
        $docente = Docente::select('id', 'nombre')->get();
        return Inertia::render('Views/academicos/Edit.Detecciones', [
            'deteccion' => $deteccion,
            'carrera' => $carrera,
            'docentes' => $docente
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $totalHoras = $this->total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F);

        $deteccion = DeteccionNecesidades::find($id);

        $deteccion->asignaturaFA = $request->AsignaturasFA;
        $deteccion->contenidosTM = $request->ContenidoTFA;
        $deteccion->numeroProfesores = $request->Numprofesores;
        $deteccion->periodo = $request->periodo;
        $deteccion->nombreCurso = $request->nombreCT;
        $deteccion->fecha_I = $request->fecha_I;
        $deteccion->fecha_F = $request->fecha_F;
        $deteccion->hora_I = $request->hora_I;
        $deteccion->hora_F = $request->hora_F;
        $deteccion->tipo_FDoAP = $request->tipo;
        $deteccion->tipo_actividad = $request->tipo_act;
        $deteccion->objetivoEvento = $request->objetivo;
        $deteccion->carrera_dirigido = $request->dirigido;
        $deteccion->id_jefe = $request->id_jefe;
        $deteccion->modalidad = $request->modalidad;
        $deteccion->total_horas = $totalHoras;
        $deteccion->deteccion_facilitador()->sync($request->input('facilitadores', []));

        $deteccion->save();

        User::role(['Coordinacion de FD y AP'])->each(function(User $user) use ($deteccion){
            $user->notify(new DeteccionEditadaNotification($deteccion, $user));
        });

        return Redirect::route('detecciones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function registros(){
        $detecciones = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])
            ->where('aceptado', '=', 1)->where('id_jefe', auth()->user()->docente_id)->orderBy('id', 'desc')->get();
        return Inertia::render('Views/academicos/Index.Registros', [
            'detecciones' => $detecciones
        ]);
    }

    public function index_cursos(){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
//            ->where('id_jefe', auth()->user()->docente_id)
        ->get();
        return Inertia::render('Views/cursos/CursosDocentes', [
            'cursos' => $cursos
        ]);
    }

    public function index_cursos_academico(){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
            ->where('id_jefe', '=', auth()->user()->docente_id)
        ->get();
        return Inertia::render('Views/cursos/academicos/CursosAcademicos', [
            'cursos' => $cursos
        ]);
    }

    public function index_curso_inscrito($id){
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
            ->find($id);
        return Inertia::render('Views/cursos/academicos/Show.Inscritos', [
            'curso' => $curso
        ]);
    }

    public function index_curso_inscrito_desarrollo($id){
        $curso = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
            ->find($id);
        return Inertia::render('Views/cursos/desarrollo/Inscritos.Desarrollo', [
            'curso' => $curso
        ]);
    }
    public function inscripcion_docente(Request $request, $id){
        $deteccion = DeteccionNecesidades::find($id);
        $deteccion->docente_inscrito()->sync($request->input('id_docente'));
        return Redirect::route('index.cursos.docentes');
    }

    public function misCursos(){
        $docente = Docente::with('inscrito')->where('id', '=', auth()->user()->docente_id)->first();

        return Inertia::render('Views/cursos/MisCursosDocentes', [
            'docente' => $docente,
        ]);
    }

    public function desarrollo_cursos(){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
            ->get();

        return Inertia::render('Views/cursos/desarrollo/Desarrollo.Cursos', [
            'cursos' => $cursos,
        ]);
    }

    public function total_horas($fecha_inicio, $fecha_final, $hora_inicio, $hora_final){
        $fechaInicio = Carbon::parse($fecha_inicio);
        $fechaFinal = Carbon::parse($fecha_final);
        $horaInicio = Carbon::parse($hora_inicio);
        $horaFinal = Carbon::parse($hora_final);

        $diasHabiles = 0;
        $horasTotales = 0;

        //bucle para recorrer la fecha inical hasta la fecha final
        while($fechaInicio <= $fechaFinal){
            if ($fechaInicio->isWeekday()){
                $diasHabiles++;

                //aqui calcula las horas del dia en base al horario
                $horaEnDia = $horaFinal->diffInHours($horaInicio);
                $horasTotales += $horaEnDia;
            }

            //de ser falso avanza al siguiente dia
            $fechaInicio->addDay();
        }

        return $horasTotales;
    }
}
