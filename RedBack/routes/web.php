<?php

use App\Http\Controllers\InstallController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return view('Redvel');
});
Route::get('/500', function () {
    return view('errors.500');
});
if (!Schema::hasTable('instalacion') || !DB::table('instalacion')->where('estado_instalacion', true)->exists()) {
    Route::get('/install', [InstallController::class, 'index'])->name('install');
    Route::post('/install', [InstallController::class, 'install'])->name('install.run');
    Route::get('/install/status', [InstallController::class, 'checkStatus'])->name('install.status');
    Route::post('/install/rollback', [InstallController::class, 'rollback'])->name('install.rollback');
}
