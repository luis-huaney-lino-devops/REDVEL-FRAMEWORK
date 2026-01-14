/**
 * Rutas protegidas de la aplicación
 * Estas rutas requieren autenticación y NO se incluyen en el sitemap
 */

import { lazy } from "react";
import { Route } from "react-router-dom";
import { ProtectedRoute } from "@/assets/Auth/ProtectedRoute";

// Lazy imports
const Dashboar_Stats = lazy(() => import("@/assets/Pages/Inicio/Inicio"));
const Page = lazy(() => import("@/assets/Components/Prueba"));
const PageUsuarios = lazy(() => import("@/assets/Pages/Users/PageUsuarios"));
const DashboardLayout = lazy(
  () => import("@/assets/Components/Dashboard/DashboardLayout")
);
const EmployeeManagement = lazy(
  () => import("@/assets/Pages/Empleados/PageEmpleados")
);

/**
 * Genera las rutas protegidas
 * Devuelve un array de componentes Route que se pueden usar directamente en Routes
 */
export function getProtectedRoutes() {
  return [
    // Rutas protegidas sin DashboardLayout persistente
    <Route
      key="/inicios"
      path="/inicios"
      element={
        <ProtectedRoute>
          <Page />
        </ProtectedRoute>
      }
    />,

    // Rutas protegidas con DashboardLayout persistente
    <Route
      key="dashboard-layout"
      element={
        <ProtectedRoute>
          <DashboardLayout />
        </ProtectedRoute>
      }
    >
      <Route path="/dashboard" element={<div>Dashboard</div>} />
      <Route path="/inicio" element={<Dashboar_Stats />} />
      <Route path="/prueba" element={<Page />} />
      <Route
        path="/usuarios/lista"
        element={
          <ProtectedRoute requiredPermissions={["usuarios.view"]}>
            <PageUsuarios />
          </ProtectedRoute>
        }
      />
      <Route
        path="/empleados/lista"
        element={
          <ProtectedRoute requiredPermissions={["usuarios.view"]}>
            <EmployeeManagement />
          </ProtectedRoute>
        }
      />
    </Route>,
  ];
}
