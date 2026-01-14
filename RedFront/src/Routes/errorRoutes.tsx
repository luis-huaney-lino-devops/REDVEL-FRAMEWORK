/**
 * Rutas de error de la aplicación
 * Estas rutas NO se incluyen en el sitemap
 */

import { lazy } from "react";
import { Route } from "react-router-dom";

// Lazy imports
const Error404 = lazy(() => import("@/assets/Pages/Error/404"));
const Error403 = lazy(() => import("@/assets/Pages/Error/403"));

/**
 * Genera las rutas de error
 * Devuelve un array de componentes Route que se pueden usar directamente en Routes
 */
export function getErrorRoutes() {
  return [
    <Route key="/403" path="/403" element={<Error403 />} />,
    <Route key="*" path="*" element={<Error404 />} />,
  ];
}
