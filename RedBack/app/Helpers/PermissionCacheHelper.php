<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

/**
 * Helper para gestionar el caché de permisos de usuario
 */
class PermissionCacheHelper
{
    /**
     * Limpiar el caché de permisos de un usuario específico
     *
     * @param int $userId ID del usuario
     * @return void
     */
    public static function clearUserPermissionsCache(int $userId): void
    {
        $cacheKey = 'user_permissions_' . $userId;
        Cache::forget($cacheKey);
    }

    /**
     * Limpiar el caché de permisos de múltiples usuarios
     *
     * @param array $userIds Array de IDs de usuarios
     * @return void
     */
    public static function clearMultipleUsersPermissionsCache(array $userIds): void
    {
        foreach ($userIds as $userId) {
            self::clearUserPermissionsCache($userId);
        }
    }
}
