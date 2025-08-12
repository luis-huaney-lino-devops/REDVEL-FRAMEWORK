// Helper de cache con TTL para localStorage
// getCache: obtiene el valor si no ha expirado
// setCache: guarda el valor con timestamp
// removeCache: elimina la clave

export function getCache(key: string, ttl: number): any | null {
  try {
    const raw = localStorage.getItem(key);
    if (!raw) return null;
    const { value, timestamp } = JSON.parse(raw);
    if (Date.now() - timestamp > ttl) {
      localStorage.removeItem(key);
      return null;
    }
    return value;
  } catch {
    return null;
  }
}

export function setCache(key: string, value: any): void {
  try {
    localStorage.setItem(key, JSON.stringify({ value, timestamp: Date.now() }));
  } catch {}
}

export function removeCache(key: string): void {
  try {
    localStorage.removeItem(key);
  } catch {}
}
