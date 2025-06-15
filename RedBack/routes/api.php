<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

route::post('/login', [LoginController::class, 'login']);

Route::middleware(['check.jwt'])->group(function () {



    Route::post('/verificar-token', [ValidateController::class, 'verificarToken']);
    Route::post('/renovar-token', [ValidateController::class, 'renovarToken']);
    Route::post('/logout', [ValidateController::class, 'LogOut']);
    Route::get('/user', function () {
        return response()->json(['message' => 'Usuario listados correctamente.']);
    });

    Route::middleware(['check.permission:usuarios.view'])->group(function () {

        Route::get('/usuarios', function () {
            return response()->json(['message' => 'Usuarios listados correctamente.']);
        });
    });
});
