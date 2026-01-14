/**
 * Componente SeoHead - Gestión completa de SEO y metadata
 * Permite añadir y modificar todas las etiquetas meta, Open Graph, Twitter Cards, etc.
 * Se puede usar en cualquier lugar y actualiza automáticamente el <head>
 */

import { useEffect } from "react";

export interface SeoHeadProps {
  /**
   * Título de la página (se actualiza en <title> y og:title)
   */
  title?: string;
  /**
   * Descripción de la página (meta description y og:description)
   */
  description?: string;
  /**
   * Palabras clave para SEO (meta keywords)
   */
  keywords?: string | string[];
  /**
   * URL canónica de la página
   */
  canonical?: string;
  /**
   * Idioma de la página (lang attribute en <html>)
   */
  lang?: string;
  /**
   * Autor de la página
   */
  author?: string;
  /**
   * Robots meta tag (index, noindex, follow, nofollow, etc.)
   */
  robots?: string;
  /**
   * URL de la imagen para Open Graph y Twitter Cards
   */
  image?: string;
  /**
   * Tipo de contenido para Open Graph (website, article, etc.)
   */
  type?: string;
  /**
   * URL completa de la página para Open Graph
   */
  url?: string;
  /**
   * Nombre del sitio para Open Graph
   */
  siteName?: string;
  /**
   * Twitter Card type (summary, summary_large_image, etc.)
   */
  twitterCard?: "summary" | "summary_large_image" | "app" | "player";
  /**
   * Twitter handle del sitio (@username)
   */
  twitterSite?: string;
  /**
   * Twitter handle del creador
   */
  twitterCreator?: string;
  /**
   * Color del tema (theme-color meta tag)
   */
  themeColor?: string;
  /**
   * Color de fondo del tema (msapplication-TileColor)
   */
  tileColor?: string;
  /**
   * Viewport meta tag (por defecto: width=device-width, initial-scale=1.0)
   */
  viewport?: string;
  /**
   * Charset (por defecto: UTF-8)
   */
  charset?: string;
  /**
   * Favicon URL
   */
  favicon?: string;
  /**
   * Apple touch icon URL
   */
  appleTouchIcon?: string;
  /**
   * Fecha de publicación (para artículos)
   */
  publishedTime?: string;
  /**
   * Fecha de modificación (para artículos)
   */
  modifiedTime?: string;
  /**
   * Sección del artículo
   */
  section?: string;
  /**
   * Etiquetas adicionales del artículo
   */
  tags?: string[];
  /**
   * Meta tags personalizados adicionales
   */
  customMeta?: Array<{ name?: string; property?: string; content: string }>;
  /**
   * Links personalizados adicionales
   */
  customLinks?: Array<{ rel: string; href: string; [key: string]: string }>;
}

/**
 * Componente SeoHead - Gestión completa de SEO
 *
 * @example
 * <SeoHead
 *   title="Mi Página"
 *   description="Descripción de mi página"
 *   keywords={["palabra1", "palabra2"]}
 *   image="/imagen.jpg"
 *   canonical="https://example.com/pagina"
 * />
 */
