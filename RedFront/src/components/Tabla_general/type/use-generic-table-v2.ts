import { useState, useCallback, useEffect } from "react";
import type { ActiveFilter, SortConfig } from "./generic-table";

const HIDDEN_COLUMNS_KEY = "tabla_hidden";

interface UseGenericTableOptions {
  defaultPageSize?: number;
  defaultPage?: number;
  defaultSort?: SortConfig;
  tableId?: string;
  onFetch?: (params: FetchParams) => Promise<void>;
}

interface FetchParams {
  page: number;
  pageSize: number;
  search: string;
  filters: ActiveFilter[];
  sort: SortConfig | null;
}

export function useGenericTableV2<T>(options: UseGenericTableOptions = {}) {
  const {
    defaultPageSize = 30,
    defaultPage = 1,
    defaultSort,
    tableId,
    onFetch,
  } = options;

  const storageKey = tableId ? `${HIDDEN_COLUMNS_KEY}_${tableId}` : null;

  // Estado de paginación
  const [currentPage, setCurrentPage] = useState(defaultPage);
  const [pageSize, setPageSize] = useState(defaultPageSize);
  const [totalItems, setTotalItems] = useState(0);

  // Estado de búsqueda
  const [searchQuery, setSearchQuery] = useState("");
  const [debouncedSearch, setDebouncedSearch] = useState("");

  // Estado de filtros
  const [activeFilters, setActiveFilters] = useState<ActiveFilter[]>([]);

  // Estado de ordenamiento
  const [sortConfig, setSortConfig] = useState<SortConfig | null>(
    defaultSort || null
  );

  // Estado de selección
  const [selectedIds, setSelectedIds] = useState<(string | number)[]>([]);

  // Columnas ocultas (persistidas por tableId; se mantienen al paginar)
  const [hiddenColumns, setHiddenColumns] = useState<string[]>([]);

  // Estado de carga
  const [isLoading, setIsLoading] = useState(false);

  // Datos
  const [data, setData] = useState<T[]>([]);

  useEffect(() => {
    if (!storageKey || typeof window === "undefined") return;
    try {
      const raw = localStorage.getItem(storageKey);
      setHiddenColumns(raw ? JSON.parse(raw) : []);
    } catch {
      /* ignore */
    }
  }, [storageKey]);

  // Debounce para búsqueda
  useEffect(() => {
    const timer = setTimeout(() => {
      setDebouncedSearch(searchQuery);
    }, 500);

    return () => clearTimeout(timer);
  }, [searchQuery]);

  // Fetch automático cuando cambian los parámetros
  useEffect(() => {
    if (onFetch) {
      fetchData();
    }
  }, [currentPage, pageSize, debouncedSearch, activeFilters, sortConfig]);

  // Función para hacer fetch
  const fetchData = useCallback(async () => {
    if (!onFetch) return;

    setIsLoading(true);
    try {
      await onFetch({
        page: currentPage,
        pageSize,
        search: debouncedSearch,
        filters: activeFilters,
        sort: sortConfig,
      });
    } catch (error) {
      console.error("Error fetching data:", error);
    } finally {
      setIsLoading(false);
    }
  }, [currentPage, pageSize, debouncedSearch, activeFilters, sortConfig, onFetch]);

  // Handlers
  const handlePageChange = useCallback((page: number) => {
    setCurrentPage(page);
  }, []);

  const handlePageSizeChange = useCallback((size: number) => {
    setPageSize(size);
    setCurrentPage(1); // Reset a primera página
  }, []);

  const handleSearch = useCallback((query: string) => {
    setSearchQuery(query);
    setCurrentPage(1); // Reset a primera página
  }, []);

  const handleSearchClick = useCallback(() => {
    setDebouncedSearch(searchQuery);
    setCurrentPage(1);
  }, [searchQuery]);

  const handleFilterChange = useCallback((filters: ActiveFilter[]) => {
    setActiveFilters(filters);
    setCurrentPage(1); // Reset a primera página
  }, []);

  const handleSortChange = useCallback((sort: SortConfig | null) => {
    setSortConfig(sort);
  }, []);

  const handleSelectionChange = useCallback((ids: (string | number)[]) => {
    setSelectedIds(ids);
  }, []);

  const handleClearFilters = useCallback(() => {
    setSearchQuery("");
    setDebouncedSearch("");
    setActiveFilters([]);
    setCurrentPage(1);
  }, []);

  const handleRefetch = useCallback(() => {
    fetchData();
  }, [fetchData]);

  // Método de actualización explícito (útil para después de insertar/actualizar/eliminar)
  const refresh = useCallback(() => {
    fetchData();
  }, [fetchData]);

  const handleHiddenColumnsChange = useCallback(
    (keys: string[]) => {
      setHiddenColumns(keys);
      if (storageKey && typeof window !== "undefined") {
        try {
          localStorage.setItem(storageKey, JSON.stringify(keys));
        } catch {
          /* ignore */
        }
      }
    },
    [storageKey]
  );

  // Función para actualizar datos manualmente
  const updateData = useCallback((newData: T[], total: number) => {
    setData(newData);
    setTotalItems(total);
  }, []);

  // Función para resetear todo
  const reset = useCallback(() => {
    setCurrentPage(defaultPage);
    setPageSize(defaultPageSize);
    setSearchQuery("");
    setDebouncedSearch("");
    setActiveFilters([]);
    setSortConfig(defaultSort || null);
    setSelectedIds([]);
  }, [defaultPage, defaultPageSize, defaultSort]);

  return {
    // Estado
    data,
    totalItems,
    currentPage,
    pageSize,
    searchQuery,
    debouncedSearch,
    activeFilters,
    sortConfig,
    selectedIds,
    hiddenColumns,
    isLoading,

    // Setters
    setData,
    setTotalItems,
    setCurrentPage,
    setPageSize,
    setSearchQuery,
    setActiveFilters,
    setSortConfig,
    setSelectedIds,
    setHiddenColumns,
    setIsLoading,

    // Handlers
    handlePageChange,
    handlePageSizeChange,
    handleSearch,
    handleSearchClick,
    handleFilterChange,
    handleSortChange,
    handleSelectionChange,
    handleHiddenColumnsChange,
    handleClearFilters,
    handleRefetch,
    refresh, // Alias más explícito para actualizar datos

    // Utilidades
    updateData,
    fetchData,
    reset,
  };
}

// Hook simplificado para casos básicos
export function useSimpleTable<T>(
  fetchFunction: (page: number, pageSize: number, search: string) => Promise<{ data: T[]; total: number }>,
  defaultPageSize = 30
) {
  const table = useGenericTableV2<T>({
    defaultPageSize,
    onFetch: async ({ page, pageSize, search }) => {
      const result = await fetchFunction(page, pageSize, search);
      table.updateData(result.data, result.total);
    },
  });

  return table;
}
