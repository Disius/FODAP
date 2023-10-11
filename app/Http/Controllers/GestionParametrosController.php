<?php

namespace App\Http\Controllers;

use App\Mail\PermisosUserEdit;
use App\Models\Carrera;
use App\Models\ConfigDates;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\Subdireccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use App\Models\FileFT;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class   GestionParametrosController extends Controller
{
    public function edit(Request $request){
        $users =  User::where('id', '!=', auth()->user()->id)->with('docente', 'departamento', 'permissions')->get();
        $lugar = Lugar::with('curso')->get();
        $departamento = Departamento::with('jefe_docente')->get();
        $carrera = Carrera::with('departamento', 'presidente_academia')->get();
        $docente = Docente::all();
        $sub = Subdireccion::all();
        $fechas = ConfigDates::latest('id')->first();


        return Inertia::render('Views/desarrollo/GestionEdit', [
            'docente' => $docente,
            'carrera_relacion' => $carrera->pluck('departamento'),
            'departamento' => $departamento,
            'carrera' => $carrera->except('13'),
            'lugar' => $lugar,
            'users' => $users,
            'sub' => $sub,
            'fechas' => $fechas
        ]);
    }

    public function create_carrera(Request $request){
        $departamento = Departamento::all();
        $carrera = Carrera::all()->except(['13']);
        $docente = Docente::all();
        return Inertia::render('Views/desarrollo/forms/CreateCarrera', [
            'docente' => $docente,
            'carrera' => $carrera,
            'departamento' => $departamento,
        ]);
    }

    public function store_carrera(Request $request){
        $carrera = Carrera::create([
            'departamento_id' => $request->departamento_id,
            'nameCarrera' => $request->nameCarrera,
            'presidente_academia' => $request->presidente_academia
        ]);

        $carrera->save();

        return Redirect::route('parametros.edit');

    }
    public function edit_carrera(Request $request, $id){
        $carrera = Carrera::find($id);
        $departamento = Departamento::all();
        $docente = Docente::all();

        return Inertia::render('Views/desarrollo/forms/EditCarrera', [
            'docente' => $docente,
            'carrera' => $carrera,
            'departamento' => $departamento,
        ]);
    }
    public function update_carrera(Request $request, $id){
        $carrera = Carrera::find($id);

        $carrera->nameCarrera = $request->nameCarrera;
        $carrera->presidente_academia = $request->presidente_academia;
        $carrera->departamento_id = $request->departamento_id;

        $carrera->save();

        return redirect()->route('parametros.edit');

    }

    public function create_departamento(){
        $departamento = Departamento::with('jefe_docente')->get();
        $carrera = Carrera::all()->except(['13']);
        $docente = Docente::all();
        return Inertia::render('Views/desarrollo/forms/CreateDepartamento', [
            'docente' => $docente,
            'carrera' => $carrera,
            'departamento' => $departamento,
        ]);

    }

    public function store_departamento(Request $request){
        $departamento = Departamento::create([
            'carrera_id' => $request->carrera_id,
            'nameDepartamento' => $request->nameDepartamento,
            'jefe_id' => $request->jefe_id
        ]);

        $departamento->save();

        return Redirect::route('parametros.edit');
    }

    public function edit_departamento(Request $request, $id){
        $departamento = Departamento::find($id);
        $carrera = Carrera::all();
        $docente = Docente::all();

        return Inertia::render('Views/desarrollo/forms/EditDepartamento', [
            'docente' => $docente,
            'carrera' => $carrera,
            'departamento' => $departamento,
        ]);
    }
    public function update_departamento(Request $request, $id){
        $departamento = Departamento::find($id);

        $departamento->nameDepartamento = $request->nameDepartamento;
        $departamento->jefe_id = $request->jefe_id;

        $departamento->save();

        return redirect()->route('parametros.edit');

    }

    public function create_lugar(){
        return Inertia::render('Views/desarrollo/forms/CreateLugar');
    }

    public function store_lugar(Request $request){
        $lugar = Lugar::create($request->all());
        $lugar->save();
        return Redirect::route('parametros.edit');
    }

    public function edit_lugar($id){
        return Inertia::render('Views/desarrollo/forms/EditLugar', [
            'lugar' => Lugar::find($id)
        ]);
    }

    public function update_lugar($id, Request $request){
        $lugar = Lugar::find($id);
        $lugar->nombreAula = $request->nombreAula;
        $lugar->save();
        return Redirect::route('parametros.edit');
    }

    public function delete_lugar($id){
        $lugar = Lugar::find($id);
        $lugar->delete();
        return Redirect::route('parametros.edit');
    }

    public function dates_detecciones(Request $request){
        $dates = ConfigDates::create([
            'fecha_inicio' => $request->fecha_I,
            'fecha_final' => $request->fecha_F,
        ]);

        $dates->save();

        return Redirect::route('parametros.edit');
    }

    public static function if_enable_detecciones(){
        $dates = ConfigDates::latest('id')->first();

        if (empty($dates)){
            return null;
        }else {
            $startDate = Carbon::parse($dates->fecha_inicio);
            $endDate = Carbon::parse($dates->fecha_final);
            $currentDate = Carbon::now('GMT-6');
            $tiemporestante = $currentDate->diff($endDate);
            return [$currentDate->between($startDate, $endDate), $tiemporestante];
        }
    }

    public function destoy_users(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);

        $user = User::find($request->id);

        $user->delete();
        $user->docente->delete();

    }

    public function edit_users($id){
        $departamento = Departamento::all();
        $roles = Role::all();
        $docente = Docente::all();
        $user = User::with('docente', 'departamento')->find($id);
        return Inertia::render('Views/desarrollo/Users/EditUsers', [
            'user' => $user,
            'role' => $user->hasExactRoles(Role::all()),
            'docente' => $docente,
            'departamento' => $departamento,
            'rol' => $roles,
        ]);
    }

    public function update_user(Request $request, $id){
        $request->validate([
            'docente_id' => ['required'],
            'departamento_id' => ['required'],
        ]);

        $user = User::find($id);
        $user->fill([
            'docente_id' => $request->docente_id,
            'departamento_id' => $request->departamento_id
        ]);
        if ($user->role != $request->role){
            $rol = Role::where('id', $request->role)->first();
            $user->syncRoles([]);
            $user->assignRole($rol->name);
        }elseif ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

    }

    public function update_password(Request $request, $id)
    {
        $request->validate([

            'password' => [Password::defaults(), 'confirmed', 'required'],
        ]);

        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        if (auth()->user()->role == 3 || auth()->user()->role == 4){
            Auth::guard('web')->logout();
            return redirect('/');
        }
    }
//en el instalador preguntar que acepta tener permisos!
    public function set_permission($id){
        $user = User::find($id);
        $user->givePermissionTo('edit profile');
        Mail::to($user->email)->send(new PermisosUserEdit(self::admin()));
    }

    public function revoke_permissions($id){
        $user = User::find($id);
        $user->revokePermissionTo('edit profile');
    }
    public static function admin(){
        return User::find(auth()->user()->id);
    }

    public function create_subdireccion(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        $subdireccion = Subdireccion::create([
            'name' => $request->name
        ]);

        $subdireccion->save();

    }
    public function update_subdireccion($id, Request $request){
        $subdireccion = Subdireccion::find($id);

        $subdireccion->delete();

        $subdireccion->name = $request->name;

        $subdireccion->save();
    }

}
