<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\recorridoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ProfesorController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

#Route::get('/recorrido/pruebascesar', [RecorridoController::class, 'index'])->name('ruta.controlador.a');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');

Route::get('/prefectura/edit', [App\Http\Controllers\prefectoController::class, 'crudPrefecto'])->name('crudPrefecto');

Route::get('/prefectura/asistencia', [App\Http\Controllers\prefectoController::class, 'asistenciaDocente'])->name('asistenciaDocente');

Route::get('/prefectura/reportes', [App\Http\Controllers\prefectoController::class, 'reportesDocente'])->name('reportesDocente');

Route::get('/recorrido/pruebascesar', [RecorridoController::class, 'index']);

Route::get('/recorrido/pruebasregis', [RegistroController::class, 'index']);


Route::post('/recorrido/pruebas', [RecorridoController::class, 'index'])->name('hora');


Route::post('/recorrido/pruebasces', [RecorridoController::class, 'obtenerProfes'])->name('ajax');

Route::post('/recorrido/pruebasregi', [RegistroController::class, 'obtenerRegis'])->name('ajaxre');


Route::post('/recorrido/pruebasce', [RecorridoController::class, 'nombrelet'])->name('ajax2');
Route::post('/recorrido/pruebasre', [RegistroController::class, 'nombrelet'])->name('ajax2r');


Route::post('/recorrido/pruebasc', [RecorridoController::class, 'registrarAsistencia'])->name('ajax3');

Route::post('/recorrido/pruebascesar', [RecorridoController::class, 'updateAsistencia']);


Route::get('/cargar-salones/{edificioId}', [SalonController::class, 'cargarSalones']);

Route::get('/cargar-profesor/{profesorId}', [ProfesorController::class, 'cargarProfes']);























