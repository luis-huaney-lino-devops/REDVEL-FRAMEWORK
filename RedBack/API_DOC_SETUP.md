# Configuración de Documentación API Automática

## Cambios Realizados

1. **Middleware creado**: `EnsureApiDocEnabled.php` - Controla el acceso a la documentación usando `API_DOC=true` en el `.env`

2. **Configuración actualizada**: `config/l5-swagger.php` - Ahora usa el nuevo middleware

3. **Scribe instalado**: El paquete `knuckleswtf/scribe` está instalado pero necesita configuración adicional

## Para completar la configuración:

### Opción 1: Usar L5-Swagger (ya configurado)

1. Agregar en `.env`:

    ```
    API_DOC=true
    L5_SWAGGER_GENERATE_ALWAYS=true
    ```

2. La documentación estará disponible en: `/api/documentation`

### Opción 2: Usar Scribe (más automático, sin anotaciones)

1. Ejecutar:

    ```bash
    composer dump-autoload
    php artisan vendor:publish --provider="Knuckles\Scribe\ScribeServiceProvider" --tag=scribe-config
    php artisan scribe:generate
    ```

2. Agregar en `.env`:

    ```
    API_DOC=true
    ```

3. La documentación estará disponible en: `/docs`

## Eliminar referencias a SWAGGER_ENABLED

Buscar y reemplazar en todos los archivos:

-   `SWAGGER_ENABLED` → `API_DOC`
-   `EnsureSwaggerEnabled` → `EnsureApiDocEnabled`
