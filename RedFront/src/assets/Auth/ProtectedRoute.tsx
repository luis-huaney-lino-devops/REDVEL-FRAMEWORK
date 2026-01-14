import React, { useEffect, useMemo } from "react";
import { Navigate, useLocation } from "react-router-dom";
import {
  checkSession,
  showInvalidSessionMessage,
  showAccessDeniedMessage,
  encodeRedirectPath,
} from "./authUtils";
import { usePermissions } from "./usePermissions";

interface ProtectedRouteProps {
  children: React.ReactNode;
  requiredPermissions?: string[];
}

// Variable de módulo para controlar si ya se mostró el mensaje en esta navegación
// Se resetea cuando cambia la ruta
let lastPathname = "";
let hasShownInvalidSessionMessage = false;

// Variable de módulo para controlar mensajes de acceso denegado
let hasShownAccessDeniedMessage = false;

export const ProtectedRoute: React.FC<ProtectedRouteProps> = ({
  children,
  requiredPermissions = [],
}) => {
  const location = useLocation();
  const { isLoading, hasPermission } = usePermissions();

  // Verificar si la sesión es válida
  const isAuthenticated = checkSession();

  // Resetear el flag cuando cambia la ruta
  useEffect(() => {
    if (location.pathname !== lastPathname) {
      lastPathname = location.pathname;
      hasShownInvalidSessionMessage = false;
      hasShownAccessDeniedMessage = false;
    }
  }, [location.pathname]);

  // Mostrar mensaje de sesión inválida solo una vez por navegación
  useEffect(() => {
    if (!isAuthenticated && !hasShownInvalidSessionMessage) {
      hasShownInvalidSessionMessage = true;
      showInvalidSessionMessage();
    }
  }, [isAuthenticated]);

  // Verificar permisos y roles si se especifican (debe estar antes de cualquier return)
  const hasRequiredPermissions = useMemo(() => {
    if (requiredPermissions.length === 0) {
      return true;
    }
    return requiredPermissions.every((permission) => hasPermission(permission));
  }, [requiredPermissions, hasPermission]);

  // Mostrar mensaje de acceso denegado solo una vez por navegación
  useEffect(() => {
    if (
      !isLoading &&
      requiredPermissions.length > 0 &&
      !hasRequiredPermissions &&
      !hasShownAccessDeniedMessage
    ) {
      hasShownAccessDeniedMessage = true;
      showAccessDeniedMessage();
    }
  }, [isLoading, requiredPermissions.length, hasRequiredPermissions]);

  if (!isAuthenticated) {
    // Codificar solo el pathname de forma segura (sin query params para mayor seguridad)
    const redirectPath = encodeRedirectPath(location.pathname);
    const loginUrl = redirectPath
      ? `/login?redirect=${redirectPath}`
      : "/login";
    return <Navigate to={loginUrl} replace />;
  }

  // Mostrar loading mientras se cargan los permisos
  if (isLoading && requiredPermissions.length > 0) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-center">
          <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900 mx-auto"></div>
          <p className="mt-2 text-gray-600">Cargando permisos...</p>
        </div>
      </div>
    );
  }

  if (!hasRequiredPermissions) {
    return <Navigate to="/403" state={{ from: location }} replace />;
  }

  return <>{children}</>;
};
