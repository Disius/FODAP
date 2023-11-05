<?php

use App\Http\Controllers\API\v1\DataResponseController;
use App\Http\Controllers\DesarrolloController;
use App\Http\Controllers\Installer;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/admin', [Installer::class, 'can_install']);


Route::middleware('auth')->prefix('v1')->group(function () {
    Route::get('/cursos', [DataResponseController::class, 'Cursos_Desarrollo'])->name('v1.cursos');
    Route::get('/detecciones', [DataResponseController::class, 'Deteccion_Desarrollo'])->name('v1.detecciones');
    Route::get('/cursos-docentes', [DataResponseController::class, 'Curso_docente'])->name('v1.curso.docente');
    Route::get('/facilitadores-check', [DataResponseController::class, 'facilitador_check'])->name('v1.facilitadores');
    Route::get('/calificaciones', [DataResponseController::class, 'califications'])->name('v1.calificaciones');
    Route::get('/inscritos', [DataResponseController::class, 'inscritos_show'])->name('v1.inscritos');

});

