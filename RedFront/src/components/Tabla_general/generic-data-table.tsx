"use client";

import type React from "react";
import { useState, useMemo, useCallback } from "react";
import {
  Table,
  TableHeader,
  TableBody,
  TableRow,
  TableHead,
  TableCell,
} from "@/components/ui/table";
import { Card, CardHeader, CardContent } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import {
  Select,
  SelectTrigger,
  SelectValue,
  SelectContent,
  SelectItem,
} from "@/components/ui/select";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Badge } from "@/components/ui/badge";
import { Skeleton } from "@/components/ui/skeleton";
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuCheckboxItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";
import { X, ArrowUpDown, ArrowUp, ArrowDown, RefreshCw, Columns3, Download, ChevronDown } from "lucide-react";
import { Separator } from "@/components/ui/separator";
import type {
  GenericDataTableProps,
  SortConfig,
  ActiveFilter,
  ExportFormat,
  ExportScope,
  TableHeaderAction,
} from "./type/generic-table";
import NoData from "./NoData";
import GenericActionsCell from "./generic-actions-cell";
import ColumnFilterComponent from "./column-filter";
import ExportModal from "./ExportModal";
import { DEFAULT_PAGE_SIZE_OPTIONS } from "./type/generic-table";
import { runExport, EXPORT_FORMAT_LABELS } from "./export-utils";
import { format } from "date-fns";
import { es } from "date-fns/locale";

const DEFAULT_EXPORT_TYPES: ExportFormat[] = ["json", "xml", "csv", "txt", "msexcel", "pdf"];

