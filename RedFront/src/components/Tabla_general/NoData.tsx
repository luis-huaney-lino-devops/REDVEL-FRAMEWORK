"use client";

import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Card, CardTitle, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { TableIcon, SearchX, RefreshCcw, Filter } from "lucide-react";
import type { NoDataConfig } from "./type/generic-table";

interface NoDataProps {
  type: "no-data" | "no-results";
  onClearFilters?: () => void;
  onRefetch?: () => void;
  config?: NoDataConfig;
}

export default function NoData({
  type,
  onClearFilters,
  onRefetch,
  config,
}: NoDataProps) {
  const navigate = useNavigate();
  const [isExecuting, setIsExecuting] = useState(false);

  const handleAction = async () => {
    if (!config?.action) return;

    const action = config.action;

    if (action.disableWhileExecuting) {
      setIsExecuting(true);
    }

    try {
      if (action.type === "navigation" && action.to) {
        navigate(action.to);
      } else if (action.type === "function" && action.onClick) {
        await action.onClick();
      }
    } catch (error) {
      console.error("Error ejecutando acción:", error);
    } finally {
      if (action.disableWhileExecuting) {
        setIsExecuting(false);
      }
    }
  };

  const renderActionButton = () => {
    if (type === "no-results" && onClearFilters && !config?.action) {
      return (
        <Button
          onClick={onClearFilters}
          variant="outline"
          size="sm"
          className="gap-2"
        >
          <Filter className="w-4 h-4" />
          Limpiar filtros
        </Button>
      );
    }

    if (type === "no-data" && onRefetch && !config?.action) {
      return (
        <Button
          onClick={onRefetch}
          variant="outline"
          size="sm"
          className="gap-2"
        >
          <RefreshCcw className="w-4 h-4" />
          Recargar Datos
        </Button>
      );
    }

    if (config?.showAction && config.action) {
      const action = config.action;
      const Icon = action.icon;
      const style = action.textColor ? { color: action.textColor } : undefined;

      return (
        <Button
          onClick={handleAction}
          variant={action.variant || "outline"}
          size="sm"
          className={`gap-2 ${action.className || ""}`}
          style={style}
          disabled={isExecuting || (action.disableWhileExecuting && isExecuting)}
        >
          {Icon && <Icon className="w-4 h-4" />}
          {action.label}
        </Button>
      );
    }

    return null;
  };

  if (type === "no-results") {
    return (
      <Card className="border-border">
        <CardContent className="flex flex-col items-center justify-center py-12 px-6">
          <div className="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-muted">
            <SearchX className="w-8 h-8 text-muted-foreground" />
          </div>

          <CardTitle className="text-lg font-semibold text-foreground mb-2 text-center">
            {config?.title || "No se encontraron resultados"}
          </CardTitle>

          <p className="text-sm text-muted-foreground text-center max-w-sm mb-6">
            {config?.description || 
              "No pudimos encontrar datos que coincidan con tus criterios de búsqueda. Intenta ajustar los filtros."}
          </p>

          {renderActionButton()}
        </CardContent>
      </Card>
    );
  }

  return (
    <Card className="border-border">
      <CardContent className="flex flex-col items-center justify-center py-12 px-6">
        <div className="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-muted">
          <TableIcon className="w-8 h-8 text-muted-foreground" />
        </div>

        <CardTitle className="text-lg font-semibold text-foreground mb-2 text-center">
          {config?.title || "No hay datos para mostrar"}
        </CardTitle>

        <p className="text-sm text-muted-foreground text-center max-w-sm mb-6">
          {config?.description || 
            "Aún no tienes datos registrados en tu sistema. ¡Comienza agregando información!"}
        </p>

        {renderActionButton()}
      </CardContent>
    </Card>
  );
}