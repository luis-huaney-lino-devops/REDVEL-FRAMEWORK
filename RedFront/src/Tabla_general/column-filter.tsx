"use client";

import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Calendar } from "@/components/ui/calendar";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";
import { Filter, X, CalendarIcon } from "lucide-react";
import { format } from "date-fns";
import { es } from "date-fns/locale";
import type { DateRange } from "react-day-picker";
import type { ColumnFilter, ActiveFilter } from "./type/generic-table";

interface ColumnFilterProps {
  columnKey: string;
  columnLabel: string;
  filterConfig: ColumnFilter;
  activeFilter?: ActiveFilter;
  onApplyFilter: (filter: ActiveFilter | null) => void;
}

export default function ColumnFilterComponent({
  columnKey,
  columnLabel,
  filterConfig,
  activeFilter,
  onApplyFilter,
}: ColumnFilterProps) {
  const [isOpen, setIsOpen] = useState(false);
  const [filterValue, setFilterValue] = useState<string>(
    activeFilter?.value || ""
  );
  
  // Para dateRange, convertir string a DateRange
  const getInitialDateRange = (): DateRange | undefined => {
    if (activeFilter?.value?.start || activeFilter?.value?.end) {
      return {
        from: activeFilter.value.start ? new Date(activeFilter.value.start) : undefined,
        to: activeFilter.value.end ? new Date(activeFilter.value.end) : undefined,
      };
    }
    return undefined;
  };
  
  const [dateRange, setDateRange] = useState<DateRange | undefined>(getInitialDateRange());
  const [isDateRangePopoverOpen, setIsDateRangePopoverOpen] = useState(false);

  const handleApply = () => {
    if (filterConfig.type === "dateRange") {
      if (dateRange?.from || dateRange?.to) {
        const start = dateRange.from ? format(dateRange.from, "yyyy-MM-dd") : "";
        const end = dateRange.to ? format(dateRange.to, "yyyy-MM-dd") : "";
        const startFormatted = dateRange.from ? format(dateRange.from, "dd/MM/yyyy", { locale: es }) : "...";
        const endFormatted = dateRange.to ? format(dateRange.to, "dd/MM/yyyy", { locale: es }) : "...";
        
        onApplyFilter({
          columnKey,
          type: filterConfig.type,
          value: { start, end },
          label: `${columnLabel}: ${startFormatted} - ${endFormatted}`,
        });
      } else {
        onApplyFilter(null);
      }
    } else if (filterValue !== "" && filterValue !== null && filterValue !== undefined) {
      let label = `${columnLabel}: ${filterValue}`;
      
      // Para selects, buscar el label correspondiente
      if (filterConfig.type === "select" && filterConfig.options) {
        const option = filterConfig.options.find(opt => opt.value === filterValue);
        if (option) {
          label = `${columnLabel}: ${option.label}`;
        }
      }

      onApplyFilter({
        columnKey,
        type: filterConfig.type,
        value: filterValue,
        label,
      });
    } else {
      onApplyFilter(null);
    }
    setIsOpen(false);
  };

  const handleClear = () => {
    setFilterValue("");
    setDateRange(undefined);
    setIsDateRangePopoverOpen(false);
    onApplyFilter(null);
    setIsOpen(false);
  };

  const renderFilterInput = () => {
    switch (filterConfig.type) {
      case "text":
        return (
          <div className="space-y-2">
            <Label htmlFor={`filter-${columnKey}`}>Buscar</Label>
            <Input
              id={`filter-${columnKey}`}
              type="text"
              placeholder={filterConfig.placeholder || "Escribir..."}
              value={filterValue}
              onChange={(e) => setFilterValue(e.target.value)}
              onKeyDown={(e) => {
                if (e.key === "Enter") {
                  handleApply();
                }
              }}
            />
          </div>
        );

      case "number":
        return (
          <div className="space-y-2">
            <Label htmlFor={`filter-${columnKey}`}>Valor</Label>
            <Input
              id={`filter-${columnKey}`}
              type="number"
              placeholder={filterConfig.placeholder || "0"}
              value={filterValue}
              onChange={(e) => setFilterValue(e.target.value)}
              onKeyDown={(e) => {
                if (e.key === "Enter") {
                  handleApply();
                }
              }}
            />
          </div>
        );

      case "date":
        return (
          <div className="space-y-2">
            <Label htmlFor={`filter-${columnKey}`}>Fecha</Label>
            <Input
              id={`filter-${columnKey}`}
              type="date"
              value={filterValue}
              onChange={(e) => setFilterValue(e.target.value)}
            />
          </div>
        );

      case "dateRange":
        return (
          <div className="space-y-3">
            <Label>Seleccionar rango de fechas</Label>
            <Popover open={isDateRangePopoverOpen} onOpenChange={setIsDateRangePopoverOpen} modal={true}>
              <PopoverTrigger asChild>
                <Button
                  variant="outline"
                  className="w-full justify-start text-left font-normal"
                >
                  <CalendarIcon className="mr-2 h-4 w-4" />
                  {dateRange?.from ? (
                    dateRange.to ? (
                      <>
                        {format(dateRange.from, "dd/MM/yyyy", { locale: es })} -{" "}
                        {format(dateRange.to, "dd/MM/yyyy", { locale: es })}
                      </>
                    ) : (
                      format(dateRange.from, "dd/MM/yyyy", { locale: es })
                    )
                  ) : (
                    <span className="text-muted-foreground">Seleccionar rango</span>
                  )}
                </Button>
              </PopoverTrigger>
              <PopoverContent 
                className="w-auto p-0" 
                align="start"
                side="bottom"
                sideOffset={5}
                style={{ pointerEvents: 'auto' }}
                onPointerDownOutside={(e) => {
                  // Evitar que se cierre al hacer clic dentro del calendario
                  const target = e.target as HTMLElement;
                  if (target.closest('[role="dialog"]') || target.closest('.rdp')) {
                    e.preventDefault();
                  }
                }}
              >
                <Calendar
                  mode="range"
                  selected={dateRange}
                  onSelect={(range) => {
                    setDateRange(range);
                    // Solo cerrar cuando se haya seleccionado un rango completo
                    if (range?.from && range?.to) {
                      setTimeout(() => {
                        setIsDateRangePopoverOpen(false);
                      }, 150);
                    }
                  }}
                  numberOfMonths={2}
                  locale={es}
                  disabled={(date) => date > new Date()}
                  className="pointer-events-auto"
                />
              </PopoverContent>
            </Popover>
            {dateRange && (dateRange.from || dateRange.to) && (
              <div className="flex items-center gap-2 text-xs text-muted-foreground">
                <span>
                  {dateRange.from 
                    ? format(dateRange.from, "dd/MM/yyyy", { locale: es })
                    : "..."} - {dateRange.to 
                    ? format(dateRange.to, "dd/MM/yyyy", { locale: es })
                    : "..."}
                </span>
                <Button
                  variant="ghost"
                  size="sm"
                  className="h-5 w-5 p-0"
                  onClick={() => setDateRange(undefined)}
                >
                  <X className="h-3 w-3" />
                </Button>
              </div>
            )}
          </div>
        );

      case "select":
        return (
          <div className="space-y-2">
            <Label htmlFor={`filter-${columnKey}`}>Seleccionar</Label>
            <Select
              value={filterValue}
              onValueChange={(value) => setFilterValue(value)}
            >
              <SelectTrigger id={`filter-${columnKey}`}>
                <SelectValue placeholder="Seleccionar..." />
              </SelectTrigger>
              <SelectContent>
                {filterConfig.options?.map((option) => (
                  <SelectItem key={option.value} value={String(option.value)}>
                    {option.label}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
          </div>
        );

      case "boolean":
        return (
          <div className="space-y-2">
            <Label htmlFor={`filter-${columnKey}`}>Estado</Label>
            <Select
              value={filterValue}
              onValueChange={(value) => setFilterValue(value)}
            >
              <SelectTrigger id={`filter-${columnKey}`}>
                <SelectValue placeholder="Seleccionar..." />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="true">Sí</SelectItem>
                <SelectItem value="false">No</SelectItem>
              </SelectContent>
            </Select>
          </div>
        );

      default:
        return null;
    }
  };

  return (
    <DropdownMenu open={isOpen} onOpenChange={setIsOpen} modal={false}>
      <DropdownMenuTrigger asChild>
        <Button
          variant={activeFilter ? "default" : "ghost"}
          size="sm"
          className="h-6 w-6 p-0 ml-1"
          onClick={() => setIsOpen(!isOpen)}
        >
          <Filter className={`h-3 w-3 ${activeFilter ? "text-white" : ""}`} />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent className="w-72 p-4" align="start">
        <div className="space-y-4">
          <div className="flex items-center justify-between">
            <h4 className="font-semibold text-sm">Filtrar {columnLabel}</h4>
            <Button
              variant="ghost"
              size="sm"
              className="h-6 w-6 p-0"
              onClick={() => setIsOpen(false)}
            >
              <X className="h-4 w-4" />
            </Button>
          </div>

          {renderFilterInput()}

          <div className="flex gap-2 pt-2">
            <Button
              variant="outline"
              size="sm"
              onClick={handleClear}
              className="flex-1"
            >
              Limpiar
            </Button>
            <Button
              size="sm"
              onClick={handleApply}
              className="flex-1"
            >
              Aplicar
            </Button>
          </div>
        </div>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}