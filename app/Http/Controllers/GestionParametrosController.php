<?php

namespace App\Http\Controllers;

use App\Events\DatesEnableEvent;
use App\Http\Controllers\API\v1\DataResponseController;
use App\Mail\PermisosUserEdit;
use App\Models\Carrera;
use App\Models\ConfigDates;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Director;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\NombreInstituto;
use App\Models\Subdireccion;
use App\Models\User;
use App\Rules\ValidFileExtension;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
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
        $director = Director::all();
        $fechas = ConfigDates::latest('id')->first();
        $instituto = NombreInstituto::all();

        return Inertia::render('Views/desarrollo/GestionEdit', [
            'docente' => $docente,
            'carrera_relacion' => $carrera->pluck('departamento'),
            'departamento' => $departamento,
            'carrera' => $carrera->except('13'),
            'lugar' => $lugar,
            'users' => $users,
            'sub' => $sub,
            'fechas' => $fechas,
            'director' => $director,
            'instituto' => $instituto,
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

        return redirect()->route('edit.carrera', ['id' => $id]);

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

        return redirect()->route('edit.departamento', ['id' => $id]);

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
        if ($request->fecha_Inicio <= $request->fecha_Final) {
            try {
                // Establecer la zona horaria aquí
                date_default_timezone_set('America/Mexico_City'); // O la zona horaria deseada

                $dates = ConfigDates::latest('id')->first();

                if ($dates != null) {
                    $dates->delete();
                }

                $newDates = ConfigDates::create([
                    'fecha_inicio' => $request->fecha_Inicio,
                    'fecha_final' => $request->fecha_Final,
                ]);

                $newDates->save();

                $fechas = DataResponseController::if_enable_detecciones();

                event(new DatesEnableEvent($fechas->original));

                return Redirect::route('parametros.edit');
            } catch (\Exception $e) {
                return back()->withErrors('Error al crear el registro'.$e->getMessage());
            }
        } else {
            return back()->withErrors('La fecha final no puede ser menor que la fecha inicial');
        }
    }

    public function destoy_users(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);

        $user = User::find($request->id);

        $user->delete();
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
    public function edit_email(Request $request, $id){
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::find($id);
        $user->update([
            'email' => $request->email
        ]);

        $user->save();

        return redirect()->route('edit.docentes', ['id' => $user->docente_id]);
    }
    public function update_user(Request $request, $id){
        $request->validate([
            'docente_id' => ['required'],
            'departamento_id' => ['required'],
            'role' => ['required']
        ]);

        $user = User::find($id);
        $user->update([
            'docente_id' => $request->docente_id,
            'departamento_id' => $request->departamento_id,
            'role' => $request->role,
        ]);

//        Docente::where('id', $request->docente_id)->update([//actualiza el user id, es decir, que si cristina se logea
//            'user_id' => $user->id
//        ]);
        $rol = Role::where('id', $request->role)->first();
        $user->syncRoles([]);
        $user->assignRole($rol->name);

        if ($user->isDirty('email')) {
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

    public function subir_cvu(Request $request){
        $request->file('file')->storeAs('/CVUdownload/', 'CVU_editable.docx', 'public');
        return redirect()->route('parametros.edit');
    }
    public function subir_img_acta(Request $request){
        $request->validate([
            'file' => ['required', 'mimes:jpg,jpeg,png'],
        ]);
        $year = date('Y');
        $path = '/Membretado/'.$year;
        $request->file('file')->storeAs($path, 'img_acta_calificaciones.jpg', 'public');
        return redirect()->route('parametros.edit');
    }
    public function subir_img_constancia(Request $request){
        $request->validate([
            'file' => ['required', 'mimes:jpg,jpeg,png'],
        ]);
        $year = date('Y');
        $path = '/Membretado/'.$year;
        $request->file('file')->storeAs($path, 'img_constancia.jpg', 'public');
        return redirect()->route('parametros.edit');
    }
    public function subir_img_constancia_2(Request $request){
        $request->validate([
            'file' => ['required', 'mimes:jpg,jpeg,png'],
        ]);
        $year = date('Y');
        $path = '/Membretado/'.$year;
        $request->file('file')->storeAs($path, 'logo_constancia_page_2.png', 'public');
        return redirect()->route('parametros.edit');
    }

    public function create_director(Request $request){
        $request->validate([
            'nameDirector' => 'required'
        ]);

        $director = Director::create($request->all());

        $director->save();

    }
    public function update_director($id, Request $request){
        $director = Director::find($id);

        $director->delete();

        $director->nameDirector = $request->nameDirector;

        $director->save();
    }

    public function create_instituto(Request $request){
        $request->validate([
            'nameInstituto'
        ]);
        $instituto = NombreInstituto::create([
            'name' => 'nameInstituto'
        ]);

        $instituto->save();
    }
    public function update_instituto($id, Request $request){
        $instituto = NombreInstituto::find($id);

        $instituto->delete();

        $instituto->name = $request->nameInstituto;

        $instituto->save();
    }

    public function upLogo(Request $request){
        $request->file('file')->storeAs('/img/', 'logo.jpg', 'public');
    }
    public function upLogo_tecnm(Request $request){
        $request->file('file')->storeAs('/img/', 'logoTecnm.jpg', 'public');
    }
    public function upLogo_educacion(Request $request): void
    {
        $request->file('file')->storeAs('/img/', 'educacion.jpg', 'public');
    }
}
