<?php

use App\Http\Controllers\CoordinacionController;
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


    Route::middleware('role:Coordinacion de FD y AP')->group(function (){
        Route::get('/coordinacion/detecciones', [CoordinacionController::class, 'index'])->name('index.detecciones');
        Route::get('/coordinacion/detecciones/deteccion/{id}', [CoordinacionController::class, 'show'])->name('show.Cdetecciones');
        Route::put('/coordinacion/detecciones/deteccion/observacion/{id}', [CoordinacionController::class, 'update'])->name('update.observaciones');
        Route::post('/coordinacion/detecciones/aceptado/{id}', [CoordinacionController::class, 'store'])->name('store.aceptado');
        Route::get('/coordinacion/registros', [CoordinacionController::class, 'index_registros'])->name('index.registros.c');
    });

    Route::get('/desarrollo/cursos', [CoursesController::class, 'desarrollo_cursos'])->name('index.desarrollo.cursos');
    Route::get('/desarrollo/curso/{id}', [CoursesController::class, 'index_curso_inscrito_desarrollo'])->name('index.desarrollo.inscritos');
});
