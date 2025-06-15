import React from "react";
import { Navigate, useLocation } from "react-router-dom";
import {
  checkSession,
  showInvalidSessionMessage,
  showAccessDeniedMessage,
  getPermissionsFromToken,
} from "./authUtils";

interface ProtectedRouteProps {
  children: React.ReactNode;
  requiredPermissions?: string[];
}

export const ProtectedRoute: React.FC<ProtectedRouteProps> = ({
  children,
  requiredPermissions = [],
}) => {
  const location = useLocation();

  // Verificar si la sesión es válida
  if (!checkSession()) {
    showInvalidSessionMessage();
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  // Verificar permisos y roles si se especifican
  if (requiredPermissions.length > 0) {
    const permissions = getPermissionsFromToken();

    const hasRequiredPermissions = requiredPermissions.every((permission) =>
      permissions.includes(permission)
    );
    if (!hasRequiredPermissions) {
      showAccessDeniedMessage();
      return <Navigate to="/403" state={{ from: location }} replace />;
    }
  }

  return <>{children}</>;
};
