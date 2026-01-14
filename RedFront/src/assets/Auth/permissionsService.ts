/**
 * Servicio para gestionar permisos y roles del usuario
 * Utiliza caché en localStorage para mejorar rendimiento
 * Los permisos se sincronizan con la expiración del token JWT
 */

import axios, { AxiosError } from "axios";
import Cookies from "js-cookie";
import { jwtDecode } from "jwt-decode";
import Constantes from "../constants/constantes";
import type {
  PermissionsResponse,
  PermissionsCache,
  DecodedToken,
} from "./TipesAuth";

const PERMISSIONS_CACHE_KEY = Constantes.PERMISSIONS_CACHE_KEY;

/**
 * Obtener la expiración del token JWT en milisegundos
 */
const getTokenExpiration = (): number | null => {
  try {
    const token = Cookies.get("token");
    if (!token) return null;

    const decodedToken = jwtDecode<DecodedToken>(token);
    return decodedToken.exp * 1000; // Convertir a milisegundos
  } catch (error) {
    console.error("Error al obtener expiración del token:", error);
    return null;
  }
};

/**
 * Obtener permisos desde el caché de localStorage
 */
const getCachedPermissions = (): PermissionsCache | null => {
  try {
    const cached = localStorage.getItem(PERMISSIONS_CACHE_KEY);
    if (!cached) return null;

    const cache: PermissionsCache = JSON.parse(cached);
    const now = Date.now();

    // Verificar si el caché ha expirado
    if (cache.expiresAt <= now) {
      localStorage.removeItem(PERMISSIONS_CACHE_KEY);
      return null;
    }

    return cache;
  } catch (error) {
    console.error("Error al leer caché de permisos:", error);
    localStorage.removeItem(PERMISSIONS_CACHE_KEY);
    return null;
  }
};

/**
 * Guardar permisos en caché de localStorage
 */
const setCachedPermissions = (
  roles: string[],
  permissions: string[]
): void => {
  try {
    const tokenExpiration = getTokenExpiration();
    
    // Si no hay token, no guardar en caché
    if (!tokenExpiration) {
      return;
    }

    // Usar la expiración del token JWT como expiración del caché de permisos
    const cache: PermissionsCache = {
      roles,
      permissions,
      expiresAt: tokenExpiration,
    };

    localStorage.setItem(PERMISSIONS_CACHE_KEY, JSON.stringify(cache));
  } catch (error) {
    console.error("Error al guardar caché de permisos:", error);
  }
};

/**
 * Obtener permisos desde el servidor
 */
const fetchPermissionsFromServer = async (): Promise<{
  roles: string[];
  permissions: string[];
}> => {
  try {
    const token = Cookies.get("token");
    if (!token) {
      throw new Error("No hay token de autenticación");
    }

    const response = await axios.get<PermissionsResponse>(
      `${Constantes.baseUrlBackend}/api/user/permissions`,
      {
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
        },
      }
    );

    if (response.data.success && response.data.data) {
      return {
        roles: response.data.data.roles || [],
        permissions: response.data.data.permissions || [],
      };
    }

    throw new Error("Respuesta inválida del servidor");
  } catch (error) {
    if (axios.isAxiosError(error)) {
      const axiosError = error as AxiosError<{ message: string }>;
      const errorMessage =
        axiosError.response?.data?.message ||
        "Error al obtener permisos del servidor";
      console.error("Error al obtener permisos:", errorMessage);
      throw new Error(errorMessage);
    }
    throw error;
  }
};

/**
 * Obtener permisos (desde caché o servidor)
 * @param forceRefresh Si es true, fuerza la actualización desde el servidor
 */
export const getPermissions = async (
  forceRefresh = false
): Promise<{ roles: string[]; permissions: string[] }> => {
  // Si no se fuerza actualización, intentar obtener del caché
  if (!forceRefresh) {
    const cached = getCachedPermissions();
    if (cached) {
      return {
        roles: cached.roles,
        permissions: cached.permissions,
      };
    }
  }

  // Obtener desde el servidor
  const { roles, permissions } = await fetchPermissionsFromServer();

  // Guardar en caché
  setCachedPermissions(roles, permissions);

  return { roles, permissions };
};

/**
 * Obtener permisos de forma síncrona desde el caché
 * Retorna array vacío si no hay caché válido
 */
export const getCachedPermissionsSync = (): {
  roles: string[];
  permissions: string[];
} => {
  const cached = getCachedPermissions();
  if (cached) {
    return {
      roles: cached.roles,
      permissions: cached.permissions,
    };
  }
  return { roles: [], permissions: [] };
};

/**
 * Limpiar caché de permisos
 */
export const clearPermissionsCache = (): void => {
  try {
    localStorage.removeItem(PERMISSIONS_CACHE_KEY);
  } catch (error) {
    console.error("Error al limpiar caché de permisos:", error);
  }
};

/**
 * Verificar si el usuario tiene un permiso específico (desde caché)
 */
export const hasPermission = (permission: string): boolean => {
  const { permissions } = getCachedPermissionsSync();
  return permissions.includes(permission);
};

/**
 * Verificar si el usuario tiene un rol específico (desde caché)
 */
export const hasRole = (role: string): boolean => {
  const { roles } = getCachedPermissionsSync();
  return roles.includes(role);
};

/**
 * Obtener todos los permisos (desde caché)
 */
export const getAllPermissions = (): string[] => {
  const { permissions } = getCachedPermissionsSync();
  return permissions;
};

/**
 * Obtener todos los roles (desde caché)
 */
export const getAllRoles = (): string[] => {
  const { roles } = getCachedPermissionsSync();
  return roles;
};
