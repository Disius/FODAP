<?php

use App\Http\Controllers\DesarrolloController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\GestionParametrosController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'role:Jefe del Departamento de Desarrollo Academico|Coordinacion de FD y AP'])->group(function(){
    Route::get('/configuracion', [GestionParametrosController::class, 'edit'])->name('parametros.edit');
//    Rutas de carrera
    Route::get('/crear/carrera', [GestionParametrosController::class, 'create_carrera'])->name('create.carrera');
    Route::post('/guardar/carrera', [GestionParametrosController::class, 'store_carrera'])->name('store.carrera');
    Route::get('/editar/carrera/{id}', [GestionParametrosController::class, 'edit_carrera'])->name('edit.carrera');
    Route::put('/actualizar/carrera/{id}', [GestionParametrosController::class, 'update_carrera'])->name('update.carrera');
//    Rutas de departamento
    Route::get('/crear/departamento', [GestionParametrosController::class, 'create_departamento'])->name('create.departamento');
    Route::post('/departamento/creado', [GestionParametrosController::class, 'store_departamento'])->name('store.departamento');
    Route::get('/departamento/editar/{id}', [GestionParametrosController::class, 'edit_departamento'])->name('edit.departamento');
    Route::put('/departamento/actualizado/{id}', [GestionParametrosController::class, 'update_departamento'])->name('update.departamento');

//  Rutas para establecer fechas
    Route::post('/fechas', [GestionParametrosController::class, 'dates_detecciones'])->name('config.dates');

//rutas lugar

    Route::get('/desarrollo/create/lugar', [GestionParametrosController::class, 'create_lugar'])->name('create.lugar');
    Route::post('/desarrollo/store/lugar', [GestionParametrosController::class, 'store_lugar'])->name('store.lugar');
    Route::get('/desarrollo/edit/lugar/{id}', [GestionParametrosController::class, 'edit_lugar'])->name('edit.lugar');
    Route::put('/desarrollo/update/lugar/{id}', [GestionParametrosController::class, 'update_lugar'])->name('update.lugar');
    Route::delete('/desarrollo/delete/lugar/{id}', [GestionParametrosController::class, 'delete_lugar'])->name('delete.lugar');

//rutas para crear cursos
    Route::get('/desarrollo/agregar/curso', [DesarrolloController::class, 'create'])->name('create.curso');
    Route::post('/desarrollo/guardar/curso', [DesarrolloController::class, 'store_cursos'])->name('store.curso.add');
    Route::get('/desarrollo/editar/curso/{id}', [DesarrolloController::class, 'edit_curso'])->name('edit.curso');

//inscripciones
    Route::post('/docente/inscribir/{id}', [DesarrolloController::class, 'inscripcion_por_desarrollo'])->name('inscribir.docente');


//detecciones de necesidades
    Route::get('/desarrollo/detecciones', [DesarrolloController::class, 'index'])->name('index.detecciones');
    Route::get('/desarrollo/detecciones/deteccion/{id}', [DesarrolloController::class, 'show'])->name('show.Cdetecciones');
    Route::put('/desarrollo/detecciones/deteccion/observacion/{id}', [DesarrolloController::class, 'update'])->name('update.observaciones');
    Route::post('/desarrollo/detecciones/aceptado/{id}', [DesarrolloController::class, 'store'])->name('store.aceptado');
    Route::get('/desarrollo/registros', [DesarrolloController::class, 'index_registros'])->name('index.registros.c');

//desarrollo academico cursos
    Route::get('/desarrollo/cursos', [DesarrolloController::class, 'desarrollo_cursos'])->name('index.desarrollo.cursos');
    Route::get('/desarrollo/curso/{id}', [DesarrolloController::class, 'index_curso_inscrito_desarrollo'])->name('index.desarrollo.inscritos');
});
