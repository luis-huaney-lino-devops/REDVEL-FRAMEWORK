import { Button } from "@/components/ui/button";
import "./login.css";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";

import { Lock, Mail, Eye, EyeOff } from "lucide-react";
import toast, { Toaster } from "react-hot-toast";
import { jwtDecode } from "jwt-decode";
import Cookies from "js-cookie";
import { useNavigate, useSearchParams } from "react-router-dom";
import { useEffect, useState } from "react";
import type { FormEvent } from "react";
import axios, { AxiosError } from "axios";
import Constantes from "@/assets/constants/constantes";
import type {
  UserCredentials,
  LoginResponse,
  DecodedToken,
} from "@/assets/Auth/TipesAuth";
import { checkSession, decodeRedirectPath } from "@/assets/Auth/authUtils";

export function LoginPage() {
  const [credentials, setCredentials] = useState<UserCredentials>({
    nombre_usuario: "",
    password: "",
  });
  const [showPassword, setShowPassword] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();

  // Input validation function
  const validateInput = (input: string): boolean => {
    // Prevent XSS by sanitizing input
    const sanitizedInput = input.replace(/[<>'"]/g, "");
    return sanitizedInput.length > 0 && sanitizedInput.length <= 100;
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;

    // Add input validation
    if (validateInput(value)) {
      setCredentials((prev) => ({
        ...prev,
        [name]: value,
      }));
    }
  };

  useEffect(() => {
    document.title = "Inicio de Sesión - Redvel";
    return () => {
      document.title = "Redvel Framework";
    };
  }, []);

  // Verificar si ya está logueado y redirigir
  useEffect(() => {
    if (checkSession()) {
      // Obtener la ruta de redirección de forma segura
      const redirectParam = searchParams.get("redirect");
      const redirectPath = redirectParam
        ? decodeRedirectPath(redirectParam)
        : null;

      // Redirigir a la ruta indicada o a /inicio por defecto
      navigate(redirectPath || "/inicio", { replace: true });
    }
  }, [navigate, searchParams]);

  const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setIsLoading(true);

    const loadingToast = toast.loading("Iniciando sesión...", {
      style: {
        background: "#1F2937",
        color: "#fff",
        border: "1px solid #EF4444",
      },
    });

    try {
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

      const data = response.data.data;
      const success = response.data.success;
      const decodedToken = jwtDecode<DecodedToken>(data.token);
      if (!success) {
        console.error("❌ Login falló según el servidor:", data.message);
        throw new Error(data.message || "Login falló");
      }

      // Verificar que existe el token
      if (!data?.token) {
        console.error("❌ No se recibió token en la respuesta:", data);
        throw new Error("No se recibió token de autenticación");
      }
      // Configurar las cookies
      const cookieOptions = {
        expires: new Date((decodedToken.exp || 0) * 1000),
        secure: Constantes.ModeProduccion, // Cambiar a true en producción
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

      // Obtener permisos después del login
      try {
        const { getPermissions } = await import("@/assets/Auth/permissionsService");
        await getPermissions(true); // Force refresh después del login
      } catch (error) {
        console.warn("No se pudieron obtener permisos después del login:", error);
        // No fallar el login si no se pueden obtener permisos
      }

      toast.dismiss(loadingToast);
      toast.success(`¡Bienvenido, ${decodedToken.nombre_de_usuario}!`);

      // Deshabilitar el botón después del login exitoso
      setIsLoggedIn(true);

      // Obtener la ruta de redirección de forma segura
      const redirectParam = searchParams.get("redirect");
      const redirectPath = redirectParam
        ? decodeRedirectPath(redirectParam)
        : null;

      setTimeout(() => {
        // Redirigir a la ruta indicada o a /inicio por defecto
        navigate(redirectPath || "/inicio", { replace: true });
      }, 1000);
    } catch (err) {
      toast.dismiss(loadingToast);
      if (axios.isAxiosError(err)) {
        const axiosError = err as AxiosError<{ message: string }>;
        const errorMessage =
          axiosError.response?.data?.message ||
          "Error al iniciar sesión. Verifique sus credenciales.";
        toast.error(errorMessage, {
          style: {
            background: "#1F2937",
            color: "#fff",
            border: "1px solid #EF4444",
          },
          icon: "❌",
        });
      } else {
        toast.error("Ocurrió un error inesperado. Intente nuevamente.", {
          style: {
            background: "#1F2937",
            color: "#fff",
            border: "1px solid #EF4444",
          },
          icon: "❌",
        });
      }
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen relative overflow-hidden">
      <Toaster
        position="bottom-right"
        toastOptions={{
          duration: 3000,
          style: {
            background: "#1F2937",
            color: "#fff",
            border: "1px solid #EF4444",
          },
        }}
      />

      {/* Animated Background */}
      <div className="absolute inset-0 bg-gradient-to-br from-gray-900 via-red-900/20 to-gray-900">
        <div className="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(239,68,68,0.1),transparent_50%)]"></div>
        <div className="absolute top-0 left-0 w-full h-full">
          <div className="absolute top-1/4 left-1/4 w-64 h-64 bg-red-500/10 rounded-full blur-2xl animate-pulse"></div>
          <div className="absolute bottom-1/4 right-1/4 w-64 h-64 bg-red-600/10 rounded-full blur-2xl animate-pulse delay-1000"></div>
        </div>
      </div>

      {/* Floating particles */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none bg-black">
        <div className="absolute top-1/4 left-1/4 w-2 h-2 bg-red-500/30 rounded-full animate-float"></div>
        <div className="absolute top-3/4 left-3/4 w-1 h-1 bg-red-400/40 rounded-full animate-float-delayed"></div>
        <div className="absolute top-1/2 left-1/6 w-3 h-3 bg-red-600/20 rounded-full animate-float-slow"></div>
      </div>

      {/* Main Content */}
      <div className="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div className="w-full max-w-sm">
          {/* Logo Section */}

          {/* Login Card */}
          <Card className="w-full shadow-2xl border-0 p-0 bg-gray-800/95 backdrop-blur-xl border border-red-500/20 animate-slide-up">
            <CardHeader className="space-y-2 text-center bg-gradient-to-r from-gray-900/90 to-gray-800/90 text-white rounded-t-lg relative overflow-hidden p-4">
              {/* Animated header background */}
              <div className="absolute inset-0 bg-gradient-to-r from-red-500/10 via-transparent to-red-500/10 animate-shimmer"></div>

              <div className="relative z-10">
                <div className="text-center mb-2 animate-slide-down">
                  <div className="relative inline-block mb-2">
                    <div className="absolute inset-0 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl blur-xl opacity-30 animate-pulse"></div>
                    <div className="relative bg-gradient-to-br from-red-500 via-red-600 to-red-700 p-3 rounded-2xl shadow-xl">
                      <img
                        src={"/Redvel-white.svg"}
                        alt="Redvel"
                        className="h-8 w-8"
                      />
                    </div>
                  </div>
                  <h1 className="text-2xl font-bold bg-gradient-to-r from-red-400 via-red-500 to-red-600 bg-clip-text text-transparent animate-fade-in">
                    Redvel
                  </h1>
                </div>
              </div>
              {/* <CardDescription className="text-red-200/80">
                  Inicia sesión para continuar
                </CardDescription> */}
            </CardHeader>

            <form onSubmit={handleSubmit}>
              <CardContent className="space-y-4 p-6 bg-gray-800/95">
                <div className="space-y-4">
                  {/* Username Field */}
                  <div className="space-y-2 group">
                    <Label
                      htmlFor="nombre_usuario"
                      className="text-gray-300 font-medium text-sm group-focus-within:text-red-400 transition-colors duration-200"
                    >
                      Usuario
                    </Label>
                    <div className="relative">
                      <div className="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-500/5 to-red-500/0 rounded-lg opacity-0 group-focus-within:opacity-100 transition-opacity duration-300"></div>
                      <Mail className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-red-500 z-10" />
                      <Input
                        id="nombre_usuario"
                        name="nombre_usuario"
                        type="text"
                        placeholder="Ingresa tu usuario"
                        className="pl-10 h-10 border-gray-600 bg-gray-700/50 text-white placeholder:text-gray-400 focus:border-red-500 focus:ring-red-500/20 focus:bg-gray-700/70 rounded-lg transition-all duration-300 hover:bg-gray-700/60 relative z-10"
                        required
                        onChange={handleChange}
                      />
                    </div>
                  </div>

                  {/* Password Field */}
                  <div className="space-y-2 group">
                    <Label
                      htmlFor="password"
                      className="text-gray-300 font-medium text-sm group-focus-within:text-red-400 transition-colors duration-200"
                    >
                      Contraseña
                    </Label>
                    <div className="relative">
                      <div className="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-500/5 to-red-500/0 rounded-lg opacity-0 group-focus-within:opacity-100 transition-opacity duration-300"></div>
                      <Lock className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-red-500 z-10" />
                      <Input
                        id="password"
                        name="password"
                        type={showPassword ? "text" : "password"}
                        placeholder="Ingresa tu contraseña"
                        className="pl-10 pr-10 h-10 border-gray-600 bg-gray-700/50 text-white placeholder:text-gray-400 focus:border-red-500 focus:ring-red-500/20 focus:bg-gray-700/70 rounded-lg transition-all duration-300 hover:bg-gray-700/60 relative z-10"
                        required
                        onChange={handleChange}
                      />
                      <button
                        type="button"
                        onClick={() => setShowPassword(!showPassword)}
                        className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-400 focus:outline-none z-10 transition-colors duration-200"
                      >
                        {showPassword ? (
                          <EyeOff className="h-4 w-4" />
                        ) : (
                          <Eye className="h-4 w-4" />
                        )}
                      </button>
                    </div>
                  </div>

                  {/* Remember me and forgot password */}
                  {/* <div className="flex items-center justify-between pt-2">
                    <div className="flex items-center space-x-2">
                      <input
                        id="remember"
                        type="checkbox"
                        className="w-4 h-4 text-red-600 bg-gray-700 border-gray-600 rounded focus:ring-red-500 focus:ring-2"
                      />
                      <Label
                        htmlFor="remember"
                        className="text-sm text-gray-400 cursor-pointer hover:text-red-400 transition-colors"
                      >
                        Recordarme
                      </Label>
                    </div>
                    <a
                      href="#"
                      className="text-sm text-red-400 hover:text-red-300 hover:underline font-medium transition-colors duration-200"
                    >
                      ¿Olvidaste tu contraseña?
                    </a>
                  </div> */}
                </div>
              </CardContent>

              <CardFooter className="p-6 pt-0 bg-gray-800/95">
                <Button
                  type="submit"
                  disabled={isLoading || isLoggedIn}
                  className="w-full h-10 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-70 relative overflow-hidden"
                >
                  {isLoading ? (
                    <div className="flex items-center justify-center space-x-2">
                      <div className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                      <span>Entrando...</span>
                    </div>
                  ) : isLoggedIn ? (
                    <div className="flex items-center justify-center space-x-2">
                      <span>Redirigiendo...</span>
                    </div>
                  ) : (
                    "Iniciar Sesión"
                  )}
                </Button>
              </CardFooter>
            </form>

            <div className="bg-gray-900/90 px-4 py-3 rounded-b-lg border-t border-gray-700/50">
              <p className="text-xs text-gray-400 text-center">
                © 2024 Redvel Framework. Sistema seguro de desarrollo web.
              </p>
            </div>
          </Card>
        </div>
      </div>

      {/* Custom Styles */}
      <style>{`
        @keyframes shimmer {
          0% {
            transform: translateX(-100%);
          }
          100% {
            transform: translateX(100%);
          }
        }

        @keyframes slide-down {
          from {
            opacity: 0;
            transform: translateY(-20px);
          }
          to {
            opacity: 1;
            transform: translateY(0);
          }
        }

        @keyframes slide-up {
          from {
            opacity: 0;
            transform: translateY(20px);
          }
          to {
            opacity: 1;
            transform: translateY(0);
          }
        }

        @keyframes fade-in {
          from {
            opacity: 0;
          }
          to {
            opacity: 1;
          }
        }

        @keyframes float {
          0%,
          100% {
            transform: translateY(0px);
          }
          50% {
            transform: translateY(-20px);
          }
        }

        @keyframes spin-slow {
          from {
            transform: rotate(0deg);
          }
          to {
            transform: rotate(360deg);
          }
        }

        .animate-shimmer {
          animation: shimmer 3s infinite;
        }

        .animate-slide-down {
          animation: slide-down 0.6s ease-out;
        }

        .animate-slide-up {
          animation: slide-up 0.6s ease-out 0.2s both;
        }

        .animate-fade-in {
          animation: fade-in 0.8s ease-out 0.4s both;
        }

        .animate-float {
          animation: float 3s ease-in-out infinite;
        }

        .animate-float-delayed {
          animation: float 3s ease-in-out infinite 1s;
        }

        .animate-float-slow {
          animation: float 4s ease-in-out infinite 0.5s;
        }

        .animate-spin-slow {
          animation: spin-slow 20s linear infinite;
        }
      `}</style>
    </div>
  );
}
