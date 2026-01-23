"use client";

import { useState, useEffect } from "react";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogFooter,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import type { ExportFormat, ExportScope } from "./type/generic-table";
import { EXPORT_FORMAT_LABELS } from "./export-utils";

const SCOPE_LABELS: Record<ExportScope, string> = {
  selected: "Solo seleccionados",
  all: "Todos los datos",
  visible: "Solo datos visibles en la tabla",
};

interface ExportModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  format: ExportFormat;
  hasSelection: boolean;
  hasExportAll: boolean;
  onConfirm: (scope: ExportScope) => void;
  isExporting?: boolean;
}

export default function ExportModal({
  open,
  onOpenChange,
  format,
  hasSelection,
  hasExportAll,
  onConfirm,
  isExporting = false,
}: ExportModalProps) {
  const [scope, setScope] = useState<ExportScope>("visible");

  // Limpiar pointer-events del body cuando el modal se cierra
  useEffect(() => {
    if (!open) {
      // Timeout para asegurar que se ejecuta después del cierre del modal
      const timer = setTimeout(() => {
        document.body.style.pointerEvents = "";
        setScope("visible");
      }, 100);
      return () => clearTimeout(timer);
    }
  }, [open]);

  // Cleanup al desmontar el componente
  useEffect(() => {
    return () => {
      document.body.style.pointerEvents = "";
    };
  }, []);

  const scopes: { value: ExportScope; disabled?: boolean }[] = [
    { value: "visible" },
    { value: "selected", disabled: !hasSelection },
    { value: "all", disabled: !hasExportAll },
  ];

  const handleConfirm = () => {
    if (scope === "selected" && !hasSelection) return;
    if (scope === "all" && !hasExportAll) return;
    
    onConfirm(scope);
    onOpenChange(false);
  };

  const handleOpenChange = (newOpen: boolean) => {
    if (!newOpen) {
      // Forzar limpieza inmediata cuando se cierra
      setTimeout(() => {
        document.body.style.pointerEvents = "";
      }, 0);
    }
    onOpenChange(newOpen);
  };

  return (
    <Dialog open={open} onOpenChange={handleOpenChange}>
      <DialogContent 
        className="sm:max-w-md"
        onPointerDownOutside={(e) => {
          if (isExporting) {
            e.preventDefault();
          }
        }}
        onEscapeKeyDown={(e) => {
          if (isExporting) {
            e.preventDefault();
          }
        }}
      >
        <DialogHeader>
          <DialogTitle>Exportar a {EXPORT_FORMAT_LABELS[format]}</DialogTitle>
        </DialogHeader>
        
        <div className="space-y-4 py-4">
          <div className="space-y-2">
            <Label>¿Qué datos exportar?</Label>
            <div 
              className="flex flex-col gap-2" 
              role="radiogroup" 
              aria-label="Alcance de exportación"
            >
              {scopes.map(({ value, disabled }) => (
                <label
                  key={value}
                  className={`flex items-center gap-2 rounded-md border px-3 py-2 transition-colors ${
                    disabled 
                      ? "opacity-50 cursor-not-allowed" 
                      : "cursor-pointer hover:bg-muted/50"
                  } ${scope === value ? "bg-muted border-primary" : ""}`}
                >
                  <input
                    type="radio"
                    name="export-scope"
                    value={value}
                    checked={scope === value}
                    onChange={(e) => {
                      if (!disabled && e.target.checked) {
                        setScope(value);
                      }
                    }}
                    disabled={disabled || isExporting}
                    className="h-4 w-4"
                  />
                  <span className="text-sm">
                    {SCOPE_LABELS[value]}
                    {value === "selected" && !hasSelection && " (ninguno seleccionado)"}
                    {value === "all" && !hasExportAll && " (no configurado)"}
                  </span>
                </label>
              ))}
            </div>
          </div>
        </div>
        
        <DialogFooter>
          <Button 
            variant="outline" 
            onClick={() => handleOpenChange(false)}
            disabled={isExporting}
          >
            Cancelar
          </Button>
          <Button
            onClick={handleConfirm}
            disabled={
              isExporting ||
              (scope === "selected" && !hasSelection) ||
              (scope === "all" && !hasExportAll)
            }
          >
            {isExporting ? "Exportando…" : "Exportar"}
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}