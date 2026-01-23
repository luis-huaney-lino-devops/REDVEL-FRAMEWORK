"use client";

import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { MoreVertical } from "lucide-react";

import { PermisoComponente } from "@/assets/Auth/PermisoComponente";
import { useIsMobile } from "@/hooks/use-mobile";
import type { TableAction } from "./type/generic-table";

interface GenericActionsCellProps {
  id: number | string;
  actions: TableAction[];
}

export default function GenericActionsCell({
  id,
  actions,
}: GenericActionsCellProps) {
  const isMobile = useIsMobile();

  // Si no hay acciones, no mostrar nada
  if (!actions || actions.length === 0) {
    return null;
  }

  // Filtrar acciones con permisos (el PermisoComponente manejará la visibilidad)
  const filteredActions = actions;

  // Si después de filtrar no hay acciones, no mostrar nada
  if (filteredActions.length === 0) {
    return null;
  }

  if (isMobile) {
    // En móvil: mostrar todas las acciones en un menú dropdown
    return (
      <DropdownMenu>
        <DropdownMenuTrigger asChild>
          <Button
            variant="outline"
            size="sm"
            className="h-8 w-8 p-0 bg-transparent"
          >
            <MoreVertical className="h-4 w-4" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" className="w-56">
          {filteredActions.map((action) => (
            <PermisoComponente
              key={action.label}
              permisos={action.permission || []}
            >
              <DropdownMenuItem
                onClick={() => action.onClick(id)}
                className={
                  action.variant === "destructive"
                    ? "text-destructive focus:text-destructive"
                    : ""
                }
              >
                <action.icon className="mr-2 h-4 w-4" />
                {action.label}
              </DropdownMenuItem>
            </PermisoComponente>
          ))}
        </DropdownMenuContent>
      </DropdownMenu>
    );
  }

  // Desktop: mostrar botones visibles + menú dropdown para el resto
  const visibleActions = filteredActions.filter((a) => a.showOnMobile === true);
  const hiddenActions = filteredActions.filter((a) => a.showOnMobile !== true);

  // Si no hay acciones visibles ni ocultas, no mostrar nada
  if (visibleActions.length === 0 && hiddenActions.length === 0) {
    return null;
  }

  return (
    <div className="flex items-center gap-1">
      {visibleActions.map((action) => (
        <PermisoComponente
          key={action.label}
          permisos={action.permission || []}
        >
          <Button
            variant={action.variant || "outline"}
            size="sm"
            onClick={() => action.onClick(id)}
            title={action.label}
            className="h-8 w-8 p-0"
          >
            <action.icon className="h-3 w-3" />
          </Button>
        </PermisoComponente>
      ))}

      {hiddenActions.length > 0 && (
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <Button
              variant="outline"
              size="sm"
              className="h-8 w-8 p-0 bg-transparent"
            >
              <MoreVertical className="h-4 w-4" />
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end" className="w-56">
            {hiddenActions.map((action) => (
              <PermisoComponente
                key={action.label}
                permisos={action.permission || []}
              >
                <DropdownMenuItem
                  onClick={() => action.onClick(id)}
                  className={
                    action.variant === "destructive"
                      ? "text-destructive focus:text-destructive"
                      : ""
                  }
                >
                  <action.icon className="mr-2 h-4 w-4" />
                  {action.label}
                </DropdownMenuItem>
              </PermisoComponente>
            ))}
          </DropdownMenuContent>
        </DropdownMenu>
      )}
    </div>
  );
}
