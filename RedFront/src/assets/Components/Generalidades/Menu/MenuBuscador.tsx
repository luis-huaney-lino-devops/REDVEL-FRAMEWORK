"use client";

import * as React from "react";
import {
  Search,
  Clock,
  Star,
  X,
  ChevronRight,
  Sparkles,
  Trash2,
  Link2,
  Plus,
  ExternalLink,
  Loader2,
} from "lucide-react";
import { Dialog, DialogContent } from "@/components/ui/dialog";
import { DialogTitle, DialogDescription } from "@/components/ui/dialog";
import { ScrollArea } from "@/components/ui/scroll-area";
import { Badge } from "@/components/ui/badge";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useNavigate } from "react-router-dom";
import { groupedItems } from "./DatosMenu";

// Añadimos etiquetas para algunos elementos y sinónimos para mejorar la búsqueda

// Interfaz para enlaces personalizados
interface CustomLink {
  id: string;
  name: string;
  url: string;
}

// Interfaz para un elemento de menú
interface MenuItem {
  name: string;
  link: string;
  icon: React.ForwardRefExoticComponent<React.RefAttributes<SVGSVGElement>>;
  tags: string[];
  badge?: string;
}

// Interfaz para un grupo de elementos
interface MenuGroup {
  group: string;
  items: MenuItem[];
}

