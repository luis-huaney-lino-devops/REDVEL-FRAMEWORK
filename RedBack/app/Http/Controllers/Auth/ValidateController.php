<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    private function generateJwtToken(Usuario $usuario): string
    {
        $tiempoMinutos = intval(env('TIEMPOSECION', 60));

        // Definir custom claims con toda la información del usuario
        $customClaims = [
            'id_user'           => $usuario->idusuarios,
            'nombre_de_usuario' => $usuario->nomusu,
            'foto_perfil'      => $usuario->persona->fotografia ?? null,
            // 'roles'            => $usuario->getRoleNames(),
            // 'permisos'         => $usuario->getAllPermissions()->pluck('name'),
            'codigo_usuario'   => $usuario->codigo_usuario,
            'exp' => now()->addMinutes($tiempoMinutos)->timestamp
            // Agregar información de la persona si está disponible
        ];

        // Crear el token con custom claims
        $token = JWTAuth::customClaims($customClaims)->fromUser($usuario);

        return $token;
    }
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
