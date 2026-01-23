import type React from "react";

// Tipos de columna soportados
export type ColumnType = 
  | "text" 
  | "number" 
  | "date" 
  | "datetime" 
  | "time" 
  | "boolean" 
  | "image" 
  | "custom";

// Tipos de filtros
export type FilterType = "text" | "number" | "date" | "dateRange" | "select" | "boolean";

// Configuración de filtro para cada columna
export interface ColumnFilter {
  type: FilterType;
  options?: Array<{ label: string; value: any }>; // Para filtros tipo select
  placeholder?: string;
}

// Formatos de exportación soportados
export type ExportFormat =
  | "json"
  | "xml"
  | "csv"
  | "txt"
  | "msexcel"
  | "pdf";

// Modos de exportación en el modal
export type ExportScope = "selected" | "all" | "visible";

// Configuración de exportación (modulable por tabla)
export interface ExportConfig {
  /** Si la tabla admite exportación */
  modeExport?: boolean;
  /** Formatos habilitados para esta tabla (por defecto todos) */
  exportTypes?: ExportFormat[];
  /** Callback para obtener "todos los datos" desde API (scope: "all") */
  onExportAll?: (params: ExportParams) => Promise<Record<string, unknown>[]>;
}

export interface ExportParams {
  format: ExportFormat;
  scope: ExportScope;
  columns: { key: string; label: string }[];
  /** IDs seleccionados cuando scope === "selected" */
  selectedIds?: (string | number)[];
}

// Definición de columna mejorada
export interface ColumnDefinition<T> {
  key: keyof T;
  label: string;
  type?: ColumnType; // Tipo de dato de la columna
  isNumeric?: boolean;
  isSortable?: boolean;
  isFilterable?: boolean; // Si se puede filtrar esta columna
  isFixed?: boolean; // Si la columna es fija (no se mueve con scroll)
  /** Si la columna se exporta (p. ej. acciones con botones: false) */
  exportable?: boolean;
  width?: string | number; // Ancho de la columna
  minWidth?: string | number; // Ancho mínimo
  align?: "left" | "center" | "right"; // Alineación del contenido
  filter?: ColumnFilter; // Configuración del filtro
  render?: (value: any, row: T) => React.ReactNode;
  // Formato personalizado para tipos específicos
  format?: {
    dateFormat?: string; // Formato para fechas (ej: "DD/MM/YYYY")
    numberFormat?: {
      decimals?: number;
      prefix?: string; // ej: "$"
      suffix?: string; // ej: "%"
      thousandsSeparator?: string;
    };
  };
}

// Acción de la tabla
export interface TableAction {
  icon: React.ComponentType<{ className?: string }>;
  label: string;
  permission?: string | string[];
  onClick: (id: number | string) => void;
  variant?: "default" | "destructive" | "outline" | "secondary";
  showOnMobile?: boolean;
}

// Respuesta genérica de lista
export interface GenericListResponse<T> {
  message: string;
  data: T[];
  total: number;
}

// Parámetros de lista genéricos
export interface GenericListParams {
  Limite_inferior: number;
  Limite_Superior: number;
  Buscar?: string;
}

// Configuración de ordenamiento
export interface SortConfig {
  key: string;
  direction: "asc" | "desc";
}

// Filtros activos
export interface ActiveFilter {
  columnKey: string;
  type: FilterType;
  value: any;
  label?: string; // Para mostrar en chips
}

// Configuración de selección
export interface SelectionConfig {
  enabled: boolean; // Si está habilitada la selección
  mode?: "single" | "multiple"; // Modo de selección
  onSelectionChange?: (selectedIds: (string | number)[]) => void;
}

// Opciones de paginación
export const DEFAULT_PAGE_SIZE_OPTIONS = [10, 20, 30, 50, 100];

