<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
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

class CoursesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoRequest $request)
    {
        try {
            DB::beginTransaction();

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

            $this->sendNotification($deteccion);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return back()->with('error', 'Error a la hora de crear el registro: ' . $exception->getMessage());
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
        $deteccion = DeteccionNecesidades::where('id', $id)->first();

        $deteccion->total_horas = $this->total_horas($request->fecha_I, $request->fecha_F, $request->hora_I, $request->hora_F);

        $deteccion->deteccion_facilitador()->toggle($request->input('facilitadores', []));

        $deteccion->update($request->validated());

        $deteccion->save();

        User::role(['Coordinacion de FD y AP',  'Jefe del Departamento de Desarrollo Academico'])->each(function (User $user) use ($deteccion) {
            $usuario = auth()->user() == null ? $user : auth()->user();
            $user->notify(new DeteccionEditadaNotification($deteccion, $usuario));
        });

        return Redirect::route('detecciones.index');
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
}
