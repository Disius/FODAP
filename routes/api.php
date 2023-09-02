<?php

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

//Route::middleware('auth:api')->prefix('pdf')->group(function () {
//    Route::get('/deteccion', [PDFController::class, 'deteccion_pdf'])->name('pdf.deteccion');
//});
Route::prefix('pdf')->group(function () {
    Route::get('/deteccion', [PDFController::class, 'deteccion_pdf'])->name('pdf.deteccion');
    Route::get('/PIFDAP', [PDFController::class, 'PIFDAP_pdf'])->name('pdf.pifdap');
});
