<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//http://localhost:8000/api/prueba
Route::get('prueba', function () {
    return \App\Models\Producto::all();
});

Route::post('login', [UserController::class, 'login'])->name('login');

/**
 * Proteccion de autenticacion
 * Investigar y leer mas de auth.api
 */
Route::group(['middleware' => 'auth:api'], function (){

    /********************************************************************** */
    /**********************CRUD DE TABLA PRODUCTOS************************* */
    /********************************************************************** */
    Route::apiResource('productos', ProductoController::class);
    /********************************************************************** */
    // Route::get('productos', [ProductoController::class, 'index']);
    // Route::get('productos/{id}', [ProductoController::class, 'show']);
    // Route::delete('productos/{id}', [ProductoController::class, 'destroy']);
    // Route::post('productos', [ProductoController::class, 'store']);
    // Route::put('productos/{id}', [ProductoController::class, 'update']);
    /*********************************************************************** */

    Route::put('set_like/{id}', [ProductoController::class, 'setLike'])->name('set_like');
    Route::put('set_dislike/{id}', [ProductoController::class, 'setDislike'])->name('set_dislike');
    Route::put('set_imagen/{id}', [ProductoController::class, 'setImagen'])->name('set_imagen');

    Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');
});
