<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ValidateController extends Controller
{

  /**
   * @OA\Post(
   *     path="/verificar-token",
   *     tags={"Authentication"},
   *     summary="Verify JWT token",
   *     description="Validate if the provided JWT token is valid",
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *         response=200,
   *         description="Token is valid",
   *         @OA\JsonContent(
   *             @OA\Property(property="valid", type="boolean", example=true),
   *             @OA\Property(property="message", type="string", example="Token válido")
   *         )
   *     ),
   *     @OA\Response(
   *         response=401,
   *         description="Token is invalid or not provided",
   *         @OA\JsonContent(
   *             @OA\Property(property="valid", type="boolean", example=false),
   *             @OA\Property(property="message", type="string", example="Token inválido")
   *         )
   *     ),
   *     @OA\Response(
   *         response=429,
   *         description="Too many attempts",
   *         @OA\JsonContent(
   *             @OA\Property(property="valid", type="boolean", example=false),
   *             @OA\Property(property="message", type="string", example="Demasiados intentos. Por favor espere X segundos.")
   *         )
   *     )
   * )
   */
  public function verificarToken(Request $request)
  {
    // Obtener la IP del cliente
    $clientIp = $request->ip();

    // Verificar rate limit
    if (RateLimiter::tooManyAttempts('verify-token:' . $clientIp, $perMinute = 60)) {
      $seconds = RateLimiter::availableIn('verify-token:' . $clientIp);

      return response()->json([
        'valid' => false,
        'message' => "Demasiados intentos. Por favor espere {$seconds} segundos."
      ], 429);
    }

    // Incrementar el contador de intentos
    RateLimiter::hit('verify-token:' . $clientIp);

    // Intentar obtener respuesta cacheada
    $cacheKey = 'token_validation_' . md5($request->bearerToken());

    return Cache::remember($cacheKey, 300, function () {
      try {
        $token = JWTAuth::getToken();

        if (!$token) {
          return response()->json([
            'valid' => false,
            'message' => 'Token no proporcionado'
          ], 401);
        }

        // Intenta decodificar y validar el token
        $user = JWTAuth::parseToken()->authenticate();

        return response()->json([
          'valid' => true,
          'message' => 'Token válido',
          // 'user' => $user
        ], 200);
      } catch (TokenInvalidException $e) {
        return response()->json([
          'valid' => false,
          'message' => 'Token inválido'
        ], 401);
      } catch (JWTException $e) {
        return response()->json([
          'valid' => false,
          'message' => 'Error al validar token'
        ], 500);
      }
    });
  }
  /**
   * Generar token JWT con claims personalizados
   *
   * IMPORTANTE: No incluir permisos en el token JWT por seguridad y tamaño.
   */
  private function generateJwtToken(Usuario $usuario): string
  {
    // No establecer exp manualmente, JWT Auth lo maneja automáticamente
    $customClaims = [
      'id_user' => $usuario->idusuarios,
      'nombre_de_usuario' => $usuario->nomusu,
      'foto_perfil' => $usuario->persona->fotografia ?? null,
    ];

    // Crear el token con custom claims
    $token = JWTAuth::customClaims($customClaims)->fromUser($usuario);

    return $token;
  }
  /**
   * @OA\Post(
   *     path="/renovar-token",
   *     tags={"Authentication"},
   *     summary="Refresh JWT token",
   *     description="Generate a new JWT token using the current valid token",
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"codigoUsuario"},
   *             @OA\Property(property="codigoUsuario", type="string", example="abc123def456")
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Token refreshed successfully",
   *         @OA\JsonContent(
   *             @OA\Property(property="success", type="boolean", example=true),
   *             @OA\Property(property="message", type="string", example="Token renovado exitosamente"),
   *             @OA\Property(
   *                 property="data",
   *                 type="object",
   *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
   *             )
   *         )
   *     ),
   *     @OA\Response(
   *         response=401,
   *         description="Invalid token or user code",
   *         @OA\JsonContent(
   *             @OA\Property(property="success", type="boolean", example=false),
   *             @OA\Property(property="message", type="string", example="Token inválido o código de usuario incorrecto")
   *         )
   *     )
   * )
   */
  public function renovarToken(Request $request)
  {
    try {
      // 1. Validación de entrada
      $request->validate([
        'codigoUsuario' => 'required|string'
      ]);

      $usuario = Usuario::where('codigo_usuario', $request->codigoUsuario)->firstOrFail();

      $oldToken = JWTAuth::getToken();
      if (!$oldToken) {
        return response()->json([
          'success' => false,
          'message' => 'Token no proporcionado.'
        ], 401);
      }
      $newToken = $this->generateJwtToken($usuario);

      return response()->json([
        'success' => true,
        'message' => 'Token renovado correctamente.',
        'token'   => $newToken,
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'success' => false,
        'message' => 'Usuario no encontrado.'
      ], 404);
    } catch (JWTException $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error al procesar el token: ' . $e->getMessage()
      ], 500);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Ha ocurrido un error inesperado.',
        'error'   => $e->getMessage()
      ], 500);
    }
  }
  /**
   * @OA\Post(
   *     path="/logout",
   *     tags={"Authentication"},
   *     summary="Logout user",
   *     description="Invalidate current JWT token and rotate user code",
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"codigo_usuario"},
   *             @OA\Property(property="codigo_usuario", type="string", example="abc123def456")
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Logout successful",
   *         @OA\JsonContent(
   *             @OA\Property(property="message", type="string", example="Sesión cerrada correctamente."),
   *             @OA\Property(property="status", type="boolean", example=true)
   *         )
   *     ),
   *     @OA\Response(
   *         response=401,
   *         description="Invalid token or user code",
   *         @OA\JsonContent(
   *             @OA\Property(property="message", type="string", example="Código de usuario no coincide."),
   *             @OA\Property(property="status", type="boolean", example=false)
   *         )
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="User not found",
   *         @OA\JsonContent(
   *             @OA\Property(property="message", type="string", example="Usuario no encontrado."),
   *             @OA\Property(property="status", type="boolean", example=false)
   *         )
   *     )
   * )
   */
  public function LogOut(Request $request)
  {
    try {
      $request->validate([
        'codigo_usuario' => 'required|string',
      ]);
      $codigo_usuario = $request->codigo_usuario;
      $usuario = Usuario::where('codigo_usuario', $codigo_usuario)
        ->first();
      if (!$usuario) {
        return response()->json([
          'message' => 'Usuario no encontrado.',
          'status' => false
        ], 404);
      }
      if ($usuario->codigo_usuario !== $codigo_usuario) {
        return response()->json([
          'message' => 'Código de usuario no coincide.',
          'status' => false
        ], 401);
      }
      $codigoCatualizado = hash('sha256', $codigo_usuario . now()->timestamp);
      Usuario::where('idusuarios', $usuario->idusuarios)
        ->update([
          'codigo_usuario' => $codigoCatualizado,
        ]);


      $token = JWTAuth::getToken();

      if (!$token) {
        return response()->json([
          'error' => 'Token no proporcionado.'
        ], 401);
      }

      JWTAuth::invalidate($token);

      return response()->json([
        'message' => 'Sesión cerrada correctamente.',
        'status' => true
      ], 200);
    } catch (TokenInvalidException $e) {
      return response()->json([
        'error' => 'Token inválido.',
        'status' => false
      ], 401);
    } catch (JWTException $e) {
      return response()->json([
        'error' => 'No se pudo cerrar sesión.',
        'status' => false
      ], 500);
    }
  }
}
