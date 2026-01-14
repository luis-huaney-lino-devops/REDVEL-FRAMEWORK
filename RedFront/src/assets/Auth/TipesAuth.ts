export interface UserCredentials {
  nombre_usuario: string;
  password: string;
}

export interface RolePermission {
  rol: string;
  permisos: string[];
}

export interface User {
  id: number;
  nombre_de_usuario: string;
  email: string;
  roles_permisos: RolePermission[];
}

export interface LoginResponse {
  success: boolean;
  message: string;
  data: {
    token: string;
    message: string;
  };
}

export interface TokenVerificationResponse {
  valid: boolean;
  message: string;
}

export interface DecodedToken {
  iss: string;
  iat: number;
  exp: number;
  nbf: number;
  jti: string;
  sub: string;
  prv: string;
  id_user: number;
  nombre_de_usuario: string;
  foto_perfil: string | null;
  codigo_usuario: string;
}

export interface TokenInfo {
  isValid: boolean;
  isExpired: boolean;
  user?: {
    id: number;
    nombre_de_usuario: string;
    codigo_usuario: string;
    foto_perfil: string | null;
  };
  exp?: number;
  timeRemaining?: number;
}

export interface PermissionsResponse {
  success: boolean;
  message: string;
  data: {
    roles: string[];
    permissions: string[];
  };
}

export interface PermissionsCache {
  roles: string[];
  permissions: string[];
  expiresAt: number; // Timestamp en milisegundos
}
