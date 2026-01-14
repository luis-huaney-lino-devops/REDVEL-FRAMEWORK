/**
 * Hook para gestionar permisos del usuario
 * Carga permisos del servidor si no están en caché
 */

import { useEffect, useState, useCallback } from "react";
import { getPermissions } from "./permissionsService";
import Cookies from "js-cookie";

interface UsePermissionsReturn {
  permissions: string[];
  roles: string[];
  isLoading: boolean;
  error: Error | null;
  refreshPermissions: () => Promise<void>;
  hasPermission: (permission: string) => boolean;
  hasRole: (role: string) => boolean;
}

/**
 * Hook para obtener y gestionar permisos del usuario
 * Carga permisos del servidor si no están en caché
 */
export const usePermissions = (): UsePermissionsReturn => {
  const [permissions, setPermissions] = useState<string[]>([]);
  const [roles, setRoles] = useState<string[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<Error | null>(null);

  const loadPermissions = useCallback(async () => {
    try {
      setIsLoading(true);
      setError(null);

      // Verificar si hay token
      const token = Cookies.get("token");
      if (!token) {
        setPermissions([]);
        setRoles([]);
        setIsLoading(false);
        return;
      }

      // Intentar obtener del caché primero usando getPermissions
      // getPermissions ya maneja la lógica de caché vs servidor
      const { permissions: perms, roles: userRoles } = await getPermissions(false);
      setPermissions(perms);
      setRoles(userRoles);
      setIsLoading(false);
    } catch (err) {
      console.error("Error al cargar permisos:", err);
      setError(err instanceof Error ? err : new Error("Error desconocido"));
      setPermissions([]);
      setRoles([]);
      setIsLoading(false);
    }
  }, []);

  useEffect(() => {
    loadPermissions();
  }, [loadPermissions]);

  const refreshPermissions = useCallback(async () => {
    try {
      setIsLoading(true);
      setError(null);
      const { permissions: perms, roles: userRoles } = await getPermissions(true);
      setPermissions(perms);
      setRoles(userRoles);
      setIsLoading(false);
    } catch (err) {
      console.error("Error al refrescar permisos:", err);
      setError(err instanceof Error ? err : new Error("Error desconocido"));
      setIsLoading(false);
    }
  }, []);

  const hasPermission = useCallback(
    (permission: string): boolean => {
      return permissions.includes(permission);
    },
    [permissions]
  );

  const hasRole = useCallback(
    (role: string): boolean => {
      return roles.includes(role);
    },
    [roles]
  );

  return {
    permissions,
    roles,
    isLoading,
    error,
    refreshPermissions,
    hasPermission,
    hasRole,
  };
};
