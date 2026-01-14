/**
 * Librería mejorada de caché para localStorage con TTL (Time To Live)
 * Incluye validación de tipos, manejo de errores mejorado y utilidades adicionales
 */

export interface CacheOptions {
  ttl?: number; // Tiempo de vida en milisegundos
  prefix?: string; // Prefijo para las claves
}

export interface CacheEntry<T> {
  value: T;
  timestamp: number;
  ttl?: number;
}

/**
 * Obtener valor del caché si no ha expirado
 * @param key Clave del caché
 * @param ttl Tiempo de vida en milisegundos (si no se proporciona, el valor se considera permanente hasta que se elimine)
 * @returns El valor almacenado o null si no existe o ha expirado
 */
export function getCache<T = any>(key: string, ttl?: number): T | null {
  try {
    const raw = localStorage.getItem(key);
    if (!raw) return null;

    const entry: CacheEntry<T> = JSON.parse(raw);
    const now = Date.now();
    const cacheAge = now - entry.timestamp;

    // Si se proporciona TTL, verificar expiración
    const effectiveTTL = ttl ?? entry.ttl;
    if (effectiveTTL && cacheAge > effectiveTTL) {
      localStorage.removeItem(key);
      return null;
    }

    return entry.value;
  } catch (error) {
    console.warn(`Error al obtener caché para clave "${key}":`, error);
    // Limpiar entrada corrupta
    try {
      localStorage.removeItem(key);
    } catch {
      // Ignorar error al limpiar
    }
    return null;
  }
}

/**
 * Guardar valor en el caché con timestamp
 * @param key Clave del caché
 * @param value Valor a almacenar
 * @param ttl Opcional: Tiempo de vida en milisegundos
 */
export function setCache<T = any>(key: string, value: T, ttl?: number): boolean {
  try {
    const entry: CacheEntry<T> = {
      value,
      timestamp: Date.now(),
      ttl,
    };
    localStorage.setItem(key, JSON.stringify(entry));
    return true;
  } catch (error) {
    // Puede fallar si el localStorage está lleno o está en modo privado
    if (error instanceof DOMException && error.name === "QuotaExceededError") {
      console.warn("El almacenamiento local está lleno. Limpiando caché antiguo...");
      clearExpiredCache();
      // Intentar de nuevo después de limpiar
      try {
        const entry: CacheEntry<T> = {
          value,
          timestamp: Date.now(),
          ttl,
        };
        localStorage.setItem(key, JSON.stringify(entry));
        return true;
      } catch {
        console.error("No se pudo guardar en caché incluso después de limpiar");
      }
    } else {
      console.warn(`Error al guardar en caché la clave "${key}":`, error);
    }
    return false;
  }
}

/**
 * Eliminar una clave específica del caché
 * @param key Clave a eliminar
 */
export function removeCache(key: string): boolean {
  try {
    localStorage.removeItem(key);
    return true;
  } catch (error) {
    console.warn(`Error al eliminar caché para clave "${key}":`, error);
    return false;
  }
}

/**
 * Verificar si una clave existe en el caché y no ha expirado
 * @param key Clave a verificar
 * @param ttl Tiempo de vida en milisegundos (opcional)
 */
export function hasCache(key: string, ttl?: number): boolean {
  return getCache(key, ttl) !== null;
}

/**
 * Limpiar todas las entradas del caché que hayan expirado
 * @returns Número de entradas eliminadas
 */
export function clearExpiredCache(): number {
  let cleared = 0;
  try {
    const keys = Object.keys(localStorage);
    const now = Date.now();

    for (const key of keys) {
      try {
        const raw = localStorage.getItem(key);
        if (!raw) continue;

        const entry: CacheEntry<any> = JSON.parse(raw);
        const cacheAge = now - entry.timestamp;
        const effectiveTTL = entry.ttl;

        if (effectiveTTL && cacheAge > effectiveTTL) {
          localStorage.removeItem(key);
          cleared++;
        }
      } catch {
        // Ignorar entradas que no son del formato de caché
        continue;
      }
    }
  } catch (error) {
    console.warn("Error al limpiar caché expirado:", error);
  }
  return cleared;
}

/**
 * Limpiar todas las entradas del caché (solo las que tienen formato de caché)
 * @param prefix Opcional: Prefijo para filtrar las claves
 */
export function clearAllCache(prefix?: string): number {
  let cleared = 0;
  try {
    const keys = Object.keys(localStorage);

    for (const key of keys) {
      if (prefix && !key.startsWith(prefix)) continue;

      try {
        const raw = localStorage.getItem(key);
        if (!raw) continue;

        // Verificar si tiene formato de caché
        const entry: CacheEntry<any> = JSON.parse(raw);
        if (entry && typeof entry === "object" && "value" in entry && "timestamp" in entry) {
          localStorage.removeItem(key);
          cleared++;
        }
      } catch {
        // No es una entrada de caché, continuar
        continue;
      }
    }
  } catch (error) {
    console.warn("Error al limpiar caché:", error);
  }
  return cleared;
}

/**
 * Obtener el tamaño aproximado del caché en bytes
 */
export function getCacheSize(): number {
  let size = 0;
  try {
    for (const key in localStorage) {
      if (localStorage.hasOwnProperty(key)) {
        size += localStorage[key].length + key.length;
      }
    }
  } catch (error) {
    console.warn("Error al calcular tamaño del caché:", error);
  }
  return size;
}
