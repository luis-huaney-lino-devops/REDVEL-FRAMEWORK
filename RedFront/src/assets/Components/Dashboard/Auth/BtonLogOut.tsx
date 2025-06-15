import { DropdownMenuItem } from "@/components/ui/dropdown-menu";
import Cookies from "js-cookie";
import { LogOut } from "lucide-react";
import { useNavigate } from "react-router-dom";
import { useState } from "react";
import toast from "react-hot-toast";
import axios from "axios";
import Constantes from "@/assets/constants/constantes";
export default function BotonCerrarSesion() {
  const token = Cookies.get("token");
  const codigo_usuario = Cookies.get("codigo_usuario");
  const navigate = useNavigate();
  const [isLoading] = useState(false);
  const handleLogout = async () => {
    const response = await axios.post(
      `${Constantes.baseUrlBackend}/api/logout`,
      {
        codigo_usuario,
      },
      {
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
      }
    );
    if (response.status === 200) {
      const allCookies = Cookies.get();
      for (const cookieName in allCookies) {
        if (Object.prototype.hasOwnProperty.call(allCookies, cookieName)) {
          Cookies.remove(cookieName);
        }
      }

      toast.success("Sesión cerrada exitosamente", {
        position: "bottom-right",
        duration: 3000,
        icon: "👋",
      });
      navigate("/login");
    } else {
      toast.error("Error al cerrar sesión", {
        position: "bottom-right",
        duration: 3000,
        icon: "🚫",
      });
    }
  };

  return (
    <>
      <DropdownMenuItem
        onClick={handleLogout}
        disabled={isLoading}
        className="flex items-center gap-2 text-red-500 cursor-pointer"
      >
        <LogOut className="h-4 w-4" />
        <span>{isLoading ? "Cerrando sesión..." : "Cerrar Sesión"}</span>
      </DropdownMenuItem>
    </>
  );
}
