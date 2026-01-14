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

        // Especificar explícitamente el guard 'api' al verificar permisos
        // Esto asegura que Spatie busque permisos con guard_name = 'api'
        $guard = 'api';

        // Obtener todos los permisos del usuario una sola vez para mejor rendimiento
        $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();

        // Verificar cada permiso requerido
        foreach ($permissions as $permission) {
            // Primero intentar con hasPermissionTo() (método recomendado de Spatie)
            if ($user->hasPermissionTo($permission, $guard)) {
                return $next($request);
            }

            // Si hasPermissionTo() falla pero el permiso está en la lista, también permitir acceso
            // Esto es un fallback para casos donde hasPermissionTo() no funciona correctamente
            if (in_array($permission, $userPermissions)) {
                Log::info('Permiso verificado mediante lista directa (fallback)', [
                    'usuario_id' => $user->idusuarios,
                    'permiso' => $permission,
                    'hasPermissionTo_result' => false,
                    'en_lista' => true
                ]);
                return $next($request);
            }
        }

        // Logging detallado para debugging
        $userRoles = $user->getRoleNames()->toArray();

        // Verificar cada permiso individualmente para debugging
        $permisosVerificados = [];
        foreach ($permissions as $perm) {
            $permisosVerificados[$perm] = [
                'hasPermissionTo' => $user->hasPermissionTo($perm, $guard),
                'en_lista_directa' => in_array($perm, $userPermissions),
            ];
        }

        Log::warning('Acceso denegado por falta de permisos', [
            'usuario_id' => $user->idusuarios,
            'nombre_usuario' => $user->nomusu,
            'permisos_requeridos' => $permissions,
            'permisos_del_usuario' => $userPermissions,
            'roles_del_usuario' => $userRoles,
            'guard_usado' => $guard,
            'verificacion_detallada' => $permisosVerificados,
            'ip' => $request->ip(),
            'ruta' => $request->path()
        ]);

        return response()->json([
            'error' => 'No tienes permiso para acceder a esta página.',
            'debug' => [
                'permisos_requeridos' => $permissions,
                'permisos_del_usuario' => $userPermissions,
                'roles_del_usuario' => $userRoles,
            ]
        ], 403);
    }
}
