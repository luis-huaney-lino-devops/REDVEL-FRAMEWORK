// const baseUrl: string = "https://unasam-certificados.tutec.pe";
// const baseUrlBackend: string = "https://unasam-certificados-backend.tutec.pe";

const ModeProduccion: boolean = true;
const baseUrl: string = "http://localhost:3000";
const baseUrlBackend: string = "http://localhost:8000";
const TOKEN_CHECK_INTERVAL: number = 600000; // cada 10 minutos

const SESSION_EXPIRY_WARNING: number = 5 * 60;
const TOKEN_CACHE_KEY: string = "token_verification_cache";
// const ModeProduccion:boolean= false;

const Constantes = {
  baseUrl,
  baseUrlBackend,
  ModeProduccion,
  TOKEN_CHECK_INTERVAL,
  SESSION_EXPIRY_WARNING,
  TOKEN_CACHE_KEY,
};

export default Constantes;
