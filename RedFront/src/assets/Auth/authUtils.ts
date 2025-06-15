import axios, { AxiosError } from "axios";
import { jwtDecode } from "jwt-decode";
import Cookies from "js-cookie";
import toast from "react-hot-toast";
import { useNavigate } from "react-router-dom";
import Constantes from "../constants/constantes";
import {
  type UserCredentials,
  type LoginResponse,
  type TokenVerificationResponse,
  type DecodedToken,
  type TokenInfo,
} from "./TipesAuth";
import React from "react";

// Constantes para la verificación del token
export const TOKEN_CHECK_INTERVAL = Constantes.TOKEN_CHECK_INTERVAL;
export const SESSION_EXPIRY_WARNING = Constantes.SESSION_EXPIRY_WARNING;
export const TOKEN_CACHE_KEY = Constantes.TOKEN_CACHE_KEY;

// Interfaz para la caché de verificación de token
interface TokenVerificationCache {
  isValid: boolean;
  timestamp: number;
}

/**
 * Función para obtener información del token
 */
export const getTokenInfo = (): TokenInfo => {
  try {
    const token = Cookies.get("token");
    if (!token) {
      return { isValid: false, isExpired: false, permissions: [], roles: [] };
    }

    // Decodificar el token
    const decodedToken = jwtDecode<DecodedToken>(token);

    // Verificar si el token ha expirado
    const currentTime = Date.now() / 1000;
    const isExpired = decodedToken.exp < currentTime;
    const timeRemaining = isExpired
      ? 0
      : Math.floor(decodedToken.exp - currentTime);

    return {
      isValid: true,
      isExpired,
      permissions: !isExpired ? decodedToken.permissions : [],
      roles: !isExpired ? decodedToken.roles : [],
      user: !isExpired
        ? {
            id: decodedToken.id_user,
            nombre_de_usuario: decodedToken.nombre_de_usuario,
            codigo_usuario: decodedToken.codigo_usuario,
            foto_perfil: decodedToken.foto_perfil,
          }
        : undefined,
      exp: decodedToken.exp,
      timeRemaining,
    };
  } catch (error) {
    console.error("Error al decodificar el token:", error);
    return { isValid: false, isExpired: false, permissions: [], roles: [] };
  }
};

/**
 * Función para obtener permisos del token
 */
export const getPermissionsFromToken = (): string[] => {
  const { permissions } = getTokenInfo();
  return permissions;
};

/**
 * Función para obtener roles del token
 */
export const getRolesFromToken = (): string[] => {
  const { roles } = getTokenInfo();
  return roles;
};

/**
 * Función para formatear el tiempo restante
 */
export const formatTimeRemaining = (seconds: number): string => {
  if (seconds <= 0) return "0 minutos";

  const hours = Math.floor(seconds / 3600);
  const minutes = Math.floor((seconds % 3600) / 60);

  if (hours > 0) {
    return `${hours} hora${hours !== 1 ? "s" : ""} y ${minutes} minuto${
      minutes !== 1 ? "s" : ""
    }`;
  }

  return `${minutes} minuto${minutes !== 1 ? "s" : ""}`;
};

/**
 * Función para limpiar todas las cookies de sesión
 */
export const clearSessionCookies = (): void => {
  const allCookies = Cookies.get();
  for (const cookieName in allCookies) {
    if (Object.prototype.hasOwnProperty.call(allCookies, cookieName)) {
      Cookies.remove(cookieName);
    }
  }
};

/**
 * Función para verificar si el usuario tiene un permiso específico
 */
export const hasPermission = (permission: string): boolean => {
  const { permissions } = getTokenInfo();
  return permissions.includes(permission);
};

/**
 * Función para verificar si el usuario tiene un rol específico
 */
export const hasRole = (role: string): boolean => {
  const { roles } = getTokenInfo();
  return roles.includes(role);
};

/**
 * Función para mostrar advertencia de expiración de sesión
 */
export const showSessionExpiryWarning = (): void => {
  const { timeRemaining } = getTokenInfo();

  if (
    timeRemaining &&
    timeRemaining > 0 &&
    timeRemaining <= SESSION_EXPIRY_WARNING
  ) {
    const formattedTime = formatTimeRemaining(timeRemaining);
    toast(
      `Tu sesión expirará en ${formattedTime}. Por favor, guarda tus cambios.`,
      {
        duration: 5000,
        icon: "⚠️",
      }
    );
  }
};

/**
 * Función para mostrar mensaje de sesión expirada
 */
export const showSessionExpiredMessage = (): void => {
  toast.error("Tu sesión ha expirado. Por favor, inicia sesión de nuevo.", {
    duration: 5000,
    icon: "🔒",
  });
};

/**
 * Función para mostrar mensaje de acceso denegado
 */
export const showAccessDeniedMessage = (): void => {
  toast.error("No tienes permisos para acceder a esta página.", {
    duration: 5000,
    icon: "🚫",
  });
};

/**
 * Función para mostrar mensaje de sesión inválida
 */
export const showInvalidSessionMessage = (): void => {
  toast.error("Tu sesión no es válida. Por favor, inicia sesión de nuevo.", {
    duration: 5000,
    icon: "🔒",
  });
};

/**
 * Función para validar entrada de usuario
 */
