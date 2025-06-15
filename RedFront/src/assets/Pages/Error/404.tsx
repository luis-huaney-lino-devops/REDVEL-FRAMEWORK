import { Button } from "@/components/ui/button";
import { useNavigate } from "react-router-dom";

export default function Error404() {
  const navigate = useNavigate();
  const redir = () => {
    navigate("/inicio");
  };

  return (
    <div className="h-screen">
      <div className="m-auto flex h-full w-full flex-col items-center justify-center gap-2">
        <h1 className="text-[7rem] font-bold leading-tight">404</h1>
        <span className="font-medium">Oops! Esta pagina no existe!</span>
        <p className="text-center text-muted-foreground">
          Parece que la página que estás buscando
          <br />
          no existe o puede haber sido eliminada.
        </p>
        <div className="mt-6 flex gap-4">
          <Button variant="outline" onClick={() => history.go(-1)}>
            Volver Atrás
          </Button>
          <Button onClick={redir}>Volver al inicio</Button>
        </div>
      </div>
    </div>
  );
}
