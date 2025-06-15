<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sessione;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class LoginController extends Controller
{
    /**
     * Procesar el login del usuario
     */
    public function login(Request $request)
    {
        try {
            // 1) Validar datos de entrada
            $request->validate([
                'nombre_usuario' => 'required|string|max:255',
                'password'       => 'required|string|min:6',
            ]);

            $nameUserOrEmail =  $request->nombre_usuario;
            $password =  $request->password;

            // 2) Buscar al usuario por nombre de usuario o email
            $usuario = Usuario::where('nomusu', $nameUserOrEmail)
                ->with('persona') // Cargar relación persona de una vez
                ->first();

            if (!$usuario) {
                return $this->errorResponse('Credenciales incorrectas.', 401);
            }

            // 3) Verificar que la cuenta esté activa
            if (!$usuario->estado) {
                return $this->errorResponse('Su cuenta ha sido desactivada. Contacte al administrador.', 403);
            }

            // 4) Verificar contraseña
            if (!Hash::check($password, $usuario->password)) {
                return $this->errorResponse('Credenciales incorrectas.', 401);
            }

            // 5) Actualizar código de sesión
            $codigoActualizado = $this->generateSessionCode($nameUserOrEmail);
            $usuario->update(['codigo_usuario' => $codigoActualizado]);

            // 6) Registrar sesión en BD
            $this->createSession($request, $usuario->idusuarios);

            // 7) Generar token JWT
            $token = $this->generateJwtToken($usuario);

            // 8) Log del login exitoso
            Log::info('Login exitoso', [
                'user_id' => $usuario->idusuarios,
                'username' => $usuario->nomusu,
                'ip' => $request->ip(),
            ]);

            // 9) Responder al cliente
            return $this->successResponse([
                'message' => 'Login exitoso.',
                'token'   => $token,
                // 'user'    => [
                //     'id'               => $usuario->idusuarios,
                //     'nombre_usuario'   => $usuario->nomusu,
                //     'foto_perfil'     => $usuario->persona->fotografia ?? null,
                //     'roles'           => $usuario->getRoleNames(),
                //     'permisos'        => $usuario->getAllPermissions()->pluck('name'),
                // ],
            ]);
        } catch (ValidationException $e) {
            return $this->errorResponse('Datos de entrada inválidos.', 422, $e->errors());
        } catch (Exception $e) {
            Log::error('Error en login', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->only(['nombre_usuario']),
            ]);

            return $this->errorResponse('Error interno del servidor. Intente nuevamente.', 500);
        }
    }

    /**
     * Generar código de sesión único
     */
    private function generateSessionCode(string $username): string
    {
        return hash('sha256', $username . now()->timestamp . uniqid());
    }

    /**
     * Crear registro de sesión
     */
    private function createSession(Request $request, int $userId): void
    {
        Sessione::create([
            'ip_address'        => $request->ip(),
            'fecha_hora_secion' => now(),
            'fk_idusuarios'    => $userId,
            'user_agent'       => $request->userAgent(), // Información adicional útil
        ]);
    }

    /**
     * Generar token JWT con claims personalizados
     */
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

    /**
     * Respuesta de éxito estandarizada
     */
    private function successResponse(array $data, int $statusCode = 200)
    {
        return response()->json($data, $statusCode);
    }

    /**
     * Respuesta de error estandarizada
     */
    private function errorResponse(string $message, int $statusCode = 400, array $errors = [])
    {
        $response = ['message' => $message];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
