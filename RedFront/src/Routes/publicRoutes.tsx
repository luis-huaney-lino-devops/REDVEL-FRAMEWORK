/**
 * Rutas públicas de la aplicación
 * Estas rutas son accesibles sin autenticación y se incluyen en el sitemap
 */

import { lazy } from "react";
import { Route } from "react-router-dom";
import { SeoWrapper } from "@/assets/lib/SeoWrapper";

// Lazy imports
const Redvel = lazy(() => import("@/assets/Pages/Redvel/RedvelPage"));
const LoginPage = lazy(() =>
  import("@/assets/Pages/Autentificacion/login").then((module) => ({
    default: module.LoginPage,
  }))
);

export interface PublicRoute {
  path: string;
  element: React.LazyExoticComponent<React.ComponentType<unknown>>;
  importancia: number;
  title?: string;
  description?: string;
  keywords?: string[];
  changefreq?:
    | "always"
    | "hourly"
    | "daily"
    | "weekly"
    | "monthly"
    | "yearly"
    | "never";
}

/**
 * Configuración de rutas públicas para SEO
 */
export const publicRoutesConfig: PublicRoute[] = [
  {
    path: "/",
    element: Redvel,
    importancia: 1.0,
    title: "REDVEL Framework - Sistema de Gestión",
    description:
      "Framework robusto para desarrollo de aplicaciones web modernas",
    keywords: ["redvel", "framework", "sistema", "gestión", "aplicaciones web"],
    changefreq: "weekly",
  },
  {
    path: "/login",
    element: LoginPage,
    importancia: 0.5,
    title: "Iniciar Sesión - REDVEL",
    description: "Inicia sesión en tu cuenta de REDVEL",
    keywords: ["login", "iniciar sesión", "autenticación"],
    changefreq: "monthly",
  },
];

/**
 * Genera las rutas públicas con SEO
 * Devuelve un array de componentes Route que se pueden usar directamente en Routes
 */
export function getPublicRoutes() {
  return publicRoutesConfig.map((route) => {
    const Element = route.element;
    return (
      <Route
        key={route.path}
        path={route.path}
        element={
          <SeoWrapper
            title={route.title}
            description={route.description}
            keywords={route.keywords}
          >
            <Element />
          </SeoWrapper>
        }
      />
    );
  });
}
