<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ValidateJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next)
    {
        try {
            // Aquí se autentica el usuario utilizando el modelo 'Usuario'
            $usuario = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token no válido o no proporcionado , recarge la pagina para ver si hay cambios'], 401);
        }
        // Añadir el usuario autenticado al request
        $request->merge(['usuarios' => $usuario]);

        return $next($request);
    }
}
