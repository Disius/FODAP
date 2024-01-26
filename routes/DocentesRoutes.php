<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DocenteController;
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

Route::middleware(['auth', 'role:Docentes'])->group(function(){
    Route::get('/docentes/cursos', [DocenteController::class, 'index_cursos'])->name('index.cursos.docentes');
    Route::post('/docente/inscrito/{id}', [DocenteController::class, 'inscripcion_docente'])->name('inscripcion.docente');
    Route::post('/docente/desinscribirme/{docente}', [DocenteController::class, 'desinscribirme'])->name('mi.desinscrito');
    Route::get('/docente/mis-cursos', [DocenteController::class, 'misCursos'])->name('index.misCursos');
    Route::get('/docente/registros/cursos/finalizados', [DocenteController::class, 'index_registros_docente'])->name('d.c.r');
});