export const validateInput = (input: string): boolean => {
  const sanitizedInput = input.replace(/[<>'"]/g, "");
  return sanitizedInput.length > 0 && sanitizedInput.length <= 100;
};

/**
 * Función para iniciar sesión
 */
export const login = async (credentials: UserCredentials): Promise<boolean> => {
  try {
    if (
      !validateInput(credentials.nombre_usuario) ||
      !validateInput(credentials.password)
    ) {
      toast.error("Por favor, ingrese credenciales válidas");
      return false;
    }

    const response = await axios.post<LoginResponse>(
      `${Constantes.baseUrlBackend}/api/login`,
      credentials,
      {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        timeout: 10000,
      }
    );

    const data = response.data;
    const decodedToken = jwtDecode<DecodedToken>(data.token);

    const cookieOptions = {
      expires: new Date((decodedToken.exp || 0) * 1000),
      secure: Constantes.ModeProduccion,
      sameSite: "strict" as const,
      path: "/",
    };

    // Guardar información en cookies
    Cookies.set("token", data.token, cookieOptions);
    Cookies.set(
      "nombre_usuario",
      decodedToken.nombre_de_usuario,
      cookieOptions
    );
    Cookies.set("foto_perfil", decodedToken.foto_perfil || "", cookieOptions);
    Cookies.set("codigo_usuario", decodedToken.codigo_usuario, cookieOptions);
    Cookies.set("rol", JSON.stringify(decodedToken.roles), cookieOptions);

    toast.success(`¡Bienvenido, ${decodedToken.nombre_de_usuario}!`);
    return true;
  } catch (error) {
    if (axios.isAxiosError(error)) {
      const axiosError = error as AxiosError<{ message: string }>;
      const errorMessage =
        axiosError.response?.data?.message || "Error al iniciar sesión";
      toast.error(errorMessage);
    } else {
      toast.error("Error inesperado al iniciar sesión");
    }
    return false;
  }
};

/**
 * Función para cerrar sesión
 */
export const logout = (): void => {
  clearSessionCookies();
  toast.success("Sesión cerrada correctamente");
};

/**
 * Función para verificar la sesión
 */
export const checkSession = (): boolean => {
  const { isValid, isExpired } = getTokenInfo();
  return isValid && !isExpired;
};

/**
 * Función para obtener la caché de verificación de token
 */
const getTokenVerificationCache = (): TokenVerificationCache | null => {
  try {
    const cache = localStorage.getItem(TOKEN_CACHE_KEY);
    return cache ? JSON.parse(cache) : null;
  } catch (error) {
    console.error("Error al obtener la caché de verificación:", error);
    return null;
  }
};

/**
 * Función para guardar la caché de verificación de token
 */
const setTokenVerificationCache = (isValid: boolean): void => {
  try {
    const cache: TokenVerificationCache = {
      isValid,
      timestamp: Date.now(),
    };
    localStorage.setItem(TOKEN_CACHE_KEY, JSON.stringify(cache));
  } catch (error) {
    console.error("Error al guardar la caché de verificación:", error);
  }
};

/**
 * Función para verificar si la caché es válida
 */
const isCacheValid = (): boolean => {
  const cache = getTokenVerificationCache();
  if (!cache) return false;

  const now = Date.now();
  const cacheAge = now - cache.timestamp;
  return cacheAge < TOKEN_CHECK_INTERVAL;
};

/**
 * Función para verificar el token con el backend
 */
export const verifyTokenWithBackend = async (
  forceCheck = false
): Promise<boolean> => {
  try {
    const token = Cookies.get("token");
    if (!token) {
      return false;
    }

    // Verificar si podemos usar la caché
    if (!forceCheck && isCacheValid()) {
      const cache = getTokenVerificationCache();
      return cache?.isValid ?? false;
    }

    const response = await axios.post<TokenVerificationResponse>(
      `${Constantes.baseUrlBackend}/api/verificar-token`,
      null,
      {
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
        },
      }
    );

    if (response.data && typeof response.data.valid === "boolean") {
      // Guardar resultado en caché
      setTokenVerificationCache(response.data.valid);

      if (!response.data.valid) {
        console.warn("Token inválido:", response.data.message);
      }
      return response.data.valid;
    }
    return false;
  } catch (error) {
    console.error("Error al verificar el token:", error);
    return false;
  }
};

/**
 * Función para limpiar la caché de verificación
 */
export const clearTokenVerificationCache = (): void => {
  try {
    localStorage.removeItem(TOKEN_CACHE_KEY);
  } catch (error) {
    console.error("Error al limpiar la caché de verificación:", error);
  }
};

/**
 * Hook personalizado para verificar la sesión periódicamente
 */
export const useSessionCheck = (interval = TOKEN_CHECK_INTERVAL): void => {
  const navigate = useNavigate();

  React.useEffect(() => {
    // Verificar sesión inmediatamente
    const checkSession = async () => {
      try {
        const { isValid, isExpired } = getTokenInfo();
        const isTokenValid = await verifyTokenWithBackend();

        if (!isValid || isExpired || !isTokenValid) {
          clearSessionCookies();
          clearTokenVerificationCache();
          showInvalidSessionMessage();
          navigate("/login");
          return;
        }

        // Mostrar advertencia si la sesión está por expirar
        showSessionExpiryWarning();
      } catch (error) {
        console.error("Error en la verificación de sesión:", error);
        clearSessionCookies();
        clearTokenVerificationCache();
        navigate("/login");
      }
    };

    // Ejecutar la verificación inmediatamente
    checkSession();

    // Configurar intervalo para verificar la sesión periódicamente
    const sessionCheckInterval = setInterval(checkSession, interval);

    // Limpiar intervalo al desmontar el componente
    return () => clearInterval(sessionCheckInterval);
  }, [navigate, interval]);
};
