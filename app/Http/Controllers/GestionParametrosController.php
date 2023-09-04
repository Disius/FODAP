<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class   GestionParametrosController extends Controller
{
    public function edit(Request $request){
        $departamento = Departamento::with('jefe_docente')->get();
        $carrera = Carrera::with('departamento')->get();
        $docente = Docente::all();
        return Inertia::render('Views/desarrollo/GestionEdit', [
            'docente' => $docente,
            'carrera_relacion' => $carrera->pluck('departamento'),
            'departamento' => $departamento,
            'carrera' => $carrera->except('11')
        ]);
    }

    public function create_carrera(Request $request){
        $departamento = Departamento::all();
        $carrera = Carrera::all()->except(['11']);
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
        $carrera = Carrera::all()->except(['11']);
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
}
