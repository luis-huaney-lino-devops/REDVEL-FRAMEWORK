import React, { useMemo } from "react";
import { usePermissions } from "./usePermissions";

interface PermisoComponenteProps {
  children: React.ReactNode;
  permisos: string | string[];
  fallback?: React.ReactNode;
}

export const PermisoComponente = React.memo(
  ({ children, permisos, fallback = null }: PermisoComponenteProps) => {
    const { hasPermission, isLoading } = usePermissions();

    const tienePermiso = useMemo(() => {
      if (isLoading) {
        return false; // No mostrar contenido mientras se cargan permisos
      }
      if (Array.isArray(permisos)) {
        return permisos.some((permiso) => hasPermission(permiso));
      }
      return hasPermission(permisos);
    }, [permisos, hasPermission, isLoading]);

    if (isLoading) {
      return <>{fallback}</>; // Mostrar fallback mientras carga
    }

    if (!tienePermiso) {
      return <>{fallback}</>;
    }

    return <>{children}</>;
  }
);

PermisoComponente.displayName = "PermisoComponente";