export default function GenericDataTable<T extends object>({
  columns,
  data,
  idField,
  actions = [],
  loading = false,
  totalItems,
  currentPage,
  pageSize,
  pageSizeOptions = DEFAULT_PAGE_SIZE_OPTIONS,
  onPageChange,
  onPageSizeChange,
  searchQuery = "",
  onSearch,
  searchPlaceholder = "Buscar...",
  onFilterChange,
  activeFilters = [],
  onSortChange,
  defaultSort,
  selection,
  selectedIds = [],
  tableId,
  hiddenColumns = [],
  onHiddenColumnsChange,
  exportConfig,
  onClearFilters,
  onRefetch,
  pageTitle,
  showHeader = true,
  showFooter = true,
  stickyHeader = false,
  maxHeight,
  className = "",
  rowClassName,
  onRowClick,
  headerActions,
  tableHeaderActions = [],
  noDataConfig,
}: GenericDataTableProps<T>) {
  const [sortConfig, setSortConfig] = useState<SortConfig | null>(
    defaultSort || null
  );
  const [localSelectedIds, setLocalSelectedIds] = useState<(string | number)[]>([]);
  const [filters, setFilters] = useState<ActiveFilter[]>([]);
  const [exportModalOpen, setExportModalOpen] = useState(false);
  const [exportFormat, setExportFormat] = useState<ExportFormat>("csv");
  const [isExporting, setIsExporting] = useState(false);
  const [executingActions, setExecutingActions] = useState<Set<string>>(new Set());

  const exportTypes = exportConfig?.exportTypes ?? DEFAULT_EXPORT_TYPES;
  const modeExport = exportConfig?.modeExport === true;

  const visibleColumns = useMemo(
    () => columns.filter((c) => !hiddenColumns.includes(String(c.key))),
    [columns, hiddenColumns]
  );

  const exportableColumns = useMemo(
    () =>
      visibleColumns
        .filter((c) => c.exportable !== false)
        .map((c) => ({ key: String(c.key), label: c.label })),
    [visibleColumns]
  );

  const toggleColumnVisibility = useCallback(
    (key: string) => {
      const next = hiddenColumns.includes(key)
        ? hiddenColumns.filter((k) => k !== key)
        : [...hiddenColumns, key];
      onHiddenColumnsChange?.(next);
    },
    [hiddenColumns, onHiddenColumnsChange]
  );

  // Usar selectedIds de props o estado local
  const currentSelectedIds = selectedIds.length > 0 ? selectedIds : localSelectedIds;

  const handleTableHeaderAction = useCallback(
    async (action: TableHeaderAction) => {
      const selected = selectedIds.length > 0 ? selectedIds : localSelectedIds;
      if (action.requiresSelection && selected.length === 0) {
        return;
      }

      if (action.disableWhileExecuting) {
        setExecutingActions((prev) => new Set(prev).add(action.id));
      }

      try {
        await action.onClick(selected);
      } catch (error) {
        console.error(`Error ejecutando acción ${action.id}:`, error);
      } finally {
        if (action.disableWhileExecuting) {
          setExecutingActions((prev) => {
            const next = new Set(prev);
            next.delete(action.id);
            return next;
          });
        }
      }
    },
    [selectedIds, localSelectedIds]
  );

  // Datos ordenados localmente
  const sortedData = useMemo(() => {
    if (!sortConfig) return data;

    return [...data].sort((a, b) => {
      const aValue = a[sortConfig.key as keyof T];
      const bValue = b[sortConfig.key as keyof T];

      if (aValue === null || aValue === undefined) return 1;
      if (bValue === null || bValue === undefined) return -1;

      if (typeof aValue === "number" && typeof bValue === "number") {
        return sortConfig.direction === "asc"
          ? aValue - bValue
          : bValue - aValue;
      }

      return (
        String(aValue).localeCompare(String(bValue), "es", {
          sensitivity: "base",
          numeric: true,
        }) * (sortConfig.direction === "asc" ? 1 : -1)
      );
    });
  }, [data, sortConfig]);

  // Manejar ordenamiento
  const handleSort = (key: string) => {
    const newSortConfig: SortConfig = {
      key,
      direction:
        sortConfig?.key === key && sortConfig.direction === "asc"
          ? "desc"
          : "asc",
    };
    setSortConfig(newSortConfig);
    onSortChange?.(newSortConfig);
  };

  const handleSearchInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    onSearch?.(e.target.value);
  };

  const handleExportConfirm = useCallback(
    async (scope: ExportScope) => {
      if (!modeExport || exportableColumns.length === 0) return;
      setIsExporting(true);
      try {
        let rows: Record<string, unknown>[] = [];
        if (scope === "visible") {
          rows = data as Record<string, unknown>[];
        } else if (scope === "selected") {
          const ids = selectedIds.length > 0 ? selectedIds : localSelectedIds;
          rows = (data as Record<string, unknown>[]).filter((r) =>
            ids.includes(r[String(idField)] as string | number)
          );
        } else if (scope === "all" && exportConfig?.onExportAll) {
          rows = await exportConfig.onExportAll({
            format: exportFormat,
            scope: "all",
            columns: exportableColumns,
          });
        }
        if (rows.length > 0) {
          runExport(
            exportFormat,
            rows,
            exportableColumns,
            `export-${tableId ?? "data"}-${Date.now()}`
          );
        }
        // Cerrar modal después de exportar
        setTimeout(() => {
          setExportModalOpen(false);
          setIsExporting(false);
        }, 100);
      } catch (error) {
        console.error("Error al exportar:", error);
        setIsExporting(false);
      }
    },
    [
      modeExport,
      exportableColumns,
      data,
      idField,
      selectedIds,
      localSelectedIds,
      exportConfig,
      exportFormat,
      tableId,
    ]
  );

  // Manejar selección
  const handleSelectAll = (checked: boolean) => {
    if (checked) {
      const allIds = data.map((item) => item[idField] as string | number);
      if (selection?.onSelectionChange) {
        selection.onSelectionChange(allIds);
      } else {
        setLocalSelectedIds(allIds);
      }
    } else {
      if (selection?.onSelectionChange) {
        selection.onSelectionChange([]);
      } else {
        setLocalSelectedIds([]);
      }
    }
  };

  const handleSelectRow = (id: string | number, checked: boolean) => {
    let newSelection: (string | number)[];
    
    if (selection?.mode === "single") {
      newSelection = checked ? [id] : [];
    } else {
      if (checked) {
        newSelection = [...currentSelectedIds, id];
      } else {
        newSelection = currentSelectedIds.filter((selectedId) => selectedId !== id);
      }
    }
    
    if (selection?.onSelectionChange) {
      selection.onSelectionChange(newSelection);
    } else {
      setLocalSelectedIds(newSelection);
    }
  };

  const isAllSelected =
    data.length > 0 && currentSelectedIds.length === data.length;
  const isSomeSelected =
    currentSelectedIds.length > 0 && currentSelectedIds.length < data.length;

  // Usar activeFilters de props o estado local
  const currentFilters = activeFilters.length > 0 ? activeFilters : filters;

  // Manejar filtros
  const handleFilterChange = (columnKey: string, filter: ActiveFilter | null) => {
    let newFilters: ActiveFilter[];
    
    if (filter === null) {
      newFilters = currentFilters.filter((f) => f.columnKey !== columnKey);
    } else {
      const existingFilterIndex = currentFilters.findIndex(
        (f) => f.columnKey === columnKey
      );
      if (existingFilterIndex >= 0) {
        newFilters = [...currentFilters];
        newFilters[existingFilterIndex] = filter;
      } else {
        newFilters = [...currentFilters, filter];
      }
    }
    
    if (onFilterChange) {
      onFilterChange(newFilters);
    } else {
      setFilters(newFilters);
    }
  };

  const handleRemoveFilter = (columnKey: string) => {
    const newFilters = currentFilters.filter((f) => f.columnKey !== columnKey);
    if (onFilterChange) {
      onFilterChange(newFilters);
    } else {
      setFilters(newFilters);
    }
  };

  const handleClearAllFilters = () => {
    if (onFilterChange) {
      onFilterChange([]);
    } else {
      setFilters([]);
    }
    onClearFilters?.();
  };

  // Formatear valores según tipo de columna
  const formatCellValue = (column: typeof columns[0], value: unknown, row: T): React.ReactNode => {
    if (column.render) {
      return column.render(value, row);
    }

    if (value === null || value === undefined) {
      return "-";
    }

    switch (column.type) {
      case "date": {
        try {
          const dateValue = value as string | number | Date;
          const date = new Date(dateValue);
          return format(date, column.format?.dateFormat || "dd/MM/yyyy", {
            locale: es,
          });
        } catch {
          return String(value);
        }
      }

      case "datetime": {
        try {
          const dateValue = value as string | number | Date;
          const date = new Date(dateValue);
          return format(
            date,
            column.format?.dateFormat || "dd/MM/yyyy HH:mm",
            { locale: es }
          );
        } catch {
          return String(value);
        }
      }

      case "time": {
        try {
          const dateValue = value as string | number | Date;
          const date = new Date(dateValue);
          return format(date, "HH:mm:ss", { locale: es });
        } catch {
          return String(value);
        }
      }

      case "number": {
        const numValue = Number(value);
        if (isNaN(numValue)) return String(value);

        const decimals = column.format?.numberFormat?.decimals ?? 0;
        const prefix = column.format?.numberFormat?.prefix || "";
        const suffix = column.format?.numberFormat?.suffix || "";
        const separator =
          column.format?.numberFormat?.thousandsSeparator || ",";

        const formatted = numValue.toFixed(decimals).replace(
          /\B(?=(\d{3})+(?!\d))/g,
          separator
        );
        return `${prefix}${formatted}${suffix}`;
      }

      case "boolean": {
        return (
          <Badge variant={value ? "default" : "secondary"}>
            {value ? "Sí" : "No"}
          </Badge>
        );
      }

      case "image": {
        return (
          <img
            src={String(value)}
            alt="Imagen"
            className="h-10 w-10 object-cover rounded"
          />
        );
      }

      default:
        return String(value);
    }
  };

  // Paginación
  const startIndex = (currentPage - 1) * pageSize;
  const endIndex = Math.min(startIndex + pageSize, totalItems);
  const totalPages = Math.ceil(totalItems / pageSize);

  const hasHeaderActions = headerActions || tableHeaderActions.length > 0;

  return (
    <>
      <Card className={`shadow-lg rounded-lg w-full ${className}`}>
        {/* Componentes y acciones encima del header */}
        {hasHeaderActions && (
          <div className="px-6 pt-6 pb-4">
            {headerActions && (
              <div className="mb-4">
                {headerActions}
              </div>
            )}
            {tableHeaderActions.length > 0 && (
              <div className="flex items-center gap-2 flex-wrap">
                {tableHeaderActions.map((action) => {
                  const Icon = action.icon;
                  const isExecuting = executingActions.has(action.id);
                  const isDisabled = 
                    action.disabled ||
                    isExecuting ||
                    (action.requiresSelection && currentSelectedIds.length === 0);
                  const style = action.textColor ? { color: action.textColor } : undefined;

                  return (
                    <Button
                      key={action.id}
                      onClick={() => handleTableHeaderAction(action)}
                      variant={action.variant || "outline"}
                      size="sm"
                      className={action.className}
                      style={style}
                      disabled={isDisabled}
                      title={action.tooltip}
                    >
                      {Icon && <Icon className="w-4 h-4 mr-2" />}
                      {action.label}
                      {isExecuting && (
                        <RefreshCw className="w-4 h-4 ml-2 animate-spin" />
                      )}
                    </Button>
                  );
                })}
              </div>
            )}
            <Separator className="mt-4" />
          </div>
        )}

        {showHeader && (
     <CardHeader>
  <div className="flex flex-col gap-4">
    {/* Título */}
    {pageTitle && (
      <h2 className="text-2xl font-bold">{pageTitle}</h2>
    )}

    {/* Todo en una fila para PC, columnas para móvil */}
    <div className="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
      {/* Selector de página */}
 
      {/* Búsqueda */}
      {onSearch && (
        <div className="relative w-full lg:flex-1 lg:max-w-md">
          <Input
            placeholder={searchPlaceholder}
            value={searchQuery}
            onChange={handleSearchInputChange}
            className="w-full pr-8 text-sm"
          />
          {searchQuery && (
            <Button
              variant="ghost"
              size="sm"
              onClick={handleClearAllFilters}
              className="absolute right-1 top-1/2 -translate-y-1/2 h-6 w-6 p-0 hover:bg-muted"
            >
              <X className="w-4 h-4" />
            </Button>
          )}
        </div>
      )}
 

      {/* Botones de acción */}
      <div className="flex items-center gap-2 flex-wrap lg:flex-nowrap">
           <div className="flex items-center gap-2">
        <span className="text-sm text-muted-foreground whitespace-nowrap">
          Mostrar:
        </span>
        <Select
          value={pageSize.toString()}
          onValueChange={(val) => onPageSizeChange(Number(val))}
        >
          <SelectTrigger className="w-20">
            <SelectValue />
          </SelectTrigger>
          <SelectContent>
            {pageSizeOptions.map((size) => (
              <SelectItem key={size} value={size.toString()}>
                {size}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </div> {onRefetch && (
          <Button
            variant="outline"
            size="sm"
            onClick={onRefetch}
            title="Actualizar"
          >
            Recargar
            <RefreshCw className="w-4 h-4 ml-2" />
          </Button>
        )}
        {tableId != null && onHiddenColumnsChange && (
          <DropdownMenu>
            <DropdownMenuTrigger asChild>
              <Button variant="outline" size="sm" title="Mostrar/ocultar columnas">
                <Columns3 className="w-4 h-4" />
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end" className="max-h-64 overflow-y-auto">
              <DropdownMenuLabel>Columnas visibles</DropdownMenuLabel>
              <DropdownMenuSeparator />
              {columns.map((col) => {
                const key = String(col.key);
                const hidden = hiddenColumns.includes(key);
                return (
                  <DropdownMenuCheckboxItem
                    key={key}
                    checked={!hidden}
                    onCheckedChange={() => toggleColumnVisibility(key)}
                  >
                    {col.label}
                  </DropdownMenuCheckboxItem>
                );
              })}
            </DropdownMenuContent>
          </DropdownMenu>
        )}
        {modeExport && (
          <DropdownMenu>
            <DropdownMenuTrigger asChild>
              <Button variant="outline" size="sm" title="Exportar">
                <Download className="w-4 h-4" />
                <ChevronDown className="w-3 h-3 ml-1" />
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
              <DropdownMenuLabel>Formato</DropdownMenuLabel>
              <DropdownMenuSeparator />
              {exportTypes.map((fmt) => (
                <DropdownMenuItem
                  key={fmt}
                  onClick={() => {
                    setExportFormat(fmt);
                    setExportModalOpen(true);
                  }}
                >
                  {EXPORT_FORMAT_LABELS[fmt]}
                </DropdownMenuItem>
              ))}
            </DropdownMenuContent>
          </DropdownMenu>
        )}
      </div>
    </div>

    {/* Filtros activos */}
    {currentFilters.length > 0 && (
      <div className="flex flex-wrap items-center gap-2">
        <span className="text-sm text-muted-foreground">
          Filtros activos:
        </span>
        {currentFilters.map((filter) => (
          <Badge
            key={filter.columnKey}
            variant="secondary"
            className="gap-1"
          >
            {filter.label}
            <Button
              variant="ghost"
              size="sm"
              className="h-4 w-4 p-0 hover:bg-transparent"
              onClick={() => handleRemoveFilter(filter.columnKey)}
            >
              <X className="h-3 w-3" />
            </Button>
          </Badge>
        ))}
        <Button
          variant="ghost"
          size="sm"
          onClick={handleClearAllFilters}
          className="text-xs"
        >
          Limpiar todos
        </Button>
      </div>
    )}

    {/* Información de selección */}
    {selection?.enabled && currentSelectedIds.length > 0 && (
      <div className="flex items-center gap-2 flex-wrap">
        <Badge variant="default">
          {currentSelectedIds.length} seleccionado(s)
        </Badge>
        <Button
          variant="ghost"
          size="sm"
          onClick={() => handleSelectAll(false)}
          className="text-xs"
        >
          Deseleccionar todos
        </Button>
      </div>
    )}
  </div>
</CardHeader>
          )}

          <CardContent>
      <div className="rounded-md border overflow-hidden">
  {!loading && data.length === 0 ? (
    <NoData
      type={searchQuery || currentFilters.length > 0 ? "no-results" : "no-data"}
      onClearFilters={handleClearAllFilters}
      onRefetch={onRefetch}
      config={noDataConfig}
    />
  ) : (
    <div
      className="overflow-auto transition-opacity duration-200"
      style={{
        maxHeight: maxHeight || "calc(100vh - 400px)",
        opacity: loading ? 0.85 : 1,
      }}
    >
      <Table>
        <TableHeader className={stickyHeader ? "sticky top-0 bg-background z-10" : ""}>
          <TableRow>
            {selection?.enabled && (
              <TableHead className="w-12">
                {selection.mode !== "single" && (
                  <Checkbox
                    checked={isAllSelected}
                    onCheckedChange={handleSelectAll}
                    aria-label="Seleccionar todos"
                    className={isSomeSelected ? "opacity-50" : ""}
                  />
                )}
              </TableHead>
            )}

            {visibleColumns.map((col) => (
              <TableHead
                key={String(col.key)}
                className={`text-xs sm:text-sm whitespace-nowrap ${
                  col.isFixed ? "sticky left-0 bg-background z-20" : ""
                } ${col.align === "center" ? "text-center" : col.align === "right" ? "text-right" : ""}`}
                style={{
                  width: col.width,
                  minWidth: col.minWidth,
                }}
              >
                <div className="flex items-center gap-1">
                  {/* Botón de ordenamiento */}
                  {col.isSortable !== false ? (
                    <Button
                      variant="ghost"
                      size="sm"
                      onClick={() => handleSort(String(col.key))}
                      className="h-auto p-0 hover:bg-transparent font-semibold"
                    >
                      {col.label}
                      {sortConfig?.key === String(col.key) ? (
                        sortConfig.direction === "asc" ? (
                          <ArrowUp className="ml-1 h-3 w-3" />
                        ) : (
                          <ArrowDown className="ml-1 h-3 w-3" />
                        )
                      ) : (
                        <ArrowUpDown className="ml-1 h-3 w-3 opacity-50" />
                      )}
                    </Button>
                  ) : (
                    <span className="font-semibold">{col.label}</span>
                  )}

                  {/* Botón de filtro */}
                  {col.isFilterable && col.filter && (
                    <ColumnFilterComponent
                      columnKey={String(col.key)}
                      columnLabel={col.label}
                      filterConfig={col.filter}
                      activeFilter={currentFilters.find(
                        (f) => f.columnKey === String(col.key)
                      )}
                      onApplyFilter={(filter) =>
                        handleFilterChange(String(col.key), filter)
                      }
                    />
                  )}
                </div>
              </TableHead>
            ))}

            {/* Columna de acciones */}
            {actions.length > 0 && (
              <TableHead className="text-xs sm:text-sm whitespace-nowrap text-center">
                Acciones
              </TableHead>
            )}
          </TableRow>
        </TableHeader>

        <TableBody>
          {loading ? (
            Array.from({ length: pageSize }).map((_, i) => (
              <TableRow key={`skeleton-${i}`}>
                {selection?.enabled && (
                  <TableCell className="w-12">
                    <Skeleton className="h-4 w-4 rounded" />
                  </TableCell>
                )}
                {visibleColumns.map((col) => (
                  <TableCell
                    key={String(col.key)}
                    className="text-xs sm:text-sm"
                    style={{ width: col.width, minWidth: col.minWidth }}
                  >
                    <Skeleton className="h-4 w-full max-w-[80%] rounded" />
                  </TableCell>
                ))}
                {actions.length > 0 && (
                  <TableCell className="text-center">
                    <Skeleton className="h-8 w-16 mx-auto rounded" />
                  </TableCell>
                )}
              </TableRow>
            ))
          ) : (
                        sortedData.map((item) => {
                          const itemId = item[idField] as string | number;
                          const isSelected = currentSelectedIds.includes(itemId);

              return (
                <TableRow
                  key={String(itemId)}
                  className={`
                    ${isSelected ? "bg-muted/50" : ""}
                    ${onRowClick ? "cursor-pointer hover:bg-muted/30" : ""}
                    ${rowClassName ? rowClassName(item) : ""}
                  `}
                  onClick={() => {
                    if (onRowClick) {
                      onRowClick(item);
                    } else if (selection?.enabled) {
                      handleSelectRow(itemId, !isSelected);
                    }
                  }}
                >
                  {/* Checkbox de selección */}
                  {selection?.enabled && (
                    <TableCell
                      className="w-12"
                      onClick={(e) => e.stopPropagation()}
                    >
                      <Checkbox
                        checked={isSelected}
                        onCheckedChange={(checked) =>
                          handleSelectRow(itemId, checked as boolean)
                        }
                        aria-label={`Seleccionar fila ${itemId}`}
                      />
                    </TableCell>
                  )}

                  {visibleColumns.map((col) => (
                    <TableCell
                      key={String(col.key)}
                      className={`text-xs sm:text-sm ${
                        col.type === "number" || col.isNumeric
                          ? "text-right"
                          : col.align === "center"
                          ? "text-center"
                          : col.align === "right"
                          ? "text-right"
                          : ""
                      } ${col.isFixed ? "sticky left-0 bg-background" : ""}`}
                      style={{
                        width: col.width,
                        minWidth: col.minWidth,
                      }}
                    >
                      {formatCellValue(col, item[col.key], item)}
                    </TableCell>
                  ))}

                  {/* Celda de acciones */}
                  {actions.length > 0 && (
                    <TableCell
                      className="whitespace-nowrap text-center"
                      onClick={(e) => e.stopPropagation()}
                    >
                      <GenericActionsCell
                        id={itemId}
                        actions={actions}
                      />
                    </TableCell>
                  )}
                </TableRow>
              );
            })
          )}
        </TableBody>
      </Table>
    </div>
  )}
</div>

            {/* Paginación */}
            {showFooter && data.length > 0 && (
              <div className="flex flex-col gap-4 mt-4">
                {/* Información de resultados */}
              <div className="text-sm text-muted-foreground text-center sm:text-left flex flex-row gap-2 justify-between">
                <div className="flex items-center gap-2 justify-center sm:justify-start flex-wrap mb-2">
                  Mostrando {startIndex + 1} a {endIndex} de {totalItems}{" "}
                  resultados
                </div>
                 {/* Controles de paginación */}
                <div className="flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-4">
                  <div className="flex items-center gap-2">
                    <Button
                      variant="outline"
                      size="sm"
                      onClick={() => onPageChange(Math.max(currentPage - 1, 1))}
                      disabled={currentPage === 1}
                      className="text-xs sm:text-sm"
                    >
                      Anterior
                    </Button>

                    {/* Botones de página */}
                    <div className="flex items-center gap-1">
                      {(() => {
                        const pages = [];
                        const maxVisiblePages =
                          typeof window !== "undefined" && window.innerWidth < 640
                            ? 3
                            : 5;
                        let startPage = Math.max(
                          1,
                          currentPage - Math.floor(maxVisiblePages / 2)
                        );
                        const endPage = Math.min(
                          totalPages,
                          startPage + maxVisiblePages - 1
                        );

                        if (endPage - startPage + 1 < maxVisiblePages) {
                          startPage = Math.max(1, endPage - maxVisiblePages + 1);
                        }

                        if (startPage > 1) {
                          pages.push(
                            <Button
                              key={1}
                              variant={1 === currentPage ? "default" : "outline"}
                              size="sm"
                              onClick={() => onPageChange(1)}
                              className="w-6 h-6 sm:w-8 sm:h-8 p-0 text-xs sm:text-sm"
                            >
                              1
                            </Button>
                          );
                          if (startPage > 2) {
                            pages.push(
                              <span
                                key="ellipsis-start"
                                className="px-1 sm:px-2 text-xs sm:text-sm text-muted-foreground"
                              >
                                ...
                              </span>
                            );
                          }
                        }

                        for (let i = startPage; i <= endPage; i++) {
                          pages.push(
                            <Button
                              key={i}
                              variant={i === currentPage ? "default" : "outline"}
                              size="sm"
                              onClick={() => onPageChange(i)}
                              className="w-6 h-6 sm:w-8 sm:h-8 p-0 text-xs sm:text-sm"
                            >
                              {i}
                            </Button>
                          );
                        }

                        if (endPage < totalPages) {
                          if (endPage < totalPages - 1) {
                            pages.push(
                              <span
                                key="ellipsis-end"
                                className="px-1 sm:px-2 text-xs sm:text-sm text-muted-foreground"
                              >
                                ...
                              </span>
                            );
                          }
                          pages.push(
                            <Button
                              key={totalPages}
                              variant={
                                totalPages === currentPage ? "default" : "outline"
                              }
                              size="sm"
                              onClick={() => onPageChange(totalPages)}
                              className="w-6 h-6 sm:w-8 sm:h-8 p-0 text-xs sm:text-sm"
                            >
                              {totalPages}
                            </Button>
                          );
                        }

                        return pages;
                      })()}
                    </div>

                    <Button
                      variant="outline"
                      size="sm"
                      onClick={() =>
                        onPageChange(Math.min(currentPage + 1, totalPages))
                      }
                      disabled={currentPage === totalPages}
                      className="text-xs sm:text-sm"
                    >
                      Siguiente
                    </Button>
                  </div>
                </div>
                  </div>

               
              </div>
            )}
          </CardContent>
        </Card>

      {modeExport && (
        <ExportModal
          open={exportModalOpen}
          onOpenChange={setExportModalOpen}
          format={exportFormat}
          hasSelection={currentSelectedIds.length > 0}
          hasExportAll={!!exportConfig?.onExportAll}
          onConfirm={handleExportConfirm}
          isExporting={isExporting}
        />
      )}
    </>
  );
}
