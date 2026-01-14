<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/permissions",
     *     tags={"Authentication"},
     *     summary="Get user permissions and roles",
     *     description="Returns the authenticated user's permissions and roles. Results are cached for performance.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Permisos obtenidos correctamente"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="roles", type="array", @OA\Items(type="string"), example={"admin", "editor"}),
     *                 @OA\Property(property="permissions", type="array", @OA\Items(type="string"), example={"usuarios.view", "usuarios.create"})
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No autorizado")
     *         )
     *     )
     * )
     */
    public function getPermissions(Request $request)
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->errorResponse('Usuario no autenticado', 401);
            }

            // Cachear permisos por 5 minutos para mejorar rendimiento
            $cacheKey = 'user_permissions_' . $user->idusuarios;

            $permissionsData = Cache::remember($cacheKey, 300, function () use ($user) {
                return [
                    'roles' => $user->getRoleNames()->toArray(),
                    'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
                ];
            });


            return $this->successResponse($permissionsData, 'Permisos obtenidos correctamente', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener permisos', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/user/info",
     *     tags={"Authentication"},
     *     summary="Get authenticated user info",
     *     description="Returns basic information about the authenticated user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre_usuario", type="string", example="admin"),
     *                 @OA\Property(property="foto_perfil", type="string", nullable=true, example="https://example.com/photo.jpg")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getUserInfo(Request $request)
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->errorResponse('Usuario no autenticado', 401);
            }

            $userData = [
                'id' => $user->idusuarios,
                'nombre_usuario' => $user->nomusu,
                'foto_perfil' => $user->persona->fotografia ?? null,
                'codigo_usuario' => $user->codigo_usuario,
            ];

            return $this->successResponse($userData, 'Información del usuario obtenida correctamente', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener información del usuario', 500);
        }
    }
    public function perras(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer|min:18',
        ]);
        $textop = "Hola " . $request->nombre . " tienes " . $request->edad . " años , le gusta mucho la picha";
        return $this->successResponse($textop, 'Perras obtenidas correctamente', 200);
    }
}