// Función para normalizar texto (quitar acentos, etc.)
function normalizeText(text: string): string {
  return text
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "") // Eliminar acentos
    .replace(/[.,/#!$%^&*;:{}=\-_`~()]/g, "") // Eliminar puntuación
    .replace(/\s+/g, " "); // Normalizar espacios
}

// Función simplificada para verificar si una palabra es similar a otra
function isSimilar(word: string, query: string): boolean {
  if (!word || !query) return false;

  // Normalizar ambas palabras
  const normalizedWord = normalizeText(word);
  const normalizedQuery = normalizeText(query);

  // Verificar inclusión directa
  return normalizedWord.includes(normalizedQuery);
}

// Función simplificada para buscar en un item
function searchInItem(item: MenuItem, searchTerm: string): boolean {
  if (!searchTerm) return true;

  // Buscar en el nombre
  if (isSimilar(item.name, searchTerm)) return true;

  // Buscar en las etiquetas
  if (item.tags && Array.isArray(item.tags)) {
    for (const tag of item.tags) {
      if (isSimilar(tag, searchTerm)) return true;
    }
  }

  return false;
}

// Validar URL
function isValidUrl(url: string): boolean {
  try {
    // Verificar formato básico de URL
    const urlPattern =
      /^(https?:\/\/)?([\w-]+(\.[\w-]+)+)([\w.,@?^=%&:/~+#-]*[\w@?^=%&/~+#-])?$/;
    if (!urlPattern.test(url)) return false;

    // Verificar que no contenga scripts
    const scriptPattern = /<script|javascript:|data:/i;
    if (scriptPattern.test(url)) return false;

    return true;
  } catch {
    return false;
  }
}

// Simulación de navegación

export function CommandMenu() {
  const [open, setOpen] = React.useState(false);
  const [search, setSearch] = React.useState("");
  const [selectedIndex, setSelectedIndex] = React.useState(0);
  const navigate = useNavigate();
  const [recentSearches, setRecentSearches] = React.useState<string[]>(() => {
    if (typeof window !== "undefined") {
      const saved = localStorage.getItem("recentSearches");
      return saved ? JSON.parse(saved) : [];
    }
    return [];
  });
  const navigateurl = (path: string) => {
    navigate(`${path}`);
  };
  const [favorites, setFavorites] = React.useState<string[]>(() => {
    if (typeof window !== "undefined") {
      const saved = localStorage.getItem("favoriteCommands");
      return saved ? JSON.parse(saved) : [];
    }
    return [];
  });
  const [customLinks, setCustomLinks] = React.useState<CustomLink[]>(() => {
    if (typeof window !== "undefined") {
      const saved = localStorage.getItem("customLinks");
      return saved ? JSON.parse(saved) : [];
    }
    return [];
  });
  const [isLoading, setIsLoading] = React.useState(false);
  const [isSearching, setIsSearching] = React.useState(false);
  const inputRef = React.useRef<HTMLInputElement>(null);
  const [searchResults, setSearchResults] = React.useState<MenuGroup[]>([]);
  const [showFavoritesManagement, setShowFavoritesManagement] =
    React.useState(false);
  const [showAddCustomLink, setShowAddCustomLink] = React.useState(false);
  const [newLinkName, setNewLinkName] = React.useState("");
  const [newLinkUrl, setNewLinkUrl] = React.useState("");
  const [urlError, setUrlError] = React.useState("");
  const selectedItemRef = React.useRef<HTMLDivElement>(null);
  const commandListRef = React.useRef<HTMLDivElement>(null);

  // Efecto para guardar búsquedas recientes
  React.useEffect(() => {
    if (typeof window !== "undefined") {
      localStorage.setItem("recentSearches", JSON.stringify(recentSearches));
    }
  }, [recentSearches]);

  // Efecto para guardar favoritos
  React.useEffect(() => {
    if (typeof window !== "undefined") {
      localStorage.setItem("favoriteCommands", JSON.stringify(favorites));
    }
  }, [favorites]);

  // Efecto para guardar enlaces personalizados
  React.useEffect(() => {
    if (typeof window !== "undefined") {
      localStorage.setItem("customLinks", JSON.stringify(customLinks));
    }
  }, [customLinks]);

  // Efecto para manejar atajos de teclado
  React.useEffect(() => {
    const down = (e: KeyboardEvent) => {
      if (e.key === "k" && (e.metaKey || e.ctrlKey)) {
        e.preventDefault();
        setOpen((prevOpen) => !prevOpen);
      }
    };

    document.addEventListener("keydown", down);
    return () => document.removeEventListener("keydown", down);
  }, []);

  // Efecto para simular carga al abrir
  React.useEffect(() => {
    if (open) {
      setIsLoading(true);
      setTimeout(() => {
        setIsLoading(false);
        inputRef.current?.focus();
      }, 300);
    } else {
      setSearch("");
      setSearchResults([]);
      setShowFavoritesManagement(false);
      setShowAddCustomLink(false);
      setNewLinkName("");
      setNewLinkUrl("");
      setUrlError("");
    }
  }, [open]);

  // Modificar la función clearSearch para que restablezca completamente el estado de búsqueda
  // const clearSearch = () => {
  //   setSearch("")
  //   setSearchResults([])
  //   setIsSearching(false)
  //   inputRef.current?.focus()
  // }

  // Modificar el efecto de búsqueda para asegurar que se restablezca correctamente cuando el input está vacío
  React.useEffect(() => {
    // Si el campo de búsqueda está vacío, resetear los resultados y mostrar la vista normal
    if (search.trim() === "") {
      setSearchResults([]);
      setIsSearching(false);
      return;
    }

    // Mostrar animación de búsqueda
    setIsSearching(true);

    // Simular un pequeño retraso para mostrar la animación
    const searchTimeout = setTimeout(() => {
      const results = groupedItems
        .map((group) => ({
          group: group.group,
          items: group.items.filter((item) => searchInItem(item, search)),
        }))
        .filter((group) => group.items.length > 0);

      setSearchResults(results);
      setSelectedIndex(0);
      setIsSearching(false);
    }, 300);

    return () => clearTimeout(searchTimeout);
  }, [search]);

  // Efecto para hacer scroll al elemento seleccionado
  React.useEffect(() => {
    if (selectedItemRef.current && commandListRef.current) {
      const selectedElement = selectedItemRef.current;
      const container = commandListRef.current;

      const selectedRect = selectedElement.getBoundingClientRect();
      const containerRect = container.getBoundingClientRect();

      // Verificar si el elemento está fuera de la vista
      if (
        selectedRect.bottom > containerRect.bottom ||
        selectedRect.top < containerRect.top
      ) {
        // Hacer scroll para que el elemento sea visible
        selectedElement.scrollIntoView({
          behavior: "smooth",
          block: "nearest",
        });
      }
    }
  }, [selectedIndex]);

  // Filtra las opciones dentro de cada grupo según el término de búsqueda
  const filteredGroups = React.useMemo(() => {
    if (!search.trim()) {
      return groupedItems;
    }
    return searchResults;
  }, [search, searchResults]);

  // Verificar si hay resultados de búsqueda
  const hasSearchResults = searchResults.length > 0;

  // Función para añadir a búsquedas recientes
  const addToRecentSearches = (term: string) => {
    if (!term) return;
    setRecentSearches((prev) => {
      const filtered = prev.filter((item) => item !== term);
      return [term, ...filtered].slice(0, 5);
    });
  };

  // Función para alternar favoritos
  const toggleFavorite = (name: string, e: React.MouseEvent) => {
    e.stopPropagation();
    setFavorites((prev) => {
      if (prev.includes(name)) {
        return prev.filter((item) => item !== name);
      } else {
        return [...prev, name];
      }
    });
  };

  // Función para quitar un favorito
  const removeFavorite = (name: string, e: React.MouseEvent) => {
    e.stopPropagation();
    setFavorites((prev) => prev.filter((item) => item !== name));
  };

  // Función para limpiar todos los favoritos
  const clearAllFavorites = () => {
    setFavorites([]);
    setShowFavoritesManagement(false);
  };

  // Función para añadir un enlace personalizado
  const addCustomLink = () => {
    // Validar URL
    if (!newLinkName.trim()) {
      setUrlError("El nombre es obligatorio");
      return;
    }

    if (!newLinkUrl.trim()) {
      setUrlError("La URL es obligatoria");
      return;
    }

    if (!isValidUrl(newLinkUrl)) {
      setUrlError("URL no válida. Debe ser una URL segura (http/https)");
      return;
    }

    // Asegurarse de que la URL tenga el protocolo
    let formattedUrl = newLinkUrl;
    if (
      !formattedUrl.startsWith("http://") &&
      !formattedUrl.startsWith("https://")
    ) {
      formattedUrl = "https://" + formattedUrl;
    }

    // Añadir el enlace
    const newLink: CustomLink = {
      id: Date.now().toString(),
      name: newLinkName.trim(),
      url: formattedUrl,
    };

    setCustomLinks((prev) => [...prev, newLink]);
    setNewLinkName("");
    setNewLinkUrl("");
    setUrlError("");
    setShowAddCustomLink(false);
  };

  // Función para eliminar un enlace personalizado
  const removeCustomLink = (id: string, e: React.MouseEvent) => {
    e.stopPropagation();
    setCustomLinks((prev) => prev.filter((link) => link.id !== id));
  };

  const handleSelect = (link: string, name: string) => {
    setOpen(false);
    addToRecentSearches(name);

    // Simulamos una pequeña carga antes de navegar
    setIsLoading(true);
    setTimeout(() => {
      navigateurl(link);
      setIsLoading(false);
    }, 150);
  };

  // Función para manejar la selección de enlaces personalizados
  const handleCustomLinkSelect = (url: string) => {
    setOpen(false);

    // Abrir en una nueva pestaña
    window.open(url, "_blank", "noopener,noreferrer");
  };

  // Función separada para el manejo de clics
  const handleItemClick = (e: React.MouseEvent, link: string, name: string) => {
    e.preventDefault();
    handleSelect(link, name);
  };

  // Función para limpiar búsquedas recientes
  const clearRecentSearches = (e: React.MouseEvent) => {
    e.stopPropagation();
    setRecentSearches([]);
  };

  // Obtener todos los items en una lista plana para navegación por teclado
  const allItems = React.useMemo(() => {
    return filteredGroups.flatMap((group) => group.items);
  }, [filteredGroups]);

  // Manejar navegación por teclado
  const handleKeyDown = (e: React.KeyboardEvent) => {
    if (showAddCustomLink) return; // No navegar cuando se está añadiendo un enlace

    if (e.key === "ArrowDown") {
      e.preventDefault();
      if (allItems.length > 0) {
        setSelectedIndex((prev) => (prev + 1) % allItems.length);
      }
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      if (allItems.length > 0) {
        setSelectedIndex(
          (prev) => (prev - 1 + allItems.length) % allItems.length
        );
      }
    } else if (e.key === "Enter") {
      e.preventDefault();
      if (allItems[selectedIndex]) {
        handleSelect(
          allItems[selectedIndex].link,
          allItems[selectedIndex].name
        );
      }
    }
  };

  // Función para limpiar la búsqueda
  const handleClearSearch = () => {
    setSearch("");
    setSearchResults([]);
    setIsSearching(false);
    inputRef.current?.focus();
  };

  const isFavorite = (name: string) => favorites.includes(name);

  return (
    <TooltipProvider>
      <button
        onClick={() => setOpen(true)}
        className="Btn_comand flex items-center w-64 px-3 py-2 text-sm border rounded-md bg-background hover:border-primary/50 transition-all duration-200 group"
      >
        <Search className="w-4 h-4 mr-2 opacity-50 shrink-0 group-hover:text-primary group-hover:opacity-100 transition-colors duration-200" />
        <span className="flex-1 text-left text-muted-foreground group-hover:text-foreground/80 transition-colors duration-200">
          Buscar en el sistema...
        </span>
        <kbd className="pointer-events-none inline-flex h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground opacity-100 transition-opacity duration-200">
          <span className="text-xs">ctrl +</span>K
        </kbd>
      </button>

      <Dialog open={open} onOpenChange={setOpen}>
        <DialogContent
          className="p-0 overflow-hidden max-w-2xl border-primary/20 shadow-lg shadow-primary/5"
          onKeyDown={handleKeyDown}
        >
          <div className="flex flex-col space-y-2 p-4 bg-gradient-to-r from-muted to-muted/50">
            <DialogTitle className="text-lg font-semibold flex items-center">
              <Sparkles className="w-5 h-5 mr-2 text-primary" />
              <span>Búsqueda inteligente</span>
            </DialogTitle>
            <DialogDescription className="text-sm text-muted-foreground">
              Encuentra rápidamente lo que necesitas aqui.
            </DialogDescription>
          </div>
          <div className="flex flex-col">
            <div className="flex items-center border-b px-3 transition-all duration-200">
              <Search
                className={cn(
                  "mr-2 h-5 w-5 shrink-0 text-primary",
                  isLoading ? "animate-pulse" : ""
                )}
              />
              <Input
                ref={inputRef}
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                placeholder="Escribe para buscar..."
                className="flex h-12 w-full rounded-none border-0 bg-transparent py-3 text-base shadow-none outline-none placeholder:text-muted-foreground focus-visible:ring-0 focus-visible:ring-offset-0"
              />
              {search && (
                <button
                  onClick={handleClearSearch}
                  className="p-1 rounded-full hover:bg-muted transition-colors duration-200"
                >
                  <X className="h-4 w-4" />
                </button>
              )}
            </div>
            <ScrollArea
              className="h-[400px] overflow-y-auto"
              ref={commandListRef}
            >
              <div className="p-2">
                {isLoading ? (
                  <div className="py-6 text-center animate-pulse">
                    <div className="inline-block p-3 rounded-full bg-primary/10">
                      <Search className="h-6 w-6 text-primary" />
                    </div>
                    <p className="mt-2 text-sm text-muted-foreground">
                      Buscando resultados...
                    </p>
                  </div>
                ) : isSearching ? (
                  <div className="py-6 text-center">
                    <div className="inline-block p-3 rounded-full bg-primary/10">
                      <Loader2 className="h-6 w-6 text-primary animate-spin" />
                    </div>
                    <p className="mt-2 text-sm text-muted-foreground">
                      Buscando resultados...
                    </p>
                  </div>
                ) : showAddCustomLink ? (
                  <div className="p-4">
                    <div className="flex items-center justify-between mb-4">
                      <h3 className="text-lg font-medium">
                        Añadir enlace personalizado
                      </h3>
                      <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => {
                          setShowAddCustomLink(false);
                          setNewLinkName("");
                          setNewLinkUrl("");
                          setUrlError("");
                        }}
                      >
                        <X className="h-4 w-4 mr-2" />
                        Cancelar
                      </Button>
                    </div>

                    <div className="space-y-4">
                      <div className="space-y-2">
                        <Label htmlFor="link-name">Nombre del enlace</Label>
                        <Input
                          id="link-name"
                          value={newLinkName}
                          onChange={(e) => setNewLinkName(e.target.value)}
                          placeholder="Ej: Mi sitio web"
                        />
                      </div>

                      <div className="space-y-2">
                        <Label htmlFor="link-url">URL del enlace</Label>
                        <Input
                          id="link-url"
                          value={newLinkUrl}
                          onChange={(e) => setNewLinkUrl(e.target.value)}
                          placeholder="Ej: https://ejemplo.com"
                        />
                        {urlError && (
                          <p className="text-xs text-destructive mt-1">
                            {urlError}
                          </p>
                        )}
                      </div>

                      <Button onClick={addCustomLink} className="w-full">
                        <Plus className="h-4 w-4 mr-2" />
                        Añadir enlace
                      </Button>
                    </div>
                  </div>
                ) : showFavoritesManagement ? (
                  <div className="p-4">
                    <div className="flex items-center justify-between mb-4">
                      <h3 className="text-lg font-medium">
                        Gestionar favoritos
                      </h3>
                      <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => setShowFavoritesManagement(false)}
                      >
                        <X className="h-4 w-4 mr-2" />
                        Cerrar
                      </Button>
                    </div>

                    {favorites.length === 0 ? (
                      <div className="text-center py-8">
                        <Star className="h-12 w-12 mx-auto text-muted-foreground opacity-20" />
                        <p className="mt-2 text-sm text-muted-foreground">
                          No tienes elementos favoritos
                        </p>
                      </div>
                    ) : (
                      <>
                        <div className="space-y-2 mb-4">
                          {favorites.map((name) => {
                            const item = groupedItems
                              .flatMap((g) => g.items)
                              .find((i) => i.name === name);
                            if (!item) return null;

                            return (
                              <div
                                key={`manage-${item.name}`}
                                className="flex items-center justify-between p-2 rounded-md bg-muted/50"
                              >
                                <div className="flex items-center">
                                  <item.icon className="mr-2 h-4 w-4 text-primary" />
                                  <span>{item.name}</span>
                                </div>
                                <Tooltip>
                                  <TooltipTrigger asChild>
                                    <Button
                                      variant="ghost"
                                      size="icon"
                                      onClick={(e) =>
                                        removeFavorite(item.name, e)
                                      }
                                      className="h-8 w-8 text-destructive hover:text-destructive hover:bg-destructive/10"
                                    >
                                      <Trash2 className="h-4 w-4" />
                                    </Button>
                                  </TooltipTrigger>
                                  <TooltipContent>
                                    Quitar de favoritos
                                  </TooltipContent>
                                </Tooltip>
                              </div>
                            );
                          })}
                        </div>
                        <Button
                          variant="destructive"
                          size="sm"
                          onClick={clearAllFavorites}
                          className="w-full"
                        >
                          <Trash2 className="h-4 w-4 mr-2" />
                          Eliminar todos los favoritos
                        </Button>
                      </>
                    )}
                  </div>
                ) : (
                  <>
                    {search === "" && (
                      <div className="mb-4">
                        <div className="flex items-center justify-between mb-2">
                          <h3 className="text-xs font-semibold text-muted-foreground uppercase tracking-wider">
                            Enlaces personalizados
                          </h3>
                          <button
                            onClick={() => setShowAddCustomLink(true)}
                            className="text-xs text-muted-foreground hover:text-foreground transition-colors m-2"
                          >
                            Añadir
                          </button>
                        </div>
                        {customLinks.length === 0 ? (
                          <div className="py-3 px-2 text-sm text-muted-foreground">
                            No tienes enlaces personalizados. Haz clic en
                            "Añadir" para crear uno.
                          </div>
                        ) : (
                          <div className="space-y-1">
                            {customLinks.map((link) => (
                              <div
                                key={link.id}
                                className="relative flex cursor-pointer select-none items-center rounded-md px-2 py-2.5 text-sm outline-none hover:bg-accent hover:text-accent-foreground transition-colors duration-150 group/item"
                                onClick={() => handleCustomLinkSelect(link.url)}
                              >
                                <div className="flex items-center justify-center w-8 h-8 rounded-md mr-2 bg-muted">
                                  <Link2 className="h-4 w-4 text-primary" />
                                </div>
                                <div className="flex flex-col">
                                  <span className="font-medium">
                                    {link.name}
                                  </span>
                                  <span className="text-xs text-muted-foreground truncate max-w-[200px]">
                                    {link.url}
                                  </span>
                                </div>
                                <div className="ml-auto flex items-center gap-2">
                                  <Tooltip>
                                    <TooltipTrigger asChild>
                                      <Button
                                        variant="ghost"
                                        size="icon"
                                        className="h-8 w-8 text-muted-foreground hover:text-primary"
                                        onClick={(e) => {
                                          e.stopPropagation();
                                          window.open(
                                            link.url,
                                            "_blank",
                                            "noopener,noreferrer"
                                          );
                                        }}
                                      >
                                        <ExternalLink className="h-4 w-4" />
                                      </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                      Abrir en nueva pestaña
                                    </TooltipContent>
                                  </Tooltip>
                                  <Tooltip>
                                    <TooltipTrigger asChild>
                                      <Button
                                        variant="ghost"
                                        size="icon"
                                        className="h-8 w-8 text-destructive hover:text-destructive hover:bg-destructive/10"
                                        onClick={(e) =>
                                          removeCustomLink(link.id, e)
                                        }
                                      >
                                        <Trash2 className="h-4 w-4" />
                                      </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                      Eliminar enlace
                                    </TooltipContent>
                                  </Tooltip>
                                </div>
                              </div>
                            ))}
                          </div>
                        )}
                      </div>
                    )}

                    {search === "" && recentSearches.length > 0 && (
                      <div className="mb-4">
                        <div className="flex items-center justify-between mb-2">
                          <h3 className="text-xs font-semibold text-muted-foreground uppercase tracking-wider">
                            Búsquedas recientes
                          </h3>
                          <button
                            onClick={clearRecentSearches}
                            className="text-xs text-muted-foreground hover:text-foreground transition-colors m-2"
                          >
                            Limpiar
                          </button>
                        </div>
                        <div className="space-y-1">
                          {recentSearches.map((term) => {
                            const item = groupedItems
                              .flatMap((g) => g.items)
                              .find((i) => i.name === term);
                            if (!item) return null;

                            return (
                              <div
                                key={`recent-${item.name}`}
                                className="relative flex cursor-pointer select-none items-center rounded-md px-2 py-2.5 text-sm outline-none hover:bg-accent hover:text-accent-foreground transition-colors duration-150 group/item"
                                onClick={(e) =>
                                  handleItemClick(e, item.link, item.name)
                                }
                              >
                                <Clock className="mr-2 h-4 w-4 text-muted-foreground" />
                                <span>{item.name}</span>
                                <ChevronRight className="ml-auto h-4 w-4 text-muted-foreground opacity-0 group-hover/item:opacity-100 transition-opacity" />
                              </div>
                            );
                          })}
                        </div>
                      </div>
                    )}

                    {search === "" && favorites.length > 0 && (
                      <div className="mb-4">
                        <div className="flex items-center justify-between mb-2">
                          <h3 className="text-xs font-semibold text-muted-foreground uppercase tracking-wider">
                            Favoritos
                          </h3>
                          <button
                            onClick={() => setShowFavoritesManagement(true)}
                            className="text-xs text-muted-foreground hover:text-foreground transition-colors m-2"
                          >
                            Gestionar
                          </button>
                        </div>
                        <div className="space-y-1">
                          {favorites.map((name) => {
                            const item = groupedItems
                              .flatMap((g) => g.items)
                              .find((i) => i.name === name);
                            if (!item) return null;

                            return (
                              <div
                                key={`fav-${item.name}`}
                                className="relative flex cursor-pointer select-none items-center rounded-md px-2 py-2.5 text-sm outline-none hover:bg-accent hover:text-accent-foreground transition-colors duration-150 group/item"
                                onClick={(e) =>
                                  handleItemClick(e, item.link, item.name)
                                }
                              >
                                <item.icon className="mr-2 h-4 w-4 text-primary" />
                                <span>{item.name}</span>
                                <Tooltip>
                                  <TooltipTrigger asChild>
                                    <Star
                                      className={cn(
                                        "h-4 w-4 transition-all duration-200",
                                        isFavorite(item.name)
                                          ? "text-yellow-500 fill-yellow-500"
                                          : "text-muted-foreground opacity-0 group-hover/item:opacity-100"
                                      )}
                                      onClick={(e) =>
                                        toggleFavorite(item.name, e)
                                      }
                                    />
                                  </TooltipTrigger>
                                  <TooltipContent>
                                    {isFavorite(item.name)
                                      ? "Quitar de favoritos"
                                      : "Añadir a favoritos"}
                                  </TooltipContent>
                                </Tooltip>
                                <ChevronRight className="h-4 w-4 text-muted-foreground opacity-0 group-hover/item:opacity-100 transition-opacity" />
                              </div>
                            );
                          })}
                        </div>
                      </div>
                    )}

                    {/* Mostrar mensaje cuando no hay resultados de búsqueda */}
                    {search !== "" && !hasSearchResults && !isSearching && (
                      <div className="py-6 text-center">
                        <div className="inline-block p-3 rounded-full bg-muted">
                          <Search className="h-6 w-6 text-muted-foreground" />
                        </div>
                        <p className="mt-2 text-base font-medium">
                          No se encontraron resultados
                        </p>
                        <p className="mt-1 text-sm text-muted-foreground mb-4">
                          Intenta con otros términos o navega por las categorías
                        </p>
                        <Button
                          variant="outline"
                          size="sm"
                          onClick={handleClearSearch}
                        >
                          <X className="h-4 w-4 mr-2" />
                          Limpiar búsqueda
                        </Button>
                      </div>
                    )}

                    {filteredGroups.map((group) => (
                      <div key={group.group} className="mb-4">
                        <h3 className="flex items-center py-1 text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-2">
                          {group.group}
                        </h3>
                        <div className="space-y-1">
                          {group.items.map((item, itemIndex) => {
                            const isSelected =
                              allItems.indexOf(item) === selectedIndex;

                            return (
                              <div
                                key={item.name}
                                ref={isSelected ? selectedItemRef : null}
                                className={cn(
                                  "relative flex cursor-pointer select-none items-center rounded-md px-2 py-2.5 text-sm outline-none transition-colors duration-200 group/item",
                                  isSelected
                                    ? "bg-accent text-accent-foreground"
                                    : "hover:bg-accent/50 hover:text-accent-foreground",
                                  "animate-in fade-in-0 slide-in-from-top-1 duration-300",
                                  { "delay-100": itemIndex === 0 },
                                  { "delay-150": itemIndex === 1 },
                                  { "delay-200": itemIndex === 2 },
                                  { "delay-250": itemIndex >= 3 }
                                )}
                                onClick={(e) =>
                                  handleItemClick(e, item.link, item.name)
                                }
                              >
                                <div
                                  className={cn(
                                    "flex items-center justify-center w-8 h-8 rounded-md mr-2",
                                    isSelected ? "bg-primary/20" : "bg-muted"
                                  )}
                                >
                                  <item.icon
                                    className={cn(
                                      "h-4 w-4",
                                      isSelected
                                        ? "text-primary"
                                        : "text-muted-foreground"
                                    )}
                                  />
                                </div>
                                <div className="flex flex-col">
                                  <span className="font-medium">
                                    {item.name}
                                  </span>
                                  {item.tags && (
                                    <span className="text-xs text-muted-foreground">
                                      {item.tags.slice(0, 3).join(" • ")}
                                    </span>
                                  )}
                                </div>

                                <div className="ml-auto flex items-center gap-2">
                                  {item.badge && (
                                    <Badge
                                      variant="outline"
                                      className="ml-auto text-xs bg-primary/10 text-primary border-primary/20"
                                    >
                                      {item.badge}
                                    </Badge>
                                  )}
                                  <Tooltip>
                                    <TooltipTrigger asChild>
                                      <Star
                                        className={cn(
                                          "h-4 w-4 transition-all duration-200",
                                          isFavorite(item.name)
                                            ? "text-yellow-500 fill-yellow-500"
                                            : "text-muted-foreground opacity-0 group-hover/item:opacity-100"
                                        )}
                                        onClick={(e) =>
                                          toggleFavorite(item.name, e)
                                        }
                                      />
                                    </TooltipTrigger>
                                    <TooltipContent>
                                      {isFavorite(item.name)
                                        ? "Quitar de favoritos"
                                        : "Añadir a favoritos"}
                                    </TooltipContent>
                                  </Tooltip>
                                  <ChevronRight className="h-4 w-4 text-muted-foreground opacity-0 group-hover/item:opacity-100 transition-opacity" />
                                </div>
                              </div>
                            );
                          })}
                        </div>
                      </div>
                    ))}
                  </>
                )}
              </div>
            </ScrollArea>
            <div className="p-2 border-t">
              <div className="flex items-center justify-between text-xs text-muted-foreground">
                <div className="flex gap-2">
                  <div className="flex items-center gap-1">
                    <kbd className="px-1.5 py-0.5 rounded border bg-muted font-mono">
                      ↑
                    </kbd>
                    <kbd className="px-1.5 py-0.5 rounded border bg-muted font-mono">
                      ↓
                    </kbd>
                    <span>Navegar</span>
                  </div>
                  <div className="flex items-center gap-1">
                    <kbd className="px-1.5 py-0.5 rounded border bg-muted font-mono">
                      Enter
                    </kbd>
                    <span>Seleccionar</span>
                  </div>
                </div>
                <div className="flex items-center gap-1">
                  <kbd className="px-1.5 py-0.5 rounded border bg-muted font-mono">
                    Esc
                  </kbd>
                  <span>Cerrar</span>
                </div>
              </div>
            </div>
          </div>
        </DialogContent>
      </Dialog>
    </TooltipProvider>
  );
}
