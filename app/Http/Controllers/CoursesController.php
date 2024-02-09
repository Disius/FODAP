<?php

namespace App\Http\Controllers;

use App\Events\DeteccionEditadaEvent;
use App\Events\DeteccionEvent;
use App\Http\Requests\CursoRequest;
use App\Models\Carrera;
use App\Models\ClaveCurso;
use App\Models\ClaveValidacion;
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

class CoursesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoRequest $request)
    {
        try {
            DB::beginTransaction();
            $fecha_Inical = Carbon::parse($request->fecha_I);
            $fecha_final = Carbon::parse($request->fecha_F);
            if ($fecha_Inical <= $fecha_final){

                $deteccion = DeteccionNecesidades::create($request->validated() + [
                        'aceptado' => 0,
                        'obs' => 0,
                        'total_horas' => $this->total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F),
                        'id_departamento' => auth()->user()->departamento_id,
                        'facilitador_externo' => $request->facilitador_externo,
                        'id_jefe' => $request->id_jefe
                    ]);

                $deteccion->save();

                $deteccion->deteccion_facilitador()->toggle($request->input('facilitadores', []));

//               DocenteController::facilitadores_permission($request->input('facilitadores'));

                $this->sendNotification($deteccion);

                DB::commit();

                event(new DeteccionEvent($deteccion));
                return Redirect::route('detecciones.create');

            }else{
                return back()->withErrors('La fecha final no puede ser menor que la fecha inicial');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return Redirect::route('detecciones.create')->withErrors('error', 'Error a la hora de crear el registro: ' . $exception->getMessage());
        }
    }

    public static function sendNotification($curso)
    {
        User::role(['Coordinacion de FD y AP', 'Jefe del Departamento de Desarrollo Academico'])->each(function ($user) use ($curso) {
            $usuario = auth()->user() == null ? $user : auth()->user();
            $user->notify(new NewDeteccionNotification($curso, $usuario));
        });
    }

    public function update(CursoRequest $request, string $id)
    {
        $facilitadores = $request->input('facilitadores', []);
        $deteccion = DeteccionNecesidades::where('id', $id)->first();

        $deteccion->total_horas = $this->total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F);

        $deteccion->deteccion_facilitador()->sync([]);

        if(count($facilitadores) > 3){
            return Redirect::back()->withErrors('Excede el limite de facilitadores');
        }
        else{
            $deteccion->deteccion_facilitador()->sync(
                $facilitadores,
                false
            );

            $deteccion->update($request->validated());

            $deteccion->save();

            event(new DeteccionEditadaEvent($deteccion));

            User::role(['Coordinacion de FD y AP',  'Jefe del Departamento de Desarrollo Academico'])->each(function (User $user) use ($deteccion) {
                $usuario = auth()->user() == null ? $user : auth()->user();
                $user->notify(new DeteccionEditadaNotification($deteccion, $usuario));
            });

            return Redirect::route('detecciones.index');
        }
    }



    public static function total_horas($fecha_inicio, $fecha_final, $hora_inicio, $hora_final)
    {
        $fechaInicio = Carbon::parse($fecha_inicio);
        $fechaFinal = Carbon::parse($fecha_final);
        $horaInicio = Carbon::parse($hora_inicio);
        $horaFinal = Carbon::parse($hora_final);

        $diasHabiles = 0;
        $horasTotales = 0;

        //bucle para recorrer la fecha inical hasta la fecha final
        while ($fechaInicio <= $fechaFinal) {
            if ($fechaInicio->isWeekday()) {
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

    public static function state_curso()
    {

        $cursos = DeteccionNecesidades::where('aceptado', 1)->get();
        $now = Carbon::now();
        date_default_timezone_set('America/Mexico_City');
        foreach ($cursos as $curso) {
            if ($now < $curso->fecha_I) {
                $curso->estado = 0;
            } elseif ($now >= $curso->fecha_I && $now <= $curso->fecha_F) {
                $curso->estado = 1;
            } else {
                $curso->estado = 2;
            }
            $curso->save();
        }
    }

    public function assign_clave(){

    }

    public function count_generate_curso_clave(){
        $type = null;
        $anio = date('Y');
        $cursos = DeteccionNecesidades::whereYear('fecha_F', '=', $anio)
            ->orderBy('id', 'asc')
            ->get();

        foreach ($cursos as $curso) {
            // Verificar si el curso ya tiene clave asignada
            $anio = explode("-", $curso->fecha_F);
            if (!ClaveCurso::where('curso_id', $curso->id)->exists()) {
                // Obtener el número de curso
                $n = ClaveCurso::count() + 1;

                // Crear la clave de curso
                $claveCurso = 'TNM-021-' . $n . '-' . $anio[0];
                $clave = ClaveCurso::create([
                    'curso_id' => $curso->id,
                    'clave' => $claveCurso,
                ]);
                $clave->save();

                // Determinar el tipo y crear la clave de validación
                $type = ($curso->tipo_FDoAP == 1) ? 'FD' : 'AP';
                $claveValidacion = 'SA-DDA-' . $type . '-' . $n . '-' . $anio[0];
                $claveV = ClaveValidacion::create([
                    'curso_id' => $curso->id,
                    'clave' => $claveValidacion
                ]);
                $claveV->save();
            }
        }
//        for ($i = 0; $i < $cursos->count(); $i++) {
//            $claveCurso = 'TNM-021-' . $i . '-' . $anio;
//            $clave = ClaveCurso::create([
//                'curso_id' => $cursos[$i]->id,
//                'clave' => $claveCurso,
//            ]);
//            $clave->save();
//
//            switch ($cursos[$i]->tipo_FDoAP){
//                case 1: $type = 'FD';
//                    break;
//                case 2: $type = 'AP';
//                    break;
//            }
//            $claveValidacion = 'SA-DDA-'.$type.'-'.$cursos[$i]->id.'-'.$anio;
//            $claveV = ClaveValidacion::create([
//                'curso_id' => $cursos[$i]->id,
//                'clave' => $claveValidacion
//            ]);
//            $claveV->save();
//
//            break;
//        }
        return redirect()->route('index.desarrollo.cursos')->with('message', 'Claves de cursos generada');

    }

    public static function clave_generar($curso_id){
        $curso = DeteccionNecesidades::find($curso_id);
        $anio = explode("-", $curso->fecha_F);
        $claveCurso = 'TNM-021-' . $curso_id . '-' . $anio[0];

        return ClaveCurso::create([
            'curso_id' => $curso_id,
            'clave' => $claveCurso,
        ]);

    }

    public static function clave_validacion($curso_id){
        $curso = DeteccionNecesidades::find($curso_id);
        $anio = explode("-", $curso->fecha_F);
        $type = null;
        switch ($curso->tipo_FDoAP){
            case 1: $type = 'FD';
                    break;
            case 2: $type = 'AP';
                    break;
        }
        $claveValidacion = 'SA-DDA-'.$type.'-'.$curso->id.'-'.$anio[0];
        return ClaveValidacion::create([
            'curso_id' => $curso->id,
            'clave' => $claveValidacion
        ]);
    }
}
