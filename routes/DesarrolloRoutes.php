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
    Route::get('/fechas/isActive', [GestionParametrosController::class, 'if_enable_detecciones'])->name('dates.get');
    Route::post('/name-instituto', [GestionParametrosController::class, 'create_instituto'])->name('create.instituto');
    Route::put('/name-instituto-update/{id}', [GestionParametrosController::class, 'update_instituto'])->name('update.instituto');
//rutas lugar

    Route::get('/desarrollo/create/lugar', [GestionParametrosController::class, 'create_lugar'])->name('create.lugar');
    Route::post('/desarrollo/store/lugar', [GestionParametrosController::class, 'store_lugar'])->name('store.lugar');
    Route::get('/desarrollo/edit/lugar/{id}', [GestionParametrosController::class, 'edit_lugar'])->name('edit.lugar');
    Route::put('/desarrollo/update/lugar/{id}', [GestionParametrosController::class, 'update_lugar'])->name('update.lugar');
    Route::delete('/desarrollo/delete/lugar/{id}', [GestionParametrosController::class, 'delete_lugar'])->name('delete.lugar');

//rutas para crear cursos
    Route::get('/desarrollo/agregar/curso', [DesarrolloController::class, 'create'])->name('create.curso');
    Route::post('/desarrollo/guardar/curso', [DesarrolloController::class, 'store_cursos'])->name('store.curso.add');
    Route::get('/desarrollo/editar/curso/{id}', [DesarrolloController::class, 'edit_curso'])->name('curso.editar');
    Route::put('/desarrollo/actualizado/curso/{id}', [DesarrolloController::class, 'update_curso'])->name('update.curso');
//inscripciones
    Route::post('/docente/inscribir/{id}', [DesarrolloController::class, 'inscripcion_por_desarrollo'])->name('inscribir.docente');


//detecciones de necesidades
    Route::get('/desarrollo/detecciones', [DesarrolloController::class, 'index'])->name('index.detecciones');
    Route::get('/desarrollo/detecciones/deteccion/{id}', [DesarrolloController::class, 'show'])->name('show.Cdetecciones');
    Route::put('/desarrollo/detecciones/deteccion/observacion/{id}', [DesarrolloController::class, 'update'])->name('update.observaciones');
    Route::delete('/desarrollo/deteccion/eliminar/{id}', [DesarrolloController::class, 'delete'])->name('delete.deteccion.desarrollo');
    Route::post('/desarrollo/detecciones/aceptado/{id}', [DesarrolloController::class, 'store'])->name('store.aceptado');
    Route::get('/desarrollo/registros', [DesarrolloController::class, 'index_registros'])->name('index.registros.c');

//desarrollo academico cursos
    Route::get('/desarrollo/cursos', [DesarrolloController::class, 'desarrollo_cursos'])->name('index.desarrollo.cursos');
    Route::get('/desarrollo/curso/{id}', [DesarrolloController::class, 'index_curso_inscrito_desarrollo'])->name('index.desarrollo.inscritos');
    Route::post('/desarrollo/calificaciones', [DesarrolloController::class, 'calificaciones_desarrollo'])->name('add.calificacion.desarrollo');
    Route::post('/desarrollo/calificaciones/update', [DesarrolloController::class, 'update_calificaciones_desarrollo'])->name('update.calificacion.desarrollo');

    //gestión usuarios
    Route::get('/editar/user/{id}', [GestionParametrosController::class, 'edit_users'])->name('edit.user');
    Route::put('/password/update/{id}', [GestionParametrosController::class, 'update_password'])->name('update.password');
    Route::patch('/user/editado/{id}', [GestionParametrosController::class, 'update_user'])->name('update.user');
    Route::delete('/eliminar/usuario', [GestionParametrosController::class, 'destoy_users'])->name('destroy.users');
    Route::post('/permiso/{id}', [GestionParametrosController::class, 'set_permission'])->name('permiso.edit');
    Route::post('/revocar/permiso/{id}', [GestionParametrosController::class, 'revoke_permissions'])->name('permiso.revoke');


//    crear o actualizar subdireccion
    Route::post('/crear/subdireccion', [GestionParametrosController::class, 'create_subdireccion'])->name('create.sub');
    Route::put('/actualizar/subdireccion/{id}', [GestionParametrosController::class, 'update_subdireccion'])->name('update.sub');
    Route::post('/crear/director', [GestionParametrosController::class, 'create_director'])->name('create.director');
    Route::put('/actualizar/director/{id}', [GestionParametrosController::class, 'update_director'])->name('update.director');


    //Docentes
    Route::get('/desarrollo/docentes', [DesarrolloController::class, 'docentes'])->name('index.docentes');
    Route::get('/desarrollo/docentes/create', [DesarrolloController::class, 'create_docentes'])->name('create.docentes');
    Route::post('/desarrollo/docentes/store', [DesarrolloController::class, 'store_docentes'])->name('store.docentes');
    Route::get('/desarrollo/docentes/edit/{id}', [DesarrolloController::class, 'edit_docente'])->name('edit.docentes');
    Route::put('/desarrollo/docentes/update/{id}', [DesarrolloController::class, 'update_docente'])->name('update.docentes');
    Route::delete('/desarrollo/docentes/delete/{id}', [DesarrolloController::class, 'delete_docente_desarrollo'])->name('delete.docentesDa');


    //subir cvu
    Route::post('/subir/cvu', [GestionParametrosController::class, 'subir_cvu'])->name('subir.cvu');
    Route::post('/subir/acta-calificaciones', [GestionParametrosController::class, 'subir_img_acta'])->name('subir.actacalificaciones');
    Route::post('/subir/constancia', [GestionParametrosController::class, 'subir_img_constancia'])->name('subir.constancia');
    Route::post('/subir/constancia-img-2', [GestionParametrosController::class, 'subir_img_constancia_2'])->name('subir.constancia.2');
    Route::post('/subir/logotec', [GestionParametrosController::class, 'upLogo'])->name('subir.logoTec');
    Route::post('/subir/logotecnm', [GestionParametrosController::class, 'upLogo_tecnm'])->name('subir.logoTecnm');
    Route::post('/subir/logoeducacion', [GestionParametrosController::class, 'upLogo_educacion'])->name('subir.logoEducacion');

});
