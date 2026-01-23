"use client";

import { useState, useCallback, useEffect } from "react";

import Constantes from "@/assets/constants/constantes";
import Cookies from "js-cookie";
import axios from "axios";
import { getCache, setCache, removeCache } from "@/assets/lib/cache";
import type { GenericListParams, GenericListResponse } from "./generic-table";

interface UseGenericListOptions {
  endpoint: string; // Ej: "/api/categorias/lista"
  cacheTtl?: number;
  enableCache?: boolean;
}

interface UseGenericListReturn<T> {
  items: T[];
  loading: boolean;
  error: string | null;
  totalItems: number;
  currentPage: number;
  pageSize: number;
  searchTerm: string;
  searchQuery: string;
  refetch: () => void;
  clearFilters: () => void;
  updateItem: (data: Partial<T>) => Promise<boolean>;
  deleteItem: (
    id: number | string
  ) => Promise<{ success: boolean; message: string }>;
  addItem: (data: T) => Promise<boolean>;
  handlePageChange: (page: number) => void;
  handlePageSizeChange: (size: number) => void;
  handleSearch: () => void;
  setSearchQuery: (query: string) => void;
  fetchItems: (page: number, size: number, search?: string) => Promise<void>;
}

export function useGenericList<T>(
  options: UseGenericListOptions
): UseGenericListReturn<T> {
  const {
    endpoint,
    cacheTtl = 300000, // 5 minutes default cache TTL
    enableCache = true,
  } = options;

  const token = Cookies.get("token");
  const CACHE_KEY = Constantes.TOKEN_CACHE_KEY + endpoint + token;

  const [items, setItems] = useState<T[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [totalItems, setTotalItems] = useState(0);
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(10);
  const [searchTerm, setSearchTerm] = useState("");
  const [searchQuery, setSearchQuery] = useState("");

  const clearCache = () => removeCache(CACHE_KEY);

  const fetchItems = useCallback(
    async (page: number, size: number, search?: string) => {
      setLoading(true);
      setError(null);
      const token = Cookies.get("token");
      if (!token) {
        setError("Token de autenticación no encontrado");
        setLoading(false);
        return;
      }

      const isCacheable = enableCache && (!search || search.trim() === "");
      if (isCacheable) {
        const cached = getCache(CACHE_KEY, cacheTtl);
        if (cached && cached[page] && cached[page][size]) {
          setItems(cached[page][size].data);
          setTotalItems(cached[page][size].total);
          setLoading(false);
          return;
        }
      }

      try {
        const params: GenericListParams = {
          Limite_inferior: (page - 1) * size,
          Limite_Superior: size,
        };
        if (search && search.trim().length > 0) {
          params.Buscar = search.trim();
        }

        const response = await axios.get(
          `${Constantes.baseUrlBackend}${endpoint}`,
          {
            params,
            headers: {
              Authorization: `Bearer ${token}`,
              "Content-Type": "application/json",
            },
          }
        );

        if (response.status < 200 || response.status >= 300) {
          throw new Error("Error al cargar los datos");
        }

        const data: GenericListResponse<T> = response.data;
        setItems(data.data);
        setTotalItems(data.total);

        if (isCacheable) {
          const cached = getCache(CACHE_KEY, cacheTtl) || {};
          if (!cached[page]) cached[page] = {};
          cached[page][size] = { data: data.data, total: data.total };
          setCache(CACHE_KEY, cached);
        }
      } catch (err) {
        setError(err instanceof Error ? err.message : "Error desconocido");
      } finally {
        setLoading(false);
      }
    },
    [endpoint, enableCache, cacheTtl, CACHE_KEY]
  );

  const updateItem = async (updatedData: Partial<T>): Promise<boolean> => {
    try {
      const token = Cookies.get("token");
      if (!token) throw new Error("Token de autenticación no encontrado");

      const response = await axios.post(
        `${Constantes.baseUrlBackend}${endpoint.replace(
          "-listar",
          "-actualizar"
        )}`,
        updatedData,
        {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        }
      );

      if (response.status === 200) {
        clearCache();
        await fetchItems(currentPage, pageSize, searchTerm);
        return true;
      }
      return false;
    } catch (error) {
      console.error("Error actualizando item:", error);
      return false;
    }
  };

  const deleteItem = async (
    id: number | string
  ): Promise<{ success: boolean; message: string }> => {
    try {
      const token = Cookies.get("token");
      if (!token) throw new Error("Token de autenticación no encontrado");

      const response = await axios.delete(
        `${Constantes.baseUrlBackend}${endpoint.replace(
          "-listar",
          "-eliminar"
        )}/${id}`,
        {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        }
      );

      if (response.status === 200) {
        clearCache();
        await fetchItems(currentPage, pageSize, searchTerm);
        return {
          success: true,
          message: "Item eliminado correctamente",
        };
      }
      return {
        success: false,
        message: "Error inesperado al eliminar el item",
      };
    } catch (error: any) {
      console.error("Error eliminando item:", error);
      const errorMessage = error.response?.data?.message || error.message || "";

      if (
        errorMessage.includes("foreign key constraint") ||
        errorMessage.includes("Integrity constraint violation") ||
        errorMessage.includes("Cannot delete or update a parent row")
      ) {
        return {
          success: false,
          message:
            "No se puede eliminar este registro porque tiene datos asociados",
        };
      }

      return {
        success: false,
        message: "Error al eliminar el item",
      };
    }
  };

  const addItem = async (newData: T): Promise<boolean> => {
    try {
      const token = Cookies.get("token");
      if (!token) throw new Error("Token de autenticación no encontrado");

      const response = await axios.post(
        `${Constantes.baseUrlBackend}${endpoint.replace("-listar", "-crear")}`,
        newData,
        {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        }
      );

      if (response.status === 201 || response.status === 200) {
        clearCache();
        await fetchItems(currentPage, pageSize, searchTerm);
        return true;
      }
      return false;
    } catch (error) {
      console.error("Error agregando item:", error);
      return false;
    }
  };

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
    fetchItems(page, pageSize, searchTerm);
  };

  const handlePageSizeChange = (size: number) => {
    setPageSize(size);
    setCurrentPage(1);
    fetchItems(1, size, searchTerm);
  };

  const handleSearch = () => {
    setSearchTerm(searchQuery);
    setCurrentPage(1);
    fetchItems(1, pageSize, searchQuery);
  };

  const refetch = () => {
    fetchItems(currentPage, pageSize, searchTerm);
  };

  const clearFilters = () => {
    setSearchQuery("");
    setSearchTerm("");
    setCurrentPage(1);
    fetchItems(1, pageSize, "");
  };

  // Fetch initial data on mount
  useEffect(() => {
    fetchItems(currentPage, pageSize, searchTerm);
  }, [fetchItems]);

  return {
    items,
    loading,
    error,
    totalItems,
    currentPage,
    pageSize,
    searchTerm,
    searchQuery,
    refetch,
    clearFilters,
    updateItem,
    deleteItem,
    addItem,
    handlePageChange,
    handlePageSizeChange,
    handleSearch,
    setSearchQuery,
    fetchItems,
  };
}
