<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\DeteccionNecesidades;
use App\Models\User;
use App\Notifications\AceptadoNotification;
use App\Notifications\ObservacionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CoordinacionController extends Controller
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
        return Inertia::render('Views/desarrollo/coordinacion/Show.Registros.C', [
            'detecciones' => $detecciones,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
