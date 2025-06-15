"use client";
// import "./header.css";
// import { useState, useEffect } from "react";
import { SidebarTrigger } from "@/components/ui/sidebar";
// import "./Buscador/Comand.css";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
  DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbList,
} from "@/components/ui/breadcrumb";
import { Separator } from "@/components/ui/separator";
import { Button } from "@/components/ui/button";
import { Settings, UserCircle } from "lucide-react";
// import BotonCerrarSesion from "./OpcionesGeneral/BotonCerrarSesion";
// import Cookies from "js-cookie";
// import Notificaciones from "./Notificaciones";
import { Link } from "react-router-dom";
import { CommandMenu } from "../../Generalidades/Menu/MenuBuscador";
import { ThemeToggle } from "../../Generalidades/Theme-toogle";
import HeaderTokenTimer from "./SesionContador";
import { LazyLoadImage } from "react-lazy-load-image-component";
import BotonCerrarSesion from "../Auth/BtonLogOut";
// import { LazyLoadImage } from "react-lazy-load-image-component";
// import CountdownTimer from "./OpcionesGeneral/Contador";

export default function HeaderDashboard() {
  // const [userData, setUserData] = useState({
  //   fotoPerfil: "",
  //   nombreUsuario: "Usuario",
  // });

  // useEffect(() => {
  //   // Leer cookies de manera reactiva cuando se monta el componente
  //   const fotoPerfil = Cookies.get("img_use") || "";
  //   const nombreUsuario = Cookies.get("n_use") || "Usuario";

  //   setUserData({ fotoPerfil, nombreUsuario });
  // }, []);

  return (
    // <header className="flex h-16 shrink-0 items-center justify-between border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 px-4 transition-all ease-in-out duration-200">
    <header className="flex h-16 shrink-0 items-center  justify-between gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12">
      {/* Izquierda: Sidebar y Breadcrumb */}
      <div className="flex items-center gap-2 px-4">
        <SidebarTrigger className="-ml-1" />
        <Separator orientation="vertical" className="mr-2 h-4" />
        <Breadcrumb>
          <BreadcrumbList>
            <BreadcrumbItem className="hidden md:block">
              <CommandMenu />
            </BreadcrumbItem>
          </BreadcrumbList>
        </Breadcrumb>
      </div>

      {/* Derecha: Tema, Usuario y Opciones */}

      <div className="flex items-center gap-1">
        {/* Botón para cambiar tema */}
        {/* <Notificaciones /> */}
        <HeaderTokenTimer />
        <ThemeToggle />
        {/* <CountdownTimer /> */}
        {/* Menú desplegable del usuario */}
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <Button
              variant="ghost"
              className="relative foto_user flex items-center gap-2 px-4 py-2 hover:bg-accent rounded-lg transition-colors"
            >
              <div className=" h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center">
                <LazyLoadImage
                  className="rounded-full"
                  src={"https://placehold.co/500?text=Luis&font=roboto"}
                  // {/* {userData.nombreUsuario} */}
                  alt={"Usuario"}
                />
              </div>
              <span className="nombre_header font-medium">
                {/* {userData.nombreUsuario} */}
              </span>
            </Button>
          </DropdownMenuTrigger>

          <DropdownMenuContent align="end">
            {/* Perfil */}
            <Link to={`/configuracion/perfil`}>
              <DropdownMenuItem className="flex items-center gap-2 cursor-pointer">
                <UserCircle className="h-4 w-4" />
                <span>Perfil</span>
              </DropdownMenuItem>
            </Link>

            {/* Cuenta */}
            <Link to={`/configuracion/cuenta`}>
              <DropdownMenuItem className="flex items-center gap-2 cursor-pointer">
                <Settings className="h-4 w-4" />
                <span>Cuenta</span>
              </DropdownMenuItem>
            </Link>

            <DropdownMenuSeparator />
            {/* Cerrar sesión */}
            <BotonCerrarSesion />
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
    </header>
  );
}
