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
      // Autenticar el usuario utilizando el modelo 'Usuario'
      $usuario = JWTAuth::parseToken()->authenticate();

      // Validar que el usuario existe y está activo
      if (!$usuario) {
        return response()->json([
          'message' => 'Usuario no encontrado. Por favor, inicie sesión nuevamente.'
        ], 401);
      }

      // Validar que la cuenta esté activa
      if (!$usuario->estado) {
        return response()->json([
          'message' => 'Su cuenta ha sido desactivada. Contacte al administrador.'
        ], 403);
      }

      // Añadir el usuario autenticado al request
      $request->merge(['usuarios' => $usuario]);

      // Establecer el usuario en el guard de autenticación para que esté disponible en auth()
      auth('api')->setUser($usuario);
    } catch (JWTException $e) {
      return response()->json([
        'message' => 'Token no válido o no proporcionado. Por favor, recargue la página.'
      ], 401);
    }

    return $next($request);
  }
}
