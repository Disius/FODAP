<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\GestionParametrosController;
use App\Http\Controllers\Installer;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AcademicosController;
use App\Models\User;

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




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('main');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'notifications' => auth()->user()->unreadNotifications,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'role:Super Admin'])->get('/instalar', [Installer::class, 'index'])->name('index.installer');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/docente', [ProfileController::class, 'DocenteProfileCreate'])->name('docente.create');
    Route::put('/profile/docente/actualizado/{id}', [ProfileController::class, 'update_docente'])->name('update.docente');

    Route::get('/notificaciones', [NotificationController::class, 'notifications'])->name('index.notifications');
    Route::post('/notificacion/leida', [NotificationController::class, 'markNotifications'])->name('markNotification');

    //    Facilitador routes
    Route::get('/docente/facilitador', [DocenteController::class, 'facilitadores'])->name('get.facilitador');
    Route::get('/facilitador/{id}', [DocenteController::class, 'show_facilitadores'])->name('show.facilitadores');
    Route::post('/upload/cvu', [DocenteController::class, 'upload_cvu'])->name('upload.cvu');
    Route::get('/crear/ficha/{facilitador}/curso/{id}', [DocenteController::class, 'crear_ficha_tecnica'])->name('crear.ficha');
    Route::post('/upload/ficha', [DocenteController::class, 'upload_ft'])->name('upload.ficha');

    //required data
    Route::get('/detecciones/data', [AcademicosController::class, 'detecciones_data'])->name('detecciones.data');

    //pdfs
    Route::prefix('pdf')->group(function () {
        //        Route::post('/datos/deteccion', [PDFController::class, 'requestPDFDeteccion'])->name('data.pdf.deteccion');
        Route::get('/deteccion', [PDFController::class, 'deteccion_pdf'])->name('pdf.deteccion');
        Route::get('/PIFDAP', [PDFController::class, 'PIFDAP_pdf'])->name('pdf.pifdap');
        Route::get('/cdi', [PDFController::class, 'cdi_pdf'])->name('cdi.pdf');
    });
});

require __DIR__ . '/auth.php';

require __DIR__ . '/AcademicsRoutes.php';

require __DIR__ . '/DesarrolloRoutes.php';

require __DIR__ . '/DocentesRoutes.php';
