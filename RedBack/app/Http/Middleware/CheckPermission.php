<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = auth('api')->user();

        if (!$user) {
            Log::warning('Intento de verificación de permisos sin usuario autenticado', [
                'ip' => $request->ip(),
                'ruta' => $request->path()
            ]);
            return response()->json(['message' => 'No esta logeado'], 403);
        }

        foreach ($permissions as $permission) {
            if ($request->user()->hasPermissionTo($permission)) {
                return $next($request);
            }
        }

        Log::warning('Acceso denegado por falta de permisos', [
            'usuario_id' => $user->id,
            'permisos_requeridos' => $permissions,
            'ip' => $request->ip(),
            'ruta' => $request->path()
        ]);
        return response()->json([
            'error' => 'No tienes permiso para acceder a esta página.'
        ], 403);
        // abort(403, 'No tienes permiso para acceder a esta página.');
    }
}
