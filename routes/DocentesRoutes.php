<?php

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

Route::middleware(['auth', 'role:Docentes'])->group(function(){
    Route::get('/docentes/cursos', [CoursesController::class, 'index_cursos'])->name('index.cursos.docentes');
    Route::post('/docente/inscrito/{id}', [CoursesController::class, 'inscripcion_docente'])->name('inscripcion.docente');
    Route::get('/docente/miscursos', [CoursesController::class, 'misCursos'])->name('index.misCursos');
});
