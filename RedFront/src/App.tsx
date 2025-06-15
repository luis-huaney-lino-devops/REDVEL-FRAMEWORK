import { Route, BrowserRouter as Router, Routes } from "react-router-dom";
import { Suspense, lazy } from "react";
import ScrollToTop from "./components/ui/ScrollTop";
import Loader3 from "./assets/Components/Loaders/Loader3";
import { ProtectedRoute } from "./assets/Auth/ProtectedRoute";

// Lazy imports
const LoginPage = lazy(() =>
  import("./assets/Pages/Autentificacion/login").then((module) => ({
    default: module.LoginPage,
  }))
);
const Dashboar_Stats = lazy(() => import("./assets/Pages/Inicio/Inicio"));
const Error404 = lazy(() => import("./assets/Pages/Error/404"));
const Error403 = lazy(() => import("./assets/Pages/Error/403"));
const Page = lazy(() => import("./assets/Components/Prueba"));
const Redvel = lazy(() => import("./assets/Pages/Redvel/RedvelPage"));
const PageUsuarios = lazy(() => import("./assets/Pages/Users/PageUsuarios"));
const DashboardLayout = lazy(
  () => import("./assets/Components/Dashboard/DashboardLayout")
);
const EmployeeManagement = lazy(
  () => import("./assets/Pages/Empleados/PageEmpleados")
);

function App() {
  return (
    <Router>
      <ScrollToTop />
      <Suspense fallback={<Loader3 />}>
        <Routes>
          <Route path="/" element={<Redvel />} />
          <Route path="/login" element={<LoginPage />} />
          <Route path="*" element={<Error404 />} />
          <Route path="/403" element={<Error403 />} />

          {/* Rutas protegidas sin DashboardLayout persistente */}
          <Route
            path="/inicios"
            element={
              <ProtectedRoute>
                <Page />
              </ProtectedRoute>
            }
          />

          {/* Rutas protegidas con DashboardLayout persistente */}
          <Route
            element={
              <ProtectedRoute>
                <DashboardLayout />
              </ProtectedRoute>
            }
          >
            <Route path="/dashboard" element={<Loader3 />} />
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
          </Route>
        </Routes>
      </Suspense>
    </Router>
  );
}

export default App;
