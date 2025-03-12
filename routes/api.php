<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// routes/api.php
use App\Http\Controllers\RubricaController;

Route::post('/evaluar-codigo', [RubricaController::class, 'evaluarCodigo']);


Route::post('/evaluar-codigo/{id}', [RubricaController::class, 'evaluarCodigo']);

use App\Http\Controllers\CorreccionController;

Route::get('/correcciones/alumno', [CorreccionController::class, 'obtenerCorreccionesAlumno']);

Route::get('/correcciones/alumno/{curso_id}', [CorreccionController::class, 'obtenerCorreccionesAlumno']);
