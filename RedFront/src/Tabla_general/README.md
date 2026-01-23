# 📊 GenericDataTable - Documentación Completa

Componente de tabla genérica avanzado con funcionalidades completas para manejo de datos, filtros, selección, paginación, exportación y más.

## 📋 Tabla de Contenidos

1. [Características Principales](#características-principales)
2. [Instalación y Dependencias](#instalación-y-dependencias)
3. [Uso Básico](#uso-básico)
4. [Hook useGenericTableV2](#hook-usegenerictablev2)
5. [Definición de Columnas](#definición-de-columnas)
6. [Tipos de Columnas](#tipos-de-columnas)
7. [Filtros](#filtros)
8. [Selección de Filas](#selección-de-filas)
9. [Exportación](#exportación)
10. [Acciones](#acciones)
11. [Componentes Encima del Header](#componentes-encima-del-header)
12. [Estado Vacío (NoData)](#estado-vacío-nodata)
13. [Columnas Ocultables](#columnas-ocultables)
14. [Integración con API](#integración-con-api)
15. [Props Completas](#props-completas)
16. [Ejemplos Avanzados](#ejemplos-avanzados)

---

## ✨ Características Principales

- ✅ **Paginación** con tamaños personalizables
- ✅ **Búsqueda global** con debounce automático
- ✅ **Filtros por columna** (texto, número, fecha, rango de fechas, select, booleano)
- ✅ **Ordenamiento** por cualquier columna
- ✅ **Selección de filas** (individual o múltiple)
- ✅ **Columnas ocultables** con persistencia en localStorage
- ✅ **Exportación** a múltiples formatos (JSON, XML, CSV, TXT, Excel, PDF)
- ✅ **Skeleton loading** debajo de headers
- ✅ **Acciones de tabla** (botones masivos encima del header)
- ✅ **Componentes personalizados** encima del header
- ✅ **Estado vacío configurable** con acciones
- ✅ **Responsive** y accesible
- ✅ **TypeScript** completo

---

## 📦 Instalación y Dependencias

### Dependencias Requeridas

```json
{
  "react": "^19.1.0",
  "react-dom": "^19.1.0",
  "react-router-dom": "^7.6.1",
  "date-fns": "^4.1.0",
  "react-day-picker": "^9.x",
  "@radix-ui/react-popover": "^1.x",
  "xlsx": "^0.18.5",
  "jspdf": "^4.0.0",
  "jspdf-autotable": "^5.0.7",
  "lucide-react": "^0.511.0"
}
```

### Componentes UI Requeridos (shadcn/ui)

- `Button`
- `Card`, `CardHeader`, `CardContent`
- `Input`
- `Select`
- `Checkbox`
- `Badge`
- `Skeleton`
- `Dialog`
- `DropdownMenu`
- `Separator`
- `Table`
- `Calendar`
- `Popover`
- `Field`, `FieldLabel`

---

## 🚀 Uso Básico

### Importación

```typescript
import { GenericDataTable, useGenericTableV2 } from "@/assets/Components/Tabla_general";
import type { ColumnDefinition } from "@/assets/Components/Tabla_general";
```

### Ejemplo Mínimo

```typescript
import { useState } from "react";
import { GenericDataTable } from "@/assets/Components/Tabla_general";
import type { ColumnDefinition } from "@/assets/Components/Tabla_general";

interface Producto {
  id: number;
  nombre: string;
  precio: number;
}

const columns: ColumnDefinition<Producto>[] = [
  {
    key: "id",
    label: "ID",
    type: "number",
    width: 80,
  },
  {
    key: "nombre",
    label: "Nombre",
    type: "text",
  },
  {
    key: "precio",
    label: "Precio",
    type: "number",
    format: {
      numberFormat: {
        decimals: 2,
        prefix: "$",
      },
    },
  },
];

function MiComponente() {
  const [data] = useState<Producto[]>([
    { id: 1, nombre: "Producto 1", precio: 100 },
    { id: 2, nombre: "Producto 2", precio: 200 },
  ]);

  return (
    <GenericDataTable
      columns={columns}
      data={data}
      idField="id"
      totalItems={data.length}
      currentPage={1}
      pageSize={10}
      onPageChange={() => {}}
      onPageSizeChange={() => {}}
    />
  );
}
```

---

## 🎣 Hook useGenericTableV2

El hook `useGenericTableV2` gestiona el estado de la tabla y facilita la integración con APIs.

### Uso Básico

```typescript
import { useGenericTableV2 } from "@/assets/Components/Tabla_general";

const table = useGenericTableV2<Producto>({
  defaultPageSize: 30,
  defaultPage: 1,
  defaultSort: { key: "nombre", direction: "asc" },
  tableId: "productos", // Para persistencia de columnas ocultas
  onFetch: async (params) => {
    // params: { page, pageSize, search, filters, sort }
    const result = await fetchProductos(params);
    table.updateData(result.data, result.total);
  },
});
```

### Parámetros del Hook

| Parámetro | Tipo | Requerido | Descripción |
|-----------|------|-----------|-------------|
| `defaultPageSize` | `number` | ❌ | Tamaño de página por defecto (default: 30) |
| `defaultPage` | `number` | ❌ | Página inicial (default: 1) |
| `defaultSort` | `SortConfig` | ❌ | Ordenamiento inicial |
| `tableId` | `string` | ❌ | ID único para persistencia de columnas ocultas |
| `onFetch` | `(params) => Promise<void>` | ❌ | Función para obtener datos |

### Valores Retornados

```typescript
{
  // Estado
  data: T[];
  totalItems: number;
  currentPage: number;
  pageSize: number;
  searchQuery: string;
  debouncedSearch: string;
  activeFilters: ActiveFilter[];
  sortConfig: SortConfig | null;
  selectedIds: (string | number)[];
  hiddenColumns: string[];
  isLoading: boolean;

  // Handlers
  handlePageChange: (page: number) => void;
  handlePageSizeChange: (size: number) => void;
  handleSearch: (query: string) => void;
  handleFilterChange: (filters: ActiveFilter[]) => void;
  handleSortChange: (sort: SortConfig | null) => void;
  handleSelectionChange: (ids: (string | number)[]) => void;
  handleHiddenColumnsChange: (keys: string[]) => void;
  handleClearFilters: () => void;
  handleRefetch: () => void;
  refresh: () => void; // Alias de handleRefetch

  // Utilidades
  updateData: (data: T[], total: number) => void;
  fetchData: () => Promise<void>;
  reset: () => void;
}
```

### Ejemplo Completo con Hook

```typescript
import { useGenericTableV2 } from "@/assets/Components/Tabla_general";
import { GenericDataTable } from "@/assets/Components/Tabla_general";
import { productosService } from "./services/productos.service";

function PageProductos() {
  const table = useGenericTableV2<Producto>({
    defaultPageSize: 30,
    tableId: "productos",
    onFetch: async (params) => {
      try {
        const result = await productosService.getProductos({
          page: params.page,
          per_page: params.pageSize,
          search: params.search,
          // Enviar filtros y ordenamiento a la API
        });
        table.updateData(result.data, result.pagination.total);
      } catch (error) {
        console.error("Error:", error);
      }
    },
  });

  return (
    <GenericDataTable
      columns={columns}
      data={table.data}
      idField="id"
      totalItems={table.totalItems}
      currentPage={table.currentPage}
      pageSize={table.pageSize}
      onPageChange={table.handlePageChange}
      onPageSizeChange={table.handlePageSizeChange}
      searchQuery={table.searchQuery}
      onSearch={table.handleSearch}
      activeFilters={table.activeFilters}
      onFilterChange={table.handleFilterChange}
      onSortChange={table.handleSortChange}
      defaultSort={{ key: "nombre", direction: "asc" }}
      loading={table.isLoading}
      tableId="productos"
      hiddenColumns={table.hiddenColumns}
      onHiddenColumnsChange={table.handleHiddenColumnsChange}
      onRefetch={table.refresh}
    />
  );
}
```

---

## 📐 Definición de Columnas

### ColumnDefinition<T>

```typescript
interface ColumnDefinition<T> {
  key: keyof T;                    // Campo del objeto
  label: string;                    // Etiqueta de la columna
  type?: ColumnType;                // Tipo de dato
  isNumeric?: boolean;              // Si es numérico (alineación derecha)
  isSortable?: boolean;             // Si se puede ordenar (default: true)
  isFilterable?: boolean;           // Si se puede filtrar
  isFixed?: boolean;                // Columna fija (no se mueve con scroll)
  exportable?: boolean;              // Si se exporta (default: true)
  width?: string | number;          // Ancho fijo
  minWidth?: string | number;       // Ancho mínimo
  align?: "left" | "center" | "right"; // Alineación
  filter?: ColumnFilter;            // Configuración del filtro
  render?: (value: any, row: T) => React.ReactNode; // Render personalizado
  format?: {
    dateFormat?: string;            // Formato de fecha (date-fns)
    numberFormat?: {
      decimals?: number;
      prefix?: string;
      suffix?: string;
      thousandsSeparator?: string;
    };
  };
}
```

---

## 📊 Tipos de Columnas

### 1. Texto (`text`)

```typescript
{
  key: "nombre",
  label: "Nombre",
  type: "text",
  isFilterable: true,
  filter: {
    type: "text",
    placeholder: "Buscar nombre...",
  },
}
```

### 2. Número (`number`)

```typescript
{
  key: "precio",
  label: "Precio",
  type: "number",
  isNumeric: true,
  align: "right",
  format: {
    numberFormat: {
      decimals: 2,
      prefix: "$",
      thousandsSeparator: ",",
    },
  },
  isFilterable: true,
  filter: {
    type: "number",
    placeholder: "Precio mínimo...",
  },
}
```

### 3. Fecha (`date`)

```typescript
{
  key: "fecha_creacion",
  label: "Fecha Creación",
  type: "date",
  format: {
    dateFormat: "dd/MM/yyyy",
  },
  isFilterable: true,
  filter: {
    type: "date",
  },
}
```

### 4. Fecha y Hora (`datetime`)

```typescript
{
  key: "fecha_actualizacion",
  label: "Última Actualización",
  type: "datetime",
  format: {
    dateFormat: "dd/MM/yyyy HH:mm",
  },
}
```

### 5. Hora (`time`)

```typescript
{
  key: "hora",
  label: "Hora",
  type: "time",
}
```

### 6. Booleano (`boolean`)

```typescript
{
  key: "activo",
  label: "Activo",
  type: "boolean",
  isFilterable: true,
  filter: {
    type: "boolean",
  },
}
```

### 7. Imagen (`image`)

```typescript
{
  key: "imagen",
  label: "Imagen",
  type: "image",
  isSortable: false,
}
```

### 8. Personalizado (`custom`)

```typescript
{
  key: "estado",
  label: "Estado",
  type: "custom",
  render: (value, row) => (
    <Badge variant={value === "activo" ? "default" : "secondary"}>
      {value}
    </Badge>
  ),
}
```

### 9. Columna Fija

```typescript
{
  key: "id",
  label: "ID",
  type: "number",
  isFixed: true, // No se mueve con scroll horizontal
  width: 80,
  align: "center",
}
```

---

## 🔍 Filtros

### Tipos de Filtros Disponibles

#### 1. Filtro de Texto

```typescript
{
  key: "nombre",
  label: "Nombre",
  type: "text",
  isFilterable: true,
  filter: {
    type: "text",
    placeholder: "Buscar nombre...",
  },
}
```

#### 2. Filtro Numérico

```typescript
{
  key: "precio",
  label: "Precio",
  type: "number",
  isFilterable: true,
  filter: {
    type: "number",
    placeholder: "0",
  },
}
```

#### 3. Filtro de Fecha

```typescript
{
  key: "fecha",
  label: "Fecha",
  type: "date",
  isFilterable: true,
  filter: {
    type: "date",
  },
}
```

#### 4. Filtro de Rango de Fechas (DateRangePicker)

```typescript
{
  key: "fecha_creacion",
  label: "Fecha Creación",
  type: "date",
  isFilterable: true,
  filter: {
    type: "dateRange", // Usa Calendar con modo range
  },
  format: {
    dateFormat: "dd/MM/yyyy",
  },
}
```

**Características:**
- Usa componente `Calendar` de shadcn/ui con modo `range`
- Muestra 2 meses lado a lado
- Selección visual del rango
- Formato: `dd/MM/yyyy - dd/MM/yyyy`

#### 5. Filtro Select (Dropdown)

```typescript
{
  key: "estado",
  label: "Estado",
  type: "text",
  isFilterable: true,
  filter: {
    type: "select",
    options: [
      { label: "Activo", value: "activo" },
      { label: "Inactivo", value: "inactivo" },
      { label: "Pendiente", value: "pendiente" },
    ],
  },
}
```

#### 6. Filtro Booleano

```typescript
{
  key: "activo",
  label: "Activo",
  type: "boolean",
  isFilterable: true,
  filter: {
    type: "boolean",
  },
}
```

### Filtros Activos

Los filtros activos se muestran como chips debajo del header. Cada chip tiene un botón para eliminarlo individualmente.

```typescript
// Los filtros activos se pasan como prop
activeFilters={table.activeFilters}
onFilterChange={table.handleFilterChange}
```

---

## ☑️ Selección de Filas

### Configuración Básica

```typescript
<GenericDataTable
  // ...
  selection={{
    enabled: true,
    mode: "multiple", // o "single"
    onSelectionChange: (selectedIds) => {
      console.log("IDs seleccionados:", selectedIds);
    },
  }}
  selectedIds={table.selectedIds}
/>
```

### Modos de Selección

- **`multiple`**: Permite seleccionar múltiples filas (checkboxes)
- **`single`**: Solo permite seleccionar una fila a la vez

### Funcionalidades

- Checkbox en la primera columna
- "Seleccionar todos" en el header
- Contador de elementos seleccionados
- Selección por clic en la fila (si no hay `onRowClick`)
- Deseleccionar todos

### Uso con Acciones Masivas

```typescript
const table = useGenericTableV2<Producto>({ /* ... */ });

<GenericDataTable
  // ...
  selection={{
    enabled: true,
    mode: "multiple",
    onSelectionChange: table.handleSelectionChange,
  }}
  selectedIds={table.selectedIds}
  tableHeaderActions={[
    {
      id: "delete-selected",
      label: "Eliminar seleccionados",
      icon: Trash2,
      variant: "destructive",
      requiresSelection: true, // Solo se ejecuta si hay selección
      disableWhileExecuting: true,
      onClick: async (selectedIds) => {
        await eliminarProductos(selectedIds);
        table.refresh();
      },
    },
  ]}
/>
```

---

## 📤 Exportación

### Configuración Básica

```typescript
<GenericDataTable
  // ...
  exportConfig={{
    modeExport: true,
    exportTypes: ["json", "csv", "msexcel", "pdf"], // Formatos habilitados
  }}
/>
```

### Formatos Disponibles

- **`json`**: JSON formateado
- **`xml`**: XML estructurado
- **`csv`**: CSV con encoding UTF-8
- **`txt`**: Texto plano tabulado
- **`msexcel`**: Archivo Excel (.xlsx)
- **`pdf`**: PDF con tabla formateada

### Modos de Exportación

Al hacer clic en un formato, se abre un modal con opciones:

1. **Solo datos visibles en la tabla**: Exporta la página actual
2. **Solo seleccionados**: Exporta solo las filas seleccionadas (requiere selección)
3. **Todos los datos**: Exporta todos los datos desde la API (requiere `onExportAll`)

### Exportación de "Todos los Datos"

```typescript
<GenericDataTable
  // ...
  exportConfig={{
    modeExport: true,
    exportTypes: ["json", "csv", "msexcel", "pdf"],
    onExportAll: async (params) => {
      // params: { format, scope, columns, selectedIds? }
      const response = await fetch("/api/productos/export", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          format: params.format,
          modeExport: true,
          exportTypes: ["json", "csv", "msexcel", "pdf"],
          columns: params.columns,
        }),
      });
      return response.json(); // Array de objetos
    },
  }}
/>
```

### Columnas Exportables

Por defecto, todas las columnas se exportan excepto:
- Columnas con `exportable: false`
- Columna de "Acciones" (siempre excluida)

```typescript
{
  key: "acciones",
  label: "Acciones",
  type: "custom",
  exportable: false, // No se exporta
  render: (value, row) => <ActionsButtons />,
}
```

### Estructura de la API para Exportación

```typescript
// POST /api/productos/export
{
  "format": "csv" | "json" | "xml" | "txt" | "msexcel" | "pdf",
  "modeExport": true,
  "exportTypes": ["csv", "json", "msexcel"],
  "columns": [
    { "key": "id", "label": "ID" },
    { "key": "nombre", "label": "Nombre" },
  ],
  "filters": [...], // Filtros activos
  "sort": { "key": "nombre", "direction": "asc" },
  "search": "texto de búsqueda"
}

// Respuesta: Array de objetos
[
  { "ID": 1, "Nombre": "Producto 1" },
  { "ID": 2, "Nombre": "Producto 2" },
]
```

---

## 🎯 Acciones

### Acciones por Fila (TableAction)

Las acciones se muestran en la última columna de cada fila.

```typescript
import { Eye, Edit, Trash } from "lucide-react";

const actions: TableAction[] = [
  {
    icon: Eye,
    label: "Ver Detalles",
    onClick: (id) => {
      console.log("Ver", id);
    },
    variant: "outline",
    showOnMobile: true, // Visible en móvil
  },
  {
    icon: Edit,
    label: "Editar",
    onClick: (id) => {
      console.log("Editar", id);
    },
    variant: "default",
    showOnMobile: true,
    permission: "productos.editar", // Requiere permiso
  },
  {
    icon: Trash,
    label: "Eliminar",
    onClick: (id) => {
      console.log("Eliminar", id);
    },
    variant: "destructive",
    permission: "productos.eliminar",
  },
];

<GenericDataTable
  // ...
  actions={actions}
/>
```

**Nota:** Si `actions` está vacío o es `undefined`, no se muestra ningún botón de acciones.

### Propiedades de TableAction

| Propiedad | Tipo | Descripción |
|-----------|------|-------------|
| `icon` | `React.ComponentType` | Componente de icono (lucide-react) |
| `label` | `string` | Texto de la acción |
| `onClick` | `(id: string\|number) => void` | Función a ejecutar |
| `variant` | `"default"\|"destructive"\|"outline"\|"secondary"` | Estilo del botón |
| `showOnMobile` | `boolean` | Si se muestra en móvil (default: false) |
| `permission` | `string\|string[]` | Permisos requeridos |

---

## 🎨 Componentes Encima del Header

### headerActions (ReactNode)

Permite añadir componentes personalizados encima del CardHeader.

```typescript
<GenericDataTable
  // ...
  headerActions={
    <div className="flex items-center gap-2">
      <Badge variant="default">Total: {totalItems}</Badge>
      <Button onClick={handleCustomAction}>
        Acción Personalizada
      </Button>
    </div>
  }
/>
```

### tableHeaderActions (Acciones Masivas)

Botones de acción que trabajan con filas seleccionadas.

```typescript
import { Trash2, Edit, Download } from "lucide-react";

<GenericDataTable
  // ...
  tableHeaderActions={[
    {
      id: "delete",
      label: "Eliminar seleccionados",
      icon: Trash2,
      variant: "destructive",
      requiresSelection: true, // Solo si hay selección
      disableWhileExecuting: true, // Desactiva mientras ejecuta
      onClick: async (selectedIds) => {
        await eliminarProductos(selectedIds);
        table.refresh();
      },
    },
    {
      id: "update",
      label: "Actualizar masivo",
      icon: Edit,
      variant: "default",
      requiresSelection: true,
      disableWhileExecuting: true,
      onClick: async (selectedIds) => {
        // Abrir modal de actualización masiva
        setSelectedIds(selectedIds);
        setIsUpdateModalOpen(true);
      },
    },
    {
      id: "export-selected",
      label: "Exportar seleccionados",
      icon: Download,
      variant: "outline",
      requiresSelection: true,
      onClick: async (selectedIds) => {
        // Lógica de exportación
      },
    },
  ]}
/>
```

### Propiedades de TableHeaderAction

| Propiedad | Tipo | Descripción |
|-----------|------|-------------|
| `id` | `string` | ID único de la acción |
| `label` | `string` | Texto del botón |
| `icon` | `React.ComponentType` | Icono (opcional) |
| `onClick` | `(selectedIds) => void\|Promise<void>` | Función que recibe IDs seleccionados |
| `variant` | `ButtonVariant` | Variante del botón |
| `className` | `string` | Estilos personalizados |
| `textColor` | `string` | Color del texto |
| `requiresSelection` | `boolean` | Solo se ejecuta si hay selección |
| `disableWhileExecuting` | `boolean` | Se desactiva mientras ejecuta |
| `tooltip` | `string` | Mensaje de tooltip |
| `disabled` | `boolean` | Deshabilitado permanentemente |

**Nota:** Si hay `headerActions` o `tableHeaderActions`, se muestra un separador automático entre ellos y el CardHeader.

---

## 📭 Estado Vacío (NoData)

### Configuración Básica

```typescript
<GenericDataTable
  // ...
  noDataConfig={{
    showAction: true,
    action: {
      label: "Crear nuevo producto",
      icon: Plus,
      type: "navigation",
      to: "/productos/crear",
      variant: "default",
    },
    title: "No hay productos",
    description: "Comienza agregando tu primer producto al sistema",
  }}
/>
```

### Acción de Navegación

```typescript
noDataConfig={{
  showAction: true,
  action: {
    label: "Ir a crear",
    icon: Plus,
    type: "navigation",
    to: "/productos/crear",
    variant: "default",
    textColor: "#fff",
  },
}}
```

### Acción de Función

```typescript
noDataConfig={{
  showAction: true,
  action: {
    label: "Recargar datos",
    icon: RefreshCw,
    type: "function",
    onClick: async () => {
      await refetch();
    },
    disableWhileExecuting: true,
    variant: "outline",
  },
}}
```

### Propiedades de NoDataConfig

| Propiedad | Tipo | Descripción |
|-----------|------|-------------|
| `showAction` | `boolean` | Si se muestra el botón |
| `action` | `NoDataAction` | Configuración de la acción |
| `title` | `string` | Título personalizado |
| `description` | `string` | Descripción personalizada |

### Propiedades de NoDataAction

| Propiedad | Tipo | Descripción |
|-----------|------|-------------|
| `label` | `string` | Texto del botón |
| `icon` | `React.ComponentType` | Icono (opcional) |
| `type` | `"navigation"\|"function"` | Tipo de acción |
| `to` | `string` | Ruta (si type === "navigation") |
| `onClick` | `() => void\|Promise<void>` | Función (si type === "function") |
| `variant` | `ButtonVariant` | Variante del botón |
| `className` | `string` | Estilos personalizados |
| `textColor` | `string` | Color del texto |
| `disableWhileExecuting` | `boolean` | Desactiva mientras ejecuta |

---

## 👁️ Columnas Ocultables

### Configuración

```typescript
const table = useGenericTableV2<Producto>({
  tableId: "productos", // Requerido para persistencia
  // ...
});

<GenericDataTable
  // ...
  tableId="productos"
  hiddenColumns={table.hiddenColumns}
  onHiddenColumnsChange={table.handleHiddenColumnsChange}
/>
```

### Funcionalidades

- Botón "Columnas" en el header (icono `Columns3`)
- Dropdown con checkboxes por columna
- Persistencia en localStorage (clave: `tabla_hidden_${tableId}`)
- Las columnas ocultas se mantienen al paginar
- Por defecto, todas las columnas son visibles

---

## 🔌 Integración con API

### Estructura de la API

El componente está diseñado para trabajar con APIs RESTful que soporten:

1. **Paginación**
2. **Búsqueda**
3. **Filtros**
4. **Ordenamiento**
5. **Exportación** (opcional)

### Parámetros de la API

#### GET Request

```typescript
// Ejemplo: GET /api/productos?page=1&per_page=30&search=texto&sort=nombre&direction=asc
{
  page: number;              // Página actual
  per_page: number;          // Tamaño de página
  search?: string;           // Búsqueda global
  sort?: string;             // Campo de ordenamiento
  direction?: "asc" | "desc"; // Dirección
  
  // Filtros (uno por columna)
  filter_nombre?: string;
  filter_precio?: number;
  filter_fecha_creacion_start?: string; // Para dateRange
  filter_fecha_creacion_end?: string;
  filter_estado?: string;
  filter_activo?: boolean;
}
```

#### Respuesta de la API

```typescript
{
  data: T[];                 // Array de datos
  pagination: {
    total: number;           // Total de registros
    per_page: number;
    current_page: number;
    last_page: number;
  };
  message?: string;
}
```

### Ejemplo de Servicio

```typescript
// services/productos.service.ts
import axios from "axios";

export const productosService = {
  async getProductos(params: {
    page: number;
    per_page: number;
    search?: string;
    sort?: string;
    direction?: "asc" | "desc";
    filters?: Record<string, any>;
  }) {
    const queryParams = new URLSearchParams({
      page: params.page.toString(),
      per_page: params.per_page.toString(),
    });

    if (params.search) {
      queryParams.append("search", params.search);
    }

    if (params.sort) {
      queryParams.append("sort", params.sort);
      queryParams.append("direction", params.direction || "asc");
    }

    // Agregar filtros
    if (params.filters) {
      Object.entries(params.filters).forEach(([key, value]) => {
        if (value !== null && value !== undefined && value !== "") {
          if (typeof value === "object" && "start" in value) {
            // dateRange
            queryParams.append(`filter_${key}_start`, value.start);
            queryParams.append(`filter_${key}_end`, value.end);
          } else {
            queryParams.append(`filter_${key}`, String(value));
          }
        }
      });
    }

    const response = await axios.get(`/api/productos?${queryParams}`);
    return response.data;
  },
};
```

### Uso con useGenericTableV2

```typescript
const table = useGenericTableV2<Producto>({
  tableId: "productos",
  onFetch: async (params) => {
    try {
      // Convertir ActiveFilter[] a formato de API
      const filters: Record<string, any> = {};
      params.filters.forEach((filter) => {
        if (filter.type === "dateRange") {
          filters[filter.columnKey] = filter.value;
        } else {
          filters[filter.columnKey] = filter.value;
        }
      });

      const result = await productosService.getProductos({
        page: params.page,
        per_page: params.pageSize,
        search: params.search,
        sort: params.sort?.key,
        direction: params.sort?.direction,
        filters,
      });

      table.updateData(result.data, result.pagination.total);
    } catch (error) {
      console.error("Error:", error);
    }
  },
});
```

### API para Exportación "Todos los Datos"

```typescript
// POST /api/productos/export
{
  format: "csv" | "json" | "xml" | "txt" | "msexcel" | "pdf",
  modeExport: true,
  exportTypes: ["csv", "json", "msexcel"],
  columns: [
    { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre" },
  ],
  filters?: ActiveFilter[],
  sort?: SortConfig,
  search?: string,
}

// Respuesta: Array de objetos planos
[
  { "ID": 1, "Nombre": "Producto 1", "Precio": 100 },
  { "ID": 2, "Nombre": "Producto 2", "Precio": 200 },
]
```

---

## 📋 Props Completas

### GenericDataTableProps<T>

| Prop | Tipo | Requerido | Default | Descripción |
|------|------|-----------|---------|-------------|
| **Datos** |
| `columns` | `ColumnDefinition<T>[]` | ✅ | - | Definición de columnas |
| `data` | `T[]` | ✅ | - | Datos a mostrar |
| `idField` | `keyof T` | ✅ | - | Campo que se usa como ID |
| **Paginación** |
| `totalItems` | `number` | ✅ | - | Total de items |
| `currentPage` | `number` | ✅ | - | Página actual |
| `pageSize` | `number` | ✅ | - | Tamaño de página |
| `onPageChange` | `(page: number) => void` | ✅ | - | Callback al cambiar página |
| `onPageSizeChange` | `(size: number) => void` | ✅ | - | Callback al cambiar tamaño |
| `pageSizeOptions` | `number[]` | ❌ | `[10,20,30,50,100]` | Opciones de tamaño |
| **Estado** |
| `loading` | `boolean` | ❌ | `false` | Estado de carga |
| **Búsqueda** |
| `searchQuery` | `string` | ❌ | `""` | Query de búsqueda |
| `onSearch` | `(query: string) => void` | ❌ | - | Callback de búsqueda |
| `searchPlaceholder` | `string` | ❌ | `"Buscar..."` | Placeholder |
| **Filtros** |
| `onFilterChange` | `(filters: ActiveFilter[]) => void` | ❌ | - | Callback al cambiar filtros |
| `activeFilters` | `ActiveFilter[]` | ❌ | `[]` | Filtros activos |
| **Ordenamiento** |
| `onSortChange` | `(sort: SortConfig\|null) => void` | ❌ | - | Callback al ordenar |
| `defaultSort` | `SortConfig` | ❌ | - | Ordenamiento inicial |
| **Selección** |
| `selection` | `SelectionConfig` | ❌ | - | Configuración de selección |
| `selectedIds` | `(string\|number)[]` | ❌ | `[]` | IDs seleccionados |
| **Columnas Ocultables** |
| `tableId` | `string` | ❌ | - | ID para persistencia |
| `hiddenColumns` | `string[]` | ❌ | `[]` | Columnas ocultas |
| `onHiddenColumnsChange` | `(keys: string[]) => void` | ❌ | - | Callback al cambiar |
| **Exportación** |
| `exportConfig` | `ExportConfig` | ❌ | - | Configuración de exportación |
| **Acciones** |
| `actions` | `TableAction[]` | ❌ | `[]` | Acciones por fila |
| **Componentes Encima del Header** |
| `headerActions` | `React.ReactNode` | ❌ | - | Componentes personalizados |
| `tableHeaderActions` | `TableHeaderAction[]` | ❌ | `[]` | Acciones masivas |
| **NoData** |
| `noDataConfig` | `NoDataConfig` | ❌ | - | Configuración de estado vacío |
| **Utilidades** |
| `onClearFilters` | `() => void` | ❌ | - | Callback al limpiar filtros |
| `onRefetch` | `() => void` | ❌ | - | Callback para recargar |
| **UI** |
| `pageTitle` | `string` | ❌ | - | Título de la página |
| `showHeader` | `boolean` | ❌ | `true` | Mostrar header |
| `showFooter` | `boolean` | ❌ | `true` | Mostrar footer |
| `stickyHeader` | `boolean` | ❌ | `false` | Header fijo |
| `maxHeight` | `string\|number` | ❌ | - | Altura máxima |
| `className` | `string` | ❌ | `""` | Clase CSS adicional |
| `rowClassName` | `(row: T) => string` | ❌ | - | Clase CSS por fila |
| `onRowClick` | `(row: T) => void` | ❌ | - | Callback al hacer clic en fila |

---

## 💡 Ejemplos Avanzados

### Ejemplo Completo con Todas las Funcionalidades

```typescript
import { useState } from "react";
import { useGenericTableV2, GenericDataTable } from "@/assets/Components/Tabla_general";
import type { ColumnDefinition, TableHeaderAction } from "@/assets/Components/Tabla_general";
import { Eye, Edit, Trash, Plus, Trash2, Download } from "lucide-react";
import { productosService } from "./services/productos.service";

interface Producto {
  id: number;
  codigo: string;
  nombre: string;
  descripcion: string;
  precio: number;
  stock: number;
  categoria: string;
  activo: boolean;
  fecha_creacion: string;
  imagen: string;
}

export default function PageProductos() {
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);

  const table = useGenericTableV2<Producto>({
    defaultPageSize: 30,
    defaultPage: 1,
    defaultSort: { key: "nombre", direction: "asc" },
    tableId: "productos",
    onFetch: async (params) => {
      try {
        // Convertir filtros
        const filters: Record<string, any> = {};
        params.filters.forEach((filter) => {
          if (filter.type === "dateRange") {
            filters[`${filter.columnKey}_start`] = filter.value.start;
            filters[`${filter.columnKey}_end`] = filter.value.end;
          } else {
            filters[filter.columnKey] = filter.value;
          }
        });

        const result = await productosService.getProductos({
          page: params.page,
          per_page: params.pageSize,
          search: params.search,
          sort: params.sort?.key,
          direction: params.sort?.direction,
          filters,
        });

        table.updateData(result.data, result.pagination.total);
      } catch (error) {
        console.error("Error:", error);
      }
    },
  });

  const columns: ColumnDefinition<Producto>[] = [
    {
      key: "id",
      label: "ID",
      type: "number",
      isFixed: true,
      width: 80,
      align: "center",
    },
    {
      key: "codigo",
      label: "Código",
      type: "text",
      isFilterable: true,
      filter: {
        type: "text",
        placeholder: "Buscar código...",
      },
      width: 120,
    },
    {
      key: "nombre",
      label: "Nombre",
      type: "text",
      isFilterable: true,
      filter: {
        type: "text",
        placeholder: "Buscar nombre...",
      },
      minWidth: 200,
    },
    {
      key: "precio",
      label: "Precio",
      type: "number",
      isNumeric: true,
      align: "right",
      isFilterable: true,
      filter: {
        type: "number",
      },
      format: {
        numberFormat: {
          decimals: 2,
          prefix: "$",
          thousandsSeparator: ",",
        },
      },
    },
    {
      key: "stock",
      label: "Stock",
      type: "number",
      isNumeric: true,
      align: "right",
    },
    {
      key: "categoria",
      label: "Categoría",
      type: "text",
      isFilterable: true,
      filter: {
        type: "select",
        options: [
          { label: "Electrónica", value: "electronica" },
          { label: "Ropa", value: "ropa" },
          { label: "Hogar", value: "hogar" },
        ],
      },
    },
    {
      key: "activo",
      label: "Activo",
      type: "boolean",
      isFilterable: true,
      filter: {
        type: "boolean",
      },
    },
    {
      key: "fecha_creacion",
      label: "Fecha Creación",
      type: "date",
      isFilterable: true,
      filter: {
        type: "dateRange",
      },
      format: {
        dateFormat: "dd/MM/yyyy",
      },
    },
    {
      key: "imagen",
      label: "Imagen",
      type: "image",
      isSortable: false,
      exportable: false,
    },
  ];

  const actions = [
    {
      icon: Eye,
      label: "Ver",
      onClick: (id) => console.log("Ver", id),
      variant: "outline" as const,
      showOnMobile: true,
    },
    {
      icon: Edit,
      label: "Editar",
      onClick: (id) => console.log("Editar", id),
      variant: "default" as const,
      showOnMobile: true,
      permission: "productos.editar",
    },
    {
      icon: Trash,
      label: "Eliminar",
      onClick: (id) => console.log("Eliminar", id),
      variant: "destructive" as const,
      permission: "productos.eliminar",
    },
  ];

  const tableHeaderActions: TableHeaderAction[] = [
    {
      id: "delete-selected",
      label: "Eliminar seleccionados",
      icon: Trash2,
      variant: "destructive",
      requiresSelection: true,
      disableWhileExecuting: true,
      onClick: async (selectedIds) => {
        await productosService.eliminarMasivo(selectedIds);
        table.refresh();
      },
    },
    {
      id: "export-selected",
      label: "Exportar seleccionados",
      icon: Download,
      variant: "outline",
      requiresSelection: true,
      onClick: async (selectedIds) => {
        // Lógica de exportación
      },
    },
  ];

  return (
    <div className="container mx-auto py-6">
      <GenericDataTable
        columns={columns}
        data={table.data}
        idField="id"
        totalItems={table.totalItems}
        currentPage={table.currentPage}
        pageSize={table.pageSize}
        pageSizeOptions={[10, 20, 30, 50, 100]}
        onPageChange={table.handlePageChange}
        onPageSizeChange={table.handlePageSizeChange}
        searchQuery={table.searchQuery}
        onSearch={table.handleSearch}
        searchPlaceholder="Buscar productos por código, nombre..."
        activeFilters={table.activeFilters}
        onFilterChange={table.handleFilterChange}
        onSortChange={table.handleSortChange}
        defaultSort={{ key: "nombre", direction: "asc" }}
        selection={{
          enabled: true,
          mode: "multiple",
          onSelectionChange: table.handleSelectionChange,
        }}
        selectedIds={table.selectedIds}
        actions={actions}
        loading={table.isLoading}
        stickyHeader={true}
        maxHeight="calc(100vh - 300px)"
        onRefetch={table.refresh}
        onClearFilters={table.handleClearFilters}
        tableId="productos"
        hiddenColumns={table.hiddenColumns}
        onHiddenColumnsChange={table.handleHiddenColumnsChange}
        exportConfig={{
          modeExport: true,
          exportTypes: ["json", "xml", "csv", "txt", "msexcel", "pdf"],
          onExportAll: async (params) => {
            const result = await productosService.exportarTodos(params);
            return result.data;
          },
        }}
        headerActions={
          <div className="flex items-center gap-2">
            <Badge variant="default">Total: {table.totalItems}</Badge>
          </div>
        }
        tableHeaderActions={tableHeaderActions}
        noDataConfig={{
          showAction: true,
          action: {
            label: "Crear nuevo producto",
            icon: Plus,
            type: "navigation",
            to: "/productos/crear",
            variant: "default",
          },
          title: "No hay productos",
          description: "Comienza agregando tu primer producto al sistema",
        }}
        pageTitle="Productos"
        className="shadow-xl"
      />
    </div>
  );
}
```

---

## 🎨 Personalización

### Estilos Personalizados

```typescript
<GenericDataTable
  // ...
  className="shadow-xl border-2"
  rowClassName={(row) => 
    row.activo ? "bg-green-50" : "bg-red-50"
  }
/>
```

### Callbacks Adicionales

```typescript
<GenericDataTable
  // ...
  onRowClick={(row) => {
    console.log("Fila clickeada:", row);
    // Navegar a detalles, abrir modal, etc.
  }}
/>
```

---

## 🔧 Troubleshooting

### El botón de acciones no aparece

**Causa:** `actions` está vacío o es `undefined`.

**Solución:** Asegúrate de pasar un array con al menos una acción, o no pases la prop si no necesitas acciones.

### Las columnas ocultas no se persisten

**Causa:** No se pasó `tableId` o `onHiddenColumnsChange`.

**Solución:**
```typescript
const table = useGenericTableV2({ tableId: "mi-tabla" });
// ...
tableId="mi-tabla"
hiddenColumns={table.hiddenColumns}
onHiddenColumnsChange={table.handleHiddenColumnsChange}
```

### El modal de exportación bloquea la pantalla

**Causa:** Problema con el overlay del Dialog.

**Solución:** Ya está corregido en la versión actual. El modal limpia correctamente el `pointer-events` del body al cerrarse.

### El DateRangePicker no funciona

**Causa:** Faltan dependencias o componentes.

**Solución:** Asegúrate de tener instalado `react-day-picker` y los componentes `Calendar`, `Popover`, `Field`.

---

## 📚 Referencias

- [shadcn/ui Documentation](https://ui.shadcn.com/)
- [date-fns Documentation](https://date-fns.org/)
- [react-day-picker Documentation](https://react-day-picker.js.org/)
- [SheetJS (xlsx) Documentation](https://docs.sheetjs.com/)
- [jsPDF Documentation](https://github.com/parallax/jsPDF)

---

## 📝 Notas Importantes

1. **Skeleton Loading**: El skeleton muestra exactamente `pageSize` filas, no un número fijo.
2. **Búsqueda**: Se ejecuta automáticamente mientras escribes (debounce de 500ms). No hay botón "Buscar".
3. **Acciones Vacías**: Si `actions` está vacío, no se muestra ningún botón ni columna de acciones.
4. **Exportación**: Solo se exportan columnas con `exportable !== false`. La columna de acciones nunca se exporta.
5. **Persistencia**: Las columnas ocultas se guardan en `localStorage` con la clave `tabla_hidden_${tableId}`.
6. **Refresh**: Usa `table.refresh()` o `table.handleRefetch()` después de insertar/actualizar/eliminar para actualizar los datos.

---

## 🆘 Soporte

Para más información o problemas, consultar:
- Documentación de shadcn/ui
- Documentación de date-fns
- Documentación de react-day-picker
