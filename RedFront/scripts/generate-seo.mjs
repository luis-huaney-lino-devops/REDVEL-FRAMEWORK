/**
 * Script para generar archivos SEO (sitemap.xml, robots.txt, humans.txt)
 * Se ejecuta durante el build
 *
 * Este script lee las rutas públicas de publicRoutes.tsx y genera
 * los archivos SEO necesarios
 */

import { readFileSync, writeFileSync, existsSync, mkdirSync } from "fs";
import { fileURLToPath } from "url";
import { dirname, resolve, join } from "path";

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const rootDir = resolve(__dirname, "..");

// Leer la configuración de constantes
const constantsPath = resolve(rootDir, "src/assets/constants/constantes.ts");
const constantsContent = readFileSync(constantsPath, "utf-8");

// Extraer baseUrl de las constantes (usar regex para encontrar la URL)
const baseUrlMatch = constantsContent.match(
  /const baseUrl:\s*string\s*=\s*"([^"]+)"/
);
const baseUrl = baseUrlMatch ? baseUrlMatch[1] : "http://localhost:3000";

// Leer las rutas públicas
const publicRoutesPath = resolve(rootDir, "src/Routes/publicRoutes.tsx");
const publicRoutesContent = readFileSync(publicRoutesPath, "utf-8");

// Extraer información de las rutas usando regex mejorado
const routes = [];
const routePattern =
  /{\s*path:\s*"([^"]+)",[\s\S]*?element:\s*(\w+),[\s\S]*?importancia:\s*([0-9.]+),[\s\S]*?(?:title:\s*"([^"]*)",)?[\s\S]*?(?:description:\s*"([^"]*)",)?[\s\S]*?(?:keywords:\s*\[([^\]]*)\],)?[\s\S]*?changefreq:\s*"([^"]+)",/g;

let match;
while ((match = routePattern.exec(publicRoutesContent)) !== null) {
  const keywords = match[6]
    ? match[6].split(",").map((k) => k.trim().replace(/"/g, ""))
    : [];

  routes.push({
    path: match[1],
    importancia: parseFloat(match[3]),
    changefreq: match[7] || "weekly",
    lastmod: new Date().toISOString().split("T")[0],
  });
}

// Función para generar sitemap.xml
function generateSitemap() {
  let sitemap = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
`;

  routes.forEach((route) => {
    const url = `${baseUrl}${route.path}`;
    sitemap += `  <url>
    <loc>${url}</loc>
    <lastmod>${route.lastmod}</lastmod>
    <changefreq>${route.changefreq}</changefreq>
    <priority>${route.importancia.toFixed(1)}</priority>
  </url>
`;
  });

  sitemap += `</urlset>`;
  return sitemap;
}

// Función para generar robots.txt
function generateRobotsTxt() {
  const sitemapUrl = `${baseUrl}/sitemap.xml`;
  return `# Robots.txt 
# Generado automáticamente - NO editar manualmente
# Este archivo se regenera en cada build

User-agent: *
Allow: /

# Permitir acceso específico a los principales motores de búsqueda
User-agent: Googlebot
Allow: /

User-agent: Bingbot
Allow: /

User-agent: Slurp
Allow: /

# Bloquear acceso a archivos y directorios administrativos/técnicos
Disallow: /admin/
Disallow: /api/
Disallow: /.env
Disallow: /config/
Disallow: /node_modules/
Disallow: /src/
Disallow: /*.json$
Disallow: /*.log$

# Bloquear rutas protegidas (requieren autenticación)
Disallow: /dashboard
Disallow: /inicio
Disallow: /usuarios/
Disallow: /empleados/
Disallow: /inicios
Disallow: /prueba
Disallow: /403

# Permitir acceso a recursos importantes para SEO
Allow: /public/
Allow: /assets/
Allow: /images/
Allow: /css/
Allow: /js/

# Especificar la ubicación del sitemap
Sitemap: ${sitemapUrl}

# Crawl-delay para evitar sobrecarga del servidor
Crawl-delay: 1
`;
}

// Función para generar humans.txt
function generateHumansTxt() {
  return `/* TEAM */
Developer: REDVEL Team
Contact: info@redvel.com
From: REDVEL Framework

/* SITE */
Standards: HTML5, CSS3, JavaScript ES6+
Components: React, TypeScript, Vite
Software: VSCode, Git
`;
}

// Directorio de salida (public)
const publicDir = resolve(rootDir, "public");

// Asegurar que el directorio existe
if (!existsSync(publicDir)) {
  mkdirSync(publicDir, { recursive: true });
}

// Generar y escribir archivos
try {
  const sitemap = generateSitemap();
  const robotsTxt = generateRobotsTxt();
  const humansTxt = generateHumansTxt();

  writeFileSync(join(publicDir, "sitemap.xml"), sitemap, "utf-8");
  writeFileSync(join(publicDir, "robots.txt"), robotsTxt, "utf-8");
  writeFileSync(join(publicDir, "humans.txt"), humansTxt, "utf-8");

  console.log("✅ Archivos SEO generados exitosamente:");
  console.log(`  - sitemap.xml (${routes.length} rutas)`);
  console.log(`  - robots.txt`);
  console.log(`  - humans.txt`);
  console.log(`📍 Base URL: ${baseUrl}`);
} catch (error) {
  console.error("❌ Error al generar archivos SEO:", error);
  process.exit(1);
}
