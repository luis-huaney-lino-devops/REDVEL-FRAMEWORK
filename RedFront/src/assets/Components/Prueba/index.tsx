import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";
import { AppSidebar } from "../Dashboard/App-Sidebar";
import HeaderDashboard from "../Dashboard/Header/Header";
import { Button } from "@/components/ui/button";
import { PermisoComponente } from "../../Auth/PermisoComponente";
import { usePermiso } from "../../Auth/usePermiso";

export default function Page() {
  // Ejemplo de uso con función síncrona
  const { ejecutarConPermiso } = usePermiso("usuarios.view", {
    mensajeError: "No tienes permisos para ver usuarios",
  });
  // const { ejecutarConPermiso } = usePermiso("usuarios.view");
  // ejecutarConPermiso(
  //   (param1, param2) => {
  //     // Lógica que requiere permiso
  //   },
  //   valor1,
  //   valor2
  // );

  // // Función asíncrona
  // const { ejecutarAsyncConPermiso } = usePermiso(["admin", "usuarios.edit"]);
  // await ejecutarAsyncConPermiso(async (id) => {
  //   // Lógica asíncrona que requiere permiso
  //   await api.editarUsuario(id);
  // }, 123);
  const handleClick = () => {
    ejecutarConPermiso((mensaje: string) => {
      console.log(mensaje);
      // Aquí iría la lógica que requiere el permiso
    }, "Acción ejecutada con permiso");
  };

  // Ejemplo de uso con función asíncrona
  const { ejecutarAsyncConPermiso } = usePermiso(["admin", "usuarios.edit"], {
    mensajeError: "No tienes permisos para editar usuarios",
  });

  const handleAsyncClick = async () => {
    await ejecutarAsyncConPermiso(async (id: number) => {
      // Simulación de una llamada a API
      await new Promise((resolve) => setTimeout(resolve, 1000));
      console.log(`Editando usuario ${id}`);
      return true;
    }, 123);
  };

  return (
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        <HeaderDashboard />
        <div className="flex flex-1 flex-col gap-4 p-4 pt-0">
          <div className="grid auto-rows-min gap-4 md:grid-cols-3">
            <div className="aspect-video rounded-xl bg-muted/50" />
            <div className="aspect-video rounded-xl bg-muted/50" />
            <div className="aspect-video rounded-xl bg-muted/50" />
            <PermisoComponente permisos="usuarios.view">
              <Button onClick={handleClick}>Botón con permiso síncrono</Button>
            </PermisoComponente>
            <PermisoComponente permisos={["admin", "usuarios.edit"]}>
              <Button onClick={handleAsyncClick}>
                Botón con permiso asíncrono
              </Button>
            </PermisoComponente>
          </div>
          <div className="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min" />
        </div>
      </SidebarInset>
    </SidebarProvider>
  );
}
