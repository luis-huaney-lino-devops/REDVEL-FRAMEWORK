<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */    public function handle($request, Closure $next)
    {
        // Si la ruta es "/install", no aplicar la verificación para evitar bucles
        if ($request->is('install') || $request->is('install/*')) {
            return $next($request);
        }

        // Verificar si la tabla installation_status existe
        if (!Schema::hasTable('instalacion')) {
            return redirect('/install');
        }

        // Verificar si la aplicación ya está instalada
        $installed = DB::table('instalacion')->where('estado_instalacion', true)->exists();

        if (!$installed) {
            return redirect('/install');
        }

        return $next($request);
    }
}
