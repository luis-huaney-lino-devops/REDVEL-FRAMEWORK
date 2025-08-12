<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;
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
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="User login",
     *     description="Authenticate user and return JWT token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre_usuario","password"},
     *             @OA\Property(property="nombre_usuario", type="string", example="admin"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login exitoso."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="message", type="string", example="Login exitoso."),
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Credenciales incorrectas."),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Account disabled",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Su cuenta ha sido desactivada. Contacte al administrador."),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Datos de entrada inválidos."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error interno del servidor. Intente nuevamente."),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        try {
            // 1) Validar datos de entrada
            $request->validate([
                'nombre_usuario' => 'required|string|max:255',
                'password'       => 'required|string|min:6',
            ]);

            $nameUserOrEmail = $request->nombre_usuario;
            $password = $request->password;

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

            // 9) Responder al cliente usando el método heredado
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
            ], 'Login exitoso.', 200);

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
}