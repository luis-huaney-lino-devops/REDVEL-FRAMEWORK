<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstallController extends Controller
{
    public function index()
    {
        return view('install');
    }

    public function install()
    {
        $message = '';
        try {
            // Primero ejecutamos las migraciones
            // Artisan::call('migrate:fresh', ['--force' => true]);
            Artisan::call('migrate', ['--force' => true]);

            // Luego ejecutamos los seeders
            Artisan::call('db:seed', ['--force' => true]);

            // Después creamos el enlace simbólico de storage
            Artisan::call('storage:link');

            // Finalmente limpiamos el caché
            // Artisan::call('cache:clear');
            // Artisan::call('config:clear');
            // Artisan::call('view:clear');

            // Marcar la instalación como completada
            DB::table('instalacion')->insert([
                'estado_instalacion' => true,
            ]);

            $message = 'Instalación completada';
            return response()->json(['message' => $message], 200);
        } catch (\Throwable $th) {
            // Registrar el error completo en el log
            Log::error('Error en la instalación: ' . $th->getMessage());
            Log::error('Stack trace: ' . $th->getTraceAsString());

            // Devolver el error detallado
            return response()->json([
                'message' => 'Error en la instalación',
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString()
            ], 500);
        }
    }
}