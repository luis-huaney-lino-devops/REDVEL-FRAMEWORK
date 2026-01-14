<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ValidateController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Traduccion\TraduccionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// Rutas públicas
Route::post('/login', [LoginController::class, 'login']);
Route::post('/traduccion', [TraduccionController::class, 'traducir']);

// Rutas protegidas con JWT
Route::middleware(['check.jwt'])->group(function () {
    Route::post('/perras', [UserController::class, 'perras']);
    // Autenticación
    Route::post('/verificar-token', [ValidateController::class, 'verificarToken']);
    Route::post('/renovar-token', [ValidateController::class, 'renovarToken']);
    Route::post('/logout', [ValidateController::class, 'LogOut']);

    // Información del usuario y permisos
    Route::get('/user/permissions', [UserController::class, 'getPermissions']);
    Route::get('/user/info', [UserController::class, 'getUserInfo']);

    // Ejemplo de ruta con verificación de permisos
    Route::middleware(['check.permission:usuarios.view'])->group(function () {
        Route::get('/usuarios', function () {
            return response()->json(['message' => 'Usuarios listados correctamente.']);
        });
    });
});
