import { BrowserRouter as Router, Routes } from "react-router-dom";
import { Suspense } from "react";
import ScrollToTop from "./components/ui/ScrollTop";
import Loader3 from "./assets/Components/Loaders/Loader3";
import { getPublicRoutes } from "./Routes/publicRoutes";
import { getProtectedRoutes } from "./Routes/protectedRoutes";
import { getErrorRoutes } from "./Routes/errorRoutes";

function App() {
  return (
    <Router>
      <ScrollToTop />
      <Suspense fallback={<Loader3 />}>
        <Routes>
          {/* Rutas públicas con SEO */}
          {getPublicRoutes()}

          {/* Rutas protegidas (requieren autenticación) */}
          {getProtectedRoutes()}

          {/* Rutas de error */}
          {getErrorRoutes()}
        </Routes>
      </Suspense>
    </Router>
  );
}

export default App;
