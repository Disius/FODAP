<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicosController extends Controller
{
    public function index(){

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

    public function create(){
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


    private static function consult_view($query){
        return DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])->where('id', $query)->first();
    }


    public function show(string $id)
    {
        return Inertia::render('Views/academicos/Show.Detecciones', [
            'deteccion' => $this->consult_view($id),
        ]);
    }

    public function edit(string $id)
    {
        $carrera = Carrera::where('departamento_id', auth()->user()->departamento_id)->select('nameCarrera', 'id', 'departamento_id')->get();
        $docente = Docente::select('id', 'nombre_completo')->get();
        $lugar = Lugar::with('curso')->get();
        return Inertia::render('Views/academicos/Edit.Detecciones', [
            'deteccion' => $this->consult_view($id),
            'carrera' => $carrera,
            'docentes' => $docente,
            'lugar' => $lugar,
        ]);
    }

    public function registros(){
        $detecciones = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador'])
            ->where('aceptado', '=', 1)->where('id_jefe', auth()->user()->docente_id)->orderBy('id', 'desc')->get();
        return Inertia::render('Views/academicos/IndexRegistros', [
            'detecciones' => $detecciones
        ]);
    }

    public function index_cursos_academico(){
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])->where('aceptado', '=', 1)
            ->where('id_jefe', '=', auth()->user()->docente_id)
            ->get();

        //Actualiza el estado del curso
        CoursesController::state_curso();

        return Inertia::render('Views/cursos/academicos/CursosAcademicos', [
            'cursos' => $cursos,
        ]);
    }
}
