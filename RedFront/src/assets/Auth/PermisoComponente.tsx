import React, { useMemo } from "react";
import { hasPermission } from "@/assets/Auth/authUtils";

interface PermisoComponenteProps {
  children: React.ReactNode;
  permisos: string | string[];
  fallback?: React.ReactNode;
}

export const PermisoComponente = React.memo(
  ({ children, permisos, fallback = null }: PermisoComponenteProps) => {
    const tienePermiso = useMemo(() => {
      if (Array.isArray(permisos)) {
        return permisos.some((permiso) => hasPermission(permiso));
      }
      return hasPermission(permisos);
    }, [permisos]);

    if (!tienePermiso) {
      return <>{fallback}</>;
    }

    return <>{children}</>;
  }
);

PermisoComponente.displayName = "PermisoComponente";