export function SeoHead({
  title,
  description,
  keywords,
  canonical,
  lang,
  author,
  robots,
  image,
  type = "website",
  url,
  siteName,
  twitterCard = "summary_large_image",
  twitterSite,
  twitterCreator,
  themeColor,
  tileColor,
  viewport = "width=device-width, initial-scale=1.0",
  charset = "UTF-8",
  favicon,
  appleTouchIcon,
  publishedTime,
  modifiedTime,
  section,
  tags,
  customMeta = [],
  customLinks = [],
}: SeoHeadProps) {
  useEffect(() => {
    // Actualizar título
    if (title) {
      document.title = title;
    }

    // Función auxiliar para crear o actualizar meta tags
    const setMetaTag = (
      attribute: "name" | "property",
      value: string,
      content: string
    ) => {
      let element = document.querySelector(
        `meta[${attribute}="${value}"]`
      ) as HTMLMetaElement;
      if (!element) {
        element = document.createElement("meta");
        element.setAttribute(attribute, value);
        document.head.appendChild(element);
      }
      element.setAttribute("content", content);
    };

    // Función auxiliar para crear o actualizar link tags
    const setLinkTag = (
      rel: string,
      href: string,
      attributes?: Record<string, string>
    ) => {
      let element = document.querySelector(
        `link[rel="${rel}"]`
      ) as HTMLLinkElement;
      if (!element) {
        element = document.createElement("link");
        element.setAttribute("rel", rel);
        document.head.appendChild(element);
      }
      element.setAttribute("href", href);
      if (attributes) {
        Object.entries(attributes).forEach(([key, value]) => {
          element.setAttribute(key, value);
        });
      }
    };

    // Meta description
    if (description) {
      setMetaTag("name", "description", description);
      setMetaTag("property", "og:description", description);
      setMetaTag("name", "twitter:description", description);
    }

    // Keywords
    if (keywords) {
      const keywordsStr = Array.isArray(keywords)
        ? keywords.join(", ")
        : keywords;
      setMetaTag("name", "keywords", keywordsStr);
    }

    // Canonical URL
    if (canonical) {
      setLinkTag("canonical", canonical);
    }

    // Author
    if (author) {
      setMetaTag("name", "author", author);
    }

    // Robots
    if (robots) {
      setMetaTag("name", "robots", robots);
    }

    // Open Graph
    if (title) {
      setMetaTag("property", "og:title", title);
    }
    if (type) {
      setMetaTag("property", "og:type", type);
    }
    if (url) {
      setMetaTag("property", "og:url", url);
    }
    if (image) {
      setMetaTag("property", "og:image", image);
      setMetaTag("name", "twitter:image", image);
    }
    if (siteName) {
      setMetaTag("property", "og:site_name", siteName);
    }
    if (publishedTime) {
      setMetaTag("property", "article:published_time", publishedTime);
    }
    if (modifiedTime) {
      setMetaTag("property", "article:modified_time", modifiedTime);
    }
    if (section) {
      setMetaTag("property", "article:section", section);
    }
    if (tags && tags.length > 0) {
      tags.forEach((tag) => {
        setMetaTag("property", "article:tag", tag);
      });
    }

    // Twitter Cards
    setMetaTag("name", "twitter:card", twitterCard);
    if (title) {
      setMetaTag("name", "twitter:title", title);
    }
    if (twitterSite) {
      setMetaTag("name", "twitter:site", twitterSite);
    }
    if (twitterCreator) {
      setMetaTag("name", "twitter:creator", twitterCreator);
    }

    // Theme color
    if (themeColor) {
      setMetaTag("name", "theme-color", themeColor);
    }

    // Tile color (Microsoft)
    if (tileColor) {
      setMetaTag("name", "msapplication-TileColor", tileColor);
    }

    // Viewport
    let viewportElement = document.querySelector(
      'meta[name="viewport"]'
    ) as HTMLMetaElement;
    if (!viewportElement) {
      viewportElement = document.createElement("meta");
      viewportElement.setAttribute("name", "viewport");
      document.head.appendChild(viewportElement);
    }
    viewportElement.setAttribute("content", viewport);

    // Charset
    let charsetElement = document.querySelector(
      "meta[charset]"
    ) as HTMLMetaElement;
    if (!charsetElement) {
      charsetElement = document.createElement("meta");
      charsetElement.setAttribute("charset", charset);
      document.head.appendChild(charsetElement);
    } else {
      charsetElement.setAttribute("charset", charset);
    }

    // Favicon
    if (favicon) {
      setLinkTag("icon", favicon);
    }

    // Apple Touch Icon
    if (appleTouchIcon) {
      setLinkTag("apple-touch-icon", appleTouchIcon);
    }

    // Language (html lang attribute)
    if (lang) {
      document.documentElement.setAttribute("lang", lang);
    }

    // Custom meta tags
    customMeta.forEach((meta) => {
      if (meta.name) {
        setMetaTag("name", meta.name, meta.content);
      } else if (meta.property) {
        setMetaTag("property", meta.property, meta.content);
      }
    });

    // Custom links
    customLinks.forEach((link) => {
      const { rel, href, ...attributes } = link;
      setLinkTag(rel, href, attributes);
    });
  }, [
    title,
    description,
    keywords,
    canonical,
    lang,
    author,
    robots,
    image,
    type,
    url,
    siteName,
    twitterCard,
    twitterSite,
    twitterCreator,
    themeColor,
    tileColor,
    viewport,
    charset,
    favicon,
    appleTouchIcon,
    publishedTime,
    modifiedTime,
    section,
    tags,
    customMeta,
    customLinks,
  ]);

  // Este componente no renderiza nada en el DOM
  return null;
}
