<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PonenciaController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
});
Route::group(['middleware' => 'auth:sanctum'], function ($router) {
    
    // Catalogo de Usuarios
    Route::get('/usuarios', [UserController::class, 'getUsuarios']);
    Route::post('/usuarios/nuevo-usuario', [UserController::class, 'nuevoUsuario']);
    Route::post('/usuarios/actualizar-usuario', [UserController::class, 'actualizarUsuario']);
    Route::post('/usuarios/eliminar-usuario', [UserController::class, 'eliminarUsuario']);
    
    //TipoUsuarios
    Route::get('/tipoUsuarios', [TipoUsuarioController::class, 'getTipoUsuarios']);
    Route::post('/tipoUsuarios/nuevo-tipo-usuario', [TipoUsuarioController::class, 'nuevoTipoUsuario']);
    Route::post('/tipoUsuarios/actualizar-tipo-usuario', [TipoUsuarioController::class, 'actualizarTipoUsuario']);
    Route::post('/tipoUsuarios/eliminar-tipo-usuario', [TipoUsuarioController::class, 'eliminarTipoUsuario']);

    //Catalogo de Ponencias
    Route::get('/ponencias', [PonenciaController::class, 'getPonencias']);
    Route::post('/ponencias/nueva-ponencia', [PonenciaController::class, 'nuevaPonencia']);
    Route::post('/ponencias/actualizar-ponencia', [PonenciaController::class, 'actualizarPonencia']);
    Route::post('/ponencias/eliminar-ponencia', [PonenciaController::class, 'eliminarPonencia']);

});