<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AcademicosController extends Controller
{
    public function index()
    {

        $detecciones = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])
            ->where('id_jefe', auth()->user()->docente_id)
            ->where('aceptado', '=', 0)
            ->orderBy('id', 'desc')->get();

        $carrera = Carrera::where('departamento_id', auth()->user()->departamento_id)->get();
        return Inertia::render('Views/academicos/IndexDetecciones', [
            'detecciones' => $detecciones,
            'carrera' => $carrera,
        ]);
    }

    public function create()
    {
        $docentes = Docente::select('nombre_completo', 'id')->get();
        $carrera = Carrera::where('departamento_id', auth()->user()->departamento_id)->select('nameCarrera', 'id', 'departamento_id')->get();
        $departamento = Departamento::all();
        $lugar = Lugar::with('curso')->get();
        return Inertia::render('Views/academicos/CreateDetecciones', [
            'base_docente' => $docentes,
            'carrera_filtro' => $carrera,
            'todos_los_departamentos' => $departamento,
            'lugar' => $lugar
        ]);
    }


    private static function consult_view($query)
    {
        return DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('id', $query)->first();
    }


    public function show(string $id)
    {
        return Inertia::render('Views/academicos/ShowDetecciones', [
            'deteccion' => $this->consult_view($id),
        ]);
    }

    public function detecciones_data()
    {
        $detecciones = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])
            ->where('id_jefe', auth()->user()->docente_id)
            ->where('aceptado', '=', 0)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'detecciones' => $detecciones
        ]);
    }

    public function edit(string $id)
    {
        $carrera = Carrera::where('departamento_id', auth()->user()->departamento_id)->select('nameCarrera', 'id', 'departamento_id')->get();
        $docente = Docente::all();
        $lugar = Lugar::with('curso')->get();
        return Inertia::render('Views/academicos/EditDetecciones', [
            'deteccion' => $this->consult_view($id),
            'carrera' => $carrera,
            'docentes' => $docente,
            'lugar' => $lugar,
        ]);
    }

    public function registros()
    {
        $detecciones = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])
            ->where('aceptado', '=', 1)
            ->where('id_jefe', auth()->user()->docente_id)
            ->where('estado', '=', 2)
            ->orderBy('id', 'desc')
            ->get();
        return Inertia::render('Views/academicos/IndexRegistros', [
            'detecciones' => $detecciones
        ]);
    }

    public function index_cursos_academico()
    {
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
            ->where('aceptado', '=', 1)
            ->where('estado', '=', 0)
            ->where('estado', '=', 1)
            ->orWhere('id_jefe', '=', auth()->user()->docente_id)
            ->get();

        //Actualiza el estado del curso
        CoursesController::state_curso();

        return Inertia::render('Views/cursos/academicos/CursosAcademicos', [
            'cursos' => $cursos,
        ]);
    }

    public function index_cursos_inscritos($id)
    {
        return Inertia::render('Views/cursos/academicos/ShowInscritos', [
            'curso' => $this->consult_view($id),
            'docente' => Docente::all(),
        ]);
    }

    public function inscripcion_academicos(Request $request, $id)
    {
        $request->validate([
            Rule::unique('inscripcion')->where(function ($query) use ($request) {
                return $query->where('curso_id', $request->id);
            }),
        ]);
        $deteccion = DeteccionNecesidades::find($id);
        $num = count($deteccion->docente_inscrito) + 1;

        if ($num <= $deteccion->numeroProfesores){
            $deteccion->docente_inscrito()->toggle($request->input('id_docente', []));

            return Redirect::route('show.inscritos.academicos', ['id' => $deteccion->id]);
        }else{
            return Redirect::route('show.inscritos.academicos', ['id' => $deteccion->id])->withErrors('Llego al maximo de docentes que el curso permite inscribir');
        }
        
    }
}