// Acción configurable para NoData
export interface NoDataAction {
  /** Texto del botón */
  label: string;
  /** Icono del botón (componente de lucide-react) */
  icon?: React.ComponentType<{ className?: string }>;
  /** Tipo de acción */
  type: "navigation" | "function";
  /** Si es navegación: ruta a donde redirigir */
  to?: string;
  /** Si es función: callback a ejecutar */
  onClick?: () => void | Promise<void>;
  /** Estilos personalizados para el botón */
  className?: string;
  /** Color del texto */
  textColor?: string;
  /** Variante del botón */
  variant?: "default" | "destructive" | "outline" | "secondary" | "ghost" | "link";
  /** Si se desactiva mientras se ejecuta (para evitar múltiples peticiones) */
  disableWhileExecuting?: boolean;
}

// Configuración de NoData
export interface NoDataConfig {
  /** Si se muestra el botón de acción */
  showAction?: boolean;
  /** Acción a ejecutar */
  action?: NoDataAction;
  /** Título personalizado */
  title?: string;
  /** Descripción personalizada */
  description?: string;
}

// Acción de tabla mejorada (para acciones encima del header)
export interface TableHeaderAction {
  /** ID único de la acción */
  id: string;
  /** Texto del botón (opcional si hay icono) */
  label?: string;
  /** Icono del botón (opcional si hay texto) */
  icon?: React.ComponentType<{ className?: string }>;
  /** Función a ejecutar */
  onClick: (selectedIds: (string | number)[]) => void | Promise<void>;
  /** Variante del botón */
  variant?: "default" | "destructive" | "outline" | "secondary" | "ghost" | "link";
  /** Estilos personalizados */
  className?: string;
  /** Color del texto */
  textColor?: string;
  /** Si se requiere selección (solo se ejecuta si hay elementos seleccionados) */
  requiresSelection?: boolean;
  /** Si se desactiva mientras se ejecuta */
  disableWhileExecuting?: boolean;
  /** Mensaje de tooltip */
  tooltip?: string;
  /** Si está deshabilitado */
  disabled?: boolean;
}

// Props del componente de tabla
export interface GenericDataTableProps<T> {
  // Datos
  columns: ColumnDefinition<T>[];
  data: T[];
  idField: keyof T;
  
  // Acciones
  actions?: TableAction[];
  
  // Estado de carga
  loading?: boolean;
  
  // Paginación
  totalItems: number;
  currentPage: number;
  pageSize: number;
  pageSizeOptions?: number[];
  onPageChange: (page: number) => void;
  onPageSizeChange: (size: number) => void;
  
  // Búsqueda global (solo al escribir; sin botón Buscar)
  searchQuery?: string;
  onSearch?: (query: string) => void;
  searchPlaceholder?: string;
  
  // Filtros por columna
  onFilterChange?: (filters: ActiveFilter[]) => void;
  activeFilters?: ActiveFilter[];
  
  // Ordenamiento
  onSortChange?: (sortConfig: SortConfig | null) => void;
  defaultSort?: SortConfig;
  
  // Selección
  selection?: SelectionConfig;
  selectedIds?: (string | number)[];
  
  // Columnas ocultables (persistencia por tableId)
  tableId?: string;
  hiddenColumns?: string[];
  onHiddenColumnsChange?: (keys: string[]) => void;
  
  // Exportación (modulable)
  exportConfig?: ExportConfig;
  
  // Utilidades
  onClearFilters?: () => void;
  onRefetch?: () => void;
  
  // UI
  pageTitle?: string;
  emptyStateType?: "no-data" | "no-results";
  showHeader?: boolean;
  showFooter?: boolean;
  stickyHeader?: boolean;
  maxHeight?: string | number;
  
  // Componentes encima del header
  headerActions?: React.ReactNode;
  
  // Acciones de tabla (encima del header, para acciones masivas)
  tableHeaderActions?: TableHeaderAction[];
  
  // Configuración de NoData
  noDataConfig?: NoDataConfig;
  
  // Personalización
  className?: string;
  rowClassName?: (row: T) => string;
  onRowClick?: (row: T) => void;
}
