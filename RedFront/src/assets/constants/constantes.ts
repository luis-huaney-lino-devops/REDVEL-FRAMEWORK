// const baseUrl: string = "http://localhost:3000";
// const baseUrlBackend: string = "http://localhost:8000";

const ModeProduccion: boolean = true;
const baseUrl: string = "http://168.231.90.23:9090";
const baseUrlBackend: string = "http://168.231.90.23:9091";
const TOKEN_CHECK_INTERVAL: number = 600000; // cada 10 minutos

const SESSION_EXPIRY_WARNING: number = 5 * 60;
const TOKEN_CACHE_KEY: string = "token_verification_cache";
const PERMISSIONS_CACHE_KEY: string = "user_permissions_cache";
// const ModeProduccion:boolean= false;

const Constantes = {
  baseUrl,
  baseUrlBackend,
  ModeProduccion,
  TOKEN_CHECK_INTERVAL,
  SESSION_EXPIRY_WARNING,
  TOKEN_CACHE_KEY,
  PERMISSIONS_CACHE_KEY,
};

export default Constantes;
