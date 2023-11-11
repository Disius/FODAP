<?php

namespace App\Http\Controllers;

use App\Events\InscripcionEvent;
use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            ->orderBy('id', 'desc')->paginate(5);
        CoursesController::state_curso();
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
            ->where('id_jefe', auth()->user()->docente_id)
            ->where(function ($query){
                $query->where('aceptado', '=', 1)
                    ->where('estado', '=', 2);
            })
            ->orderBy('id', 'desc')
            ->paginate(5);
        return Inertia::render('Views/academicos/IndexRegistros', [
            'detecciones' => $detecciones
        ]);
    }

    public function index_cursos_academico()
    {
        $cursos = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'docente_inscrito'])
            ->where('id_jefe', '=', auth()->user()->docente_id)
            ->where('aceptado', '=', 1)
            ->where(function($query) {
                $query->where('estado', '=', 0)
                    ->orWhere('estado', '=', 1);
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        //Actualiza el estado del curso
        CoursesController::state_curso();

        return Inertia::render('Views/cursos/academicos/CursosAcademicos', [
            'cursos' => $cursos,
        ]);
    }

    public function index_cursos_inscritos($id)
    {
        CoursesController::state_curso();
        return Inertia::render('Views/cursos/academicos/ShowInscritos', [
            'curso' => $this->consult_view($id),
            'docente' => Docente::orderBy('nombre', 'asc')->get(),
        ]);
    }

    public function inscripcion_academicos(Request $request, $id)
    {
        $deteccion = DeteccionNecesidades::find($id);

        $num = count($deteccion->docente_inscrito) + 1;


        if ($num <= $deteccion->numeroProfesores){



            foreach ($request->id_docente as $docente){
                if(!$deteccion->docente_inscrito()->where('docente_id', $docente)->exists()){
                    $deteccion->docente_inscrito()->attach($docente);
                }else{
                    return back()->withErrors('Este docente ya esta inscrito');
                }
            }



            $syncDeteccion = DB::table('docente')
                ->join('inscripcion', 'inscripcion.docente_id', '=', 'docente.id')
                ->leftjoin('calificaciones', 'calificaciones.docente_id', '=', 'docente.id')
                ->where('inscripcion.curso_id', '=', $id)
                ->select('docente.*', 'calificaciones.calificacion', 'inscripcion.id AS inscripcion')
                ->get();

            event(new InscripcionEvent($syncDeteccion));

            return redirect()->route('show.inscritos.academicos', ['id' => $deteccion->id]);
        }else{
            return redirect()->route('show.inscritos.academicos', ['id' => $deteccion->id])->withErrors('Llego al maximo de docentes que el curso permite inscribir');
        }

    }

    public function index_docentes_academicos(){
        $docentes = Docente::with('usuario')
            ->where('departamento_id', '=', auth()->user()->departamento_id)
            ->orderBy('nombre')
            ->paginate(10);
        CoursesController::state_curso();
        $user = User::with('docente')->get();
        return Inertia::render('Views/academicos/docentes/DocentesA', [
            'docentes' => $docentes,
            'user' => $user,
        ]);
    }
    public function create_docentes_academicos(Request $request){
        $carrera = Carrera::where('departamento_id', auth()->user()->departamento_id)->get();
        $departamento = Departamento::where('id', auth()->user()->departamento_id)->get();
        $tipoPlaza = DB::table('tipo_plaza')->get();
        $puesto = DB::table('puesto')->select('id', 'nombre')->get();
        $posgrado = DB::table('posgrado')->select('id', 'nombre')->get();
        return Inertia::render('Views/academicos/docentes/CreateDocenteA', [
            'carrera' => $carrera,
            'departamento' => $departamento,
            'tipo_plaza' => $tipoPlaza,
            'puesto' => $puesto,
            'posgrado' => $posgrado,
            'from_form' => $request->input('from_form')
        ]);
    }
    public function docente_created_from_form(Request $request){
        $this->create_instance_docente($request);
        return Redirect::route('detecciones.create');
    }
    public function created_docentes_academicos(Request $request){
        $this->create_instance_docente($request);

        return Redirect::route('index.docentes.academicos');
    }

    public function edit_docente_academico($id){
        $carrera = Carrera::all();
        $departamento = Departamento::select('nameDepartamento', 'id')->get();
        $tipoPlaza = DB::table('tipo_plaza')->select('id', 'nombre')->get();
        $puesto = DB::table('puesto')->select('id', 'nombre')->get();
        $posgrado = DB::table('posgrado')->select('id', 'nombre')->get();
        $docente = Docente::with('carrera', 'plaza', 'puesto', 'departamento', 'posgrado')->find($id);
        return Inertia::render('Views/academicos/docentes/EditDocenteA', [
            'carrera' => $carrera,
            'departamento' => $departamento,
            'tipo_plaza' => $tipoPlaza,
            'puesto' => $puesto,
            'posgrado' => $posgrado,
            'docente' => $docente
        ]);
    }
    public function update_docente_academico(Request $request, $id){

        $docente = $this->updated_instance_docente($request, $id);
        return Redirect::route('edit.docentes.academicos', ['id' => $docente->id]);
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
}
