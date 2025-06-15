import { useCallback, useMemo } from "react";
import { hasPermission } from "./authUtils";
import toast from "react-hot-toast";

interface UsePermisoOptions {
  mensajeError?: string;
  mostrarError?: boolean;
}

type FuncionSync<TArgs extends unknown[], TResult> = (
  ...args: TArgs
) => TResult;
type FuncionAsync<TArgs extends unknown[], TResult> = (
  ...args: TArgs
) => Promise<TResult>;

export const usePermiso = (
  permisos: string | string[],
  options: UsePermisoOptions = {}
) => {
  const {
    mensajeError = "No tienes permisos para realizar esta acción",
    mostrarError = true,
  } = options;

  const tienePermiso = useMemo(() => {
    if (Array.isArray(permisos)) {
      return permisos.some((permiso) => hasPermission(permiso));
    }
    return hasPermission(permisos);
  }, [permisos]);

  const ejecutarConPermiso = useCallback(
    <TArgs extends unknown[], TResult>(
      accion: FuncionSync<TArgs, TResult>,
      ...args: TArgs
    ): TResult | undefined => {
      if (!tienePermiso) {
        if (mostrarError) {
          toast.error(mensajeError);
        }
        return undefined;
      }
      return accion(...args);
    },
    [tienePermiso, mensajeError, mostrarError]
  );

  const ejecutarAsyncConPermiso = useCallback(
    <TArgs extends unknown[], TResult>(
      accion: FuncionAsync<TArgs, TResult>,
      ...args: TArgs
    ): Promise<TResult | undefined> => {
      if (!tienePermiso) {
        if (mostrarError) {
          toast.error(mensajeError);
        }
        return Promise.resolve(undefined);
      }
      return accion(...args);
    },
    [tienePermiso, mensajeError, mostrarError]
  );

  return {
    tienePermiso,
    ejecutarConPermiso,
    ejecutarAsyncConPermiso,
  };
};
