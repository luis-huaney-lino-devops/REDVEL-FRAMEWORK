"use client";

import { useState, useEffect } from "react";
import { Button } from "@/components/ui/button";
import Cookies from "js-cookie";
import { jwtDecode } from "jwt-decode";
import { RefreshCw } from "lucide-react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import toast from "react-hot-toast";
import Constantes from "@/assets/constants/constantes";
import {
  getTokenInfo,
  clearSessionCookies,
  showSessionExpiredMessage,
} from "@/assets/Auth/authUtils";
import type { DecodedToken } from "@/assets/Auth/TipesAuth";

// Formatear segundos para mostrar siempre horas, minutos y segundos
const formatTime = (totalSeconds: number) => {
  const hours = Math.floor(totalSeconds / 3600);
  const minutes = Math.floor((totalSeconds % 3600) / 60);
  const seconds = totalSeconds % 60;

  return `${hours.toString().padStart(2, "0")}:${minutes
    .toString()
    .padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
};

// Obtener color basado en el porcentaje restante
const getColorForPercentage = (percentage: number): string => {
  const hue = Math.max(0, Math.min(120, percentage * 1.2));
  return `hsl(${hue}, 100%, 45%)`;
};

export default function HeaderTokenTimer() {
  const [remainingSeconds, setRemainingSeconds] = useState<number>(0);
  const [totalDuration, setTotalDuration] = useState<number>(0);
  const [isExpired, setIsExpired] = useState<boolean>(false);
  const [tokenExists, setTokenExists] = useState<boolean>(true);
  const [showRenewButton, setShowRenewButton] = useState<boolean>(false);
  const [isLoading, setIsLoading] = useState<boolean>(false);

  const navigate = useNavigate();

  // Función para obtener información del token usando authUtils
  const getTokenData = () => {
    const tokenInfo = getTokenInfo();

    if (!tokenInfo.isValid) {
      setTokenExists(false);
      return null;
    }

    if (tokenInfo.isExpired) {
      setTokenExists(false);
      return null;
    }

    return tokenInfo;
  };

  // Función para calcular el tiempo restante
  const calculateRemainingTime = () => {
    const tokenInfo = getTokenData();

    if (!tokenInfo || !tokenInfo.exp) {
      setTokenExists(false);
      return;
    }

    const timeRemaining = tokenInfo.timeRemaining || 0;

    // Si es la primera vez que calculamos, establecer la duración total
    if (totalDuration === 0 && tokenInfo.exp) {
      // Calcular duración total basada en exp - iat del token
      try {
        const token = Cookies.get("token");
        if (token) {
          const decodedToken = jwtDecode<DecodedToken>(token);
          const estimatedTotalDuration = decodedToken.exp - decodedToken.iat;
          setTotalDuration(estimatedTotalDuration);
        } else {
          setTotalDuration(3600); // 1 hora por defecto
        }
      } catch {
        setTotalDuration(3600); // 1 hora por defecto
      }
    }

    // Mostrar botón de renovar cuando queden menos de 30 minutos
    setShowRenewButton(timeRemaining <= 1800 && timeRemaining > 0);

    setRemainingSeconds(timeRemaining);
    setIsExpired(timeRemaining <= 0);

    // Si el token ha expirado, redirigir al login
    if (timeRemaining <= 0) {
      handleLogout();
    }
  };

  // Función para manejar el cierre de sesión
  const handleLogout = () => {
    setTokenExists(false);
    clearSessionCookies();
    showSessionExpiredMessage();
    navigate("/login");
  };

  // Efecto para actualizar el tiempo restante cada segundo
  useEffect(() => {
    calculateRemainingTime();

    const interval = setInterval(() => {
      calculateRemainingTime();
    }, 1000);

    return () => clearInterval(interval);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  const handleRenewSession = async () => {
    try {
      setIsLoading(true);
      const tokenInfo = getTokenData();

      if (!tokenInfo || !tokenInfo.user) {
        handleLogout();
        return;
      }

      const token = Cookies.get("token");
      const codigo_usuario = tokenInfo.user.codigo_usuario;

      if (!token || !codigo_usuario) {
        handleLogout();
        return;
      }

      const response = await axios.post(
        `${Constantes.baseUrlBackend}/api/renovar-token`,
        { codigoUsuario: codigo_usuario },
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        }
      );

      if (response.status === 200) {
        const newToken = response.data.token;
        const decodedToken = jwtDecode<DecodedToken>(newToken);
        const expirationDate = new Date(decodedToken.exp * 1000);

        // Configurar las cookies con las mismas opciones que en el login
        const cookieOptions = {
          expires: expirationDate,
          secure: Constantes.ModeProduccion,
          sameSite: "strict" as const,
          path: "/",
        };

        // Actualizar todas las cookies con la nueva información
        Cookies.set("token", newToken, cookieOptions);
        Cookies.set(
          "nombre_usuario",
          decodedToken.nombre_de_usuario,
          cookieOptions
        );
        Cookies.set(
          "foto_perfil",
          decodedToken.foto_perfil || "",
          cookieOptions
        );
        Cookies.set(
          "codigo_usuario",
          decodedToken.codigo_usuario,
          cookieOptions
        );

        // Recalcular el tiempo restante
        calculateRemainingTime();

        toast.success("Sesión renovada exitosamente", {
          position: "bottom-right",
          duration: 3000,
          icon: "👋",
        });
      }
    } catch (error) {
      console.error("Error al renovar la sesión:", error);
      toast.error("Error al renovar la sesión", {
        position: "bottom-right",
        duration: 3000,
        icon: "🚫",
      });
      handleLogout();
    } finally {
      setIsLoading(false);
    }
  };

  // Calcular porcentaje restante y color
  const percentRemaining = Math.min(
    100,
    (remainingSeconds / totalDuration) * 100
  );
  const timerColor = getColorForPercentage(percentRemaining);

  // Calcular el valor de strokeDashoffset para el círculo de progreso
  const circumference = 2 * Math.PI * 10;
  const strokeDashoffset =
    circumference - (circumference * percentRemaining) / 100;

  // Si no hay token, mostrar un mensaje compacto
  if (!tokenExists) {
    return (
      <div className="flex items-center text-sm text-gray-500">
        <span>Sin sesión</span>
      </div>
    );
  }

  return (
    <div className="flex items-center flex-col space-x-2">
      <div className="relative flex items-center">
        {/* Timer circle */}
        <div className="relative h-6 w-6">
          <svg className="w-full h-full" viewBox="0 0 24 24">
            {/* Background circle */}
            <circle
              cx="12"
              cy="12"
              r="10"
              fill="none"
              stroke="#e6e6e6"
              strokeWidth="2"
            />
            {/* Progress circle */}
            <circle
              cx="12"
              cy="12"
              r="10"
              fill="none"
              stroke={timerColor}
              strokeWidth="2"
              strokeDasharray={`${circumference}`}
              strokeDashoffset={strokeDashoffset}
              strokeLinecap="round"
              transform="rotate(-90 12 12)"
              style={{
                transition: "stroke-dashoffset 1s linear, stroke 1s linear",
              }}
            />
          </svg>
        </div>

        {/* Time display */}
        <div
          className="ml-2 text-sm font-mono tabular-nums"
          style={{ color: timerColor, transition: "color 1s linear" }}
        >
          {isExpired ? "Expirado" : formatTime(remainingSeconds)}
        </div>
      </div>

      {/* Botón de renovar sesión */}
      {showRenewButton && (
        <Button
          disabled={isLoading}
          onClick={handleRenewSession}
          variant="outline"
          size="sm"
          className="text-xs px-2 py-1 h-7"
        >
          <RefreshCw
            className={`h-3 w-3 mr-1 ${isLoading ? "animate-spin" : ""}`}
          />
          Renovar
        </Button>
      )}
    </div>
  );
}
