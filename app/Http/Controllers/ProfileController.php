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
        $user = User::find(auth()->user()->id);



        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'docente' => $docente,
            'carrera' => $carrera->except(['13']),
            'departamento' => $departamento,
            'tipo_plaza' => $tipoPlaza,
            'puesto' => $puesto,
            'posgrado' => $posgrado,
            'permiso_to_edit' => $user->hasPermissionTo('edit profile'),
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
        try {
            $request->validate([
                'rfc' => 'required',
                'curp' => 'required',
                'nombre' => 'required',
                'apellidoPat' => 'required',
                'apellidoMat' => 'required',
            ]);

            $docente_find = Docente::where('nombre', $request->nombre)
                ->where('apellidoPat', $request->apellidoPat)
                ->where('apellidoMat', $request->apellidoMat)
                ->first();

            if ($docente_find){
                User::where('id', $request->id)->update([
                    'docente_id' => $docente_find->id,
                ]);

                $docente_find->update([
                    'user_id' => $request->id
                ]);

                $docente_find->save();
            }else {
                $docente = DocenteController::create_instance_docente($request);

                $docente->save();

                User::where('id', $request->id)->update([
                    'docente_id' => $docente->id,
                ]);
            }
            return Redirect::route('dashboard');

        }catch (\Exception $exception){
            DB::rollBack();
            return Redirect::route('profile.edit')->withErrors('error', 'Error a la hora de crear el registro: ' . $exception->getMessage());
        }
    }

    public function update_docente(Request $request, $id)
    {
        $docente = DocenteController::updated_instance_docente($request, $id);

        $docente->save();

        return Redirect::route('profile.edit');
    }
}
