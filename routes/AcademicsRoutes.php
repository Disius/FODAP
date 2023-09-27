<?php

use App\Http\Controllers\AcademicosController;
use App\Http\Controllers\CoursesController;
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

Route::middleware(['auth', 'role:Jefes Academicos'])->group(function(){
    Route::get('/detecciones', [AcademicosController::class, 'index'])->name('detecciones.index');
    Route::get('/detecciones/create', [AcademicosController::class, 'create'])->name('detecciones.create');
    Route::post('/deteccion/guardado', [CoursesController::class, 'store'])->name('store.detecciones');
    Route::get('/deteccion/{id}', [AcademicosController::class, 'show'])->name('show.detecciones');
    Route::get('/deteccion/editar/{id}', [AcademicosController::class, 'edit'])->name('edit.detecciones');
    Route::put('/deteccion/actualizado/{id}', [CoursesController::class, 'update'])->name('update.detecciones');
    Route::get('/registros', [AcademicosController::class, 'registros'])->name('index.registros');

    //inscripcion
    Route::post('/inscripcion/docente/{id}', [AcademicosController::class, 'inscripcion_academicos'])->name('inscripcion.academico');


    Route::get('/academicos/cursos', [AcademicosController::class, 'index_cursos_academico'])->name('index.cursos.academicos');
    Route::get('/academicos/curso/inscritos/{id}', [AcademicosController::class, 'index_cursos_inscritos'])->name('show.inscritos.academicos');
});
