<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            Log::warning('Intento de acceso no autorizado', [
                'ip' => $request->ip(),
                'ruta' => $request->path()
            ]);
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder a esta página.');
        }

        // Verificar si el usuario está activo
        if (!Auth::user()->estado) {
            Log::warning('Intento de acceso con cuenta inactiva', [
                'usuario_id' => Auth::id(),
                'ip' => $request->ip()
            ]);
            Auth::logout();
            return redirect()->route('login')->with('error', 'Su cuenta está desactivada.');
        }

        return $next($request);
    }
}
