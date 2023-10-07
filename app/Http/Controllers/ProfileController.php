<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $carrera = Carrera::select('nameCarrera', 'id')->get();
        $departamento = Departamento::select('nameDepartamento', 'id')->get();
        $tipoPlaza = DB::table('tipo_plaza')->select('id', 'nombre')->get();
        $puesto = DB::table('puesto')->select('id', 'nombre')->get();
        $posgrado = DB::table('posgrado')->select('id', 'nombre')->get();
        
        $docente = Docente::with('carrera', 'plaza', 'puesto', 'departamento', 'posgrado')->find(auth()->user()->docente_id);
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'docente' => $docente,
            'carrera' => $carrera->except(['11', '12', '13']),
            'departamento' => $departamento,
            'tipo_plaza' => $tipoPlaza,
            'puesto' => $puesto,
            'posgrado' => $posgrado
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function DocenteProfileCreate(Request $request)
    {

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


        User::where('id', $request->id)->update([
            'docente_id' => $docente->id,
        ]);

        return Redirect::route('profile.edit');
    }

    public function update_docente(Request $request, $id)
    {
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

        return Redirect::route('profile.edit');
    }
}
