/**
 * Componente SeoWrapper - Wrapper para elementos con metadata SEO
 * Se usa para envolver componentes de página y aplicar metadata SEO
 */

import { useEffect } from "react";

export interface SeoWrapperProps {
  /**
   * Título de la página para SEO
   */
  title?: string;
  /**
   * Descripción de la página para SEO
   */
  description?: string;
  /**
   * Palabras clave para SEO
   */
  keywords?: string[];
  /**
   * Tipo de contenido (opcional)
   */
  contentType?: string;
  /**
   * Contenido a renderizar
   */
  children: React.ReactNode;
}

/**
 * Componente SeoWrapper - Aplica metadata SEO a la página
 *
 * @example
 * <SeoWrapper title="Página Principal" description="Descripción">
 *   <MiComponente />
 * </SeoWrapper>
 */
export function SeoWrapper({
  title,
  description,
  keywords,
  contentType = "website",
  children,
}: SeoWrapperProps) {
  useEffect(() => {
    // Actualizar metadata del documento cuando la ruta se active
    if (title) {
      document.title = title;

      // Actualizar meta title si existe
      let metaTitle = document.querySelector('meta[property="og:title"]');
      if (!metaTitle) {
        metaTitle = document.createElement("meta");
        metaTitle.setAttribute("property", "og:title");
        document.head.appendChild(metaTitle);
      }
      metaTitle.setAttribute("content", title);
    }

    if (description) {
      // Actualizar meta description
      let metaDescription = document.querySelector('meta[name="description"]');
      if (!metaDescription) {
        metaDescription = document.createElement("meta");
        metaDescription.setAttribute("name", "description");
        document.head.appendChild(metaDescription);
      }
      metaDescription.setAttribute("content", description);

      // Actualizar og:description
      let ogDescription = document.querySelector(
        'meta[property="og:description"]'
      );
      if (!ogDescription) {
        ogDescription = document.createElement("meta");
        ogDescription.setAttribute("property", "og:description");
        document.head.appendChild(ogDescription);
      }
      ogDescription.setAttribute("content", description);
    }

    if (keywords && keywords.length > 0) {
      // Actualizar keywords
      let metaKeywords = document.querySelector('meta[name="keywords"]');
      if (!metaKeywords) {
        metaKeywords = document.createElement("meta");
        metaKeywords.setAttribute("name", "keywords");
        document.head.appendChild(metaKeywords);
      }
      metaKeywords.setAttribute("content", keywords.join(", "));
    }

    // Actualizar og:type
    let ogType = document.querySelector('meta[property="og:type"]');
    if (!ogType) {
      ogType = document.createElement("meta");
      ogType.setAttribute("property", "og:type");
      document.head.appendChild(ogType);
    }
    ogType.setAttribute("content", contentType);
  }, [title, description, keywords, contentType]);

  return <>{children}</>;
}
