<?php

use App\Http\Controllers\API\v1\DataResponseController;
use App\Http\Controllers\DesarrolloController;
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

Route::middleware('auth')->prefix('v1')->group(function () {
    Route::get('/cursos', [DataResponseController::class, 'Cursos_Desarrollo'])->name('v1.cursos');
    Route::get('/detecciones', [DataResponseController::class, 'Deteccion_Desarrollo'])->name('v1.detecciones');
});


//Route::get('/deteccion', [DesarrolloController::class, 'index'])->name('index.C');
//Route::prefix('pdf')->group(function () {
//        Route::get('/deteccion', [PDFController::class, 'deteccion_pdf'])->name('pdf.deteccion');
//        Route::get('/PIFDAP', [PDFController::class, 'PIFDAP_pdf'])->name('pdf.pifdap');
//    });
