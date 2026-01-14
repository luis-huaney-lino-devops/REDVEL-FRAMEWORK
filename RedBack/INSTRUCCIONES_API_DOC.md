# Instrucciones para Configurar Documentación API Automática

## ✅ Cambios Realizados

1. ✅ **Scribe instalado** - Paquete para documentación automática sin anotaciones
2. ✅ **Configuración creada** - `config/scribe.php` ya está configurado y listo
3. ✅ **Middleware creado** - `EnsureApiDocEnabled.php` para controlar acceso con `API_DOC=true`
4. ✅ **L5-Swagger configurado** - Actualizado para usar el nuevo middleware
5. ✅ **Service Provider registrado** - Scribe está registrado en `bootstrap/providers.php`
6. ✅ **Detección automática de JWT** - Estrategia personalizada que detecta automáticamente rutas protegidas
7. ✅ **Extracción automática de parámetros** - Scribe detecta automáticamente parámetros de `$request->validate()`

## 📝 Configuración en .env

**Agrega esta línea en tu archivo `.env`:**

```env
# Documentación API (reemplaza SWAGGER_ENABLED)
API_DOC=true
```

**Elimina estas líneas del .env (si existen):**
```env
SWAGGER_ENABLED=true
L5_SWAGGER_GENERATE_ALWAYS=true
```

## 🚀 Generar Documentación con Scribe (Completamente Automático)

Scribe genera documentación **completamente automática** sin necesidad de anotaciones. Solo necesitas:

### Paso 1: Generar la documentación

Ejecuta este comando **una sola vez**:

```bash
cd RedBack
php artisan scribe:generate
```

Este comando:
- ✅ Escanea automáticamente todas las rutas en `routes/api.php`
- ✅ Analiza los controladores y sus métodos
- ✅ **Detecta automáticamente rutas protegidas** por middleware `check.jwt`
- ✅ **Extrae automáticamente parámetros** de `$request->validate()` en cada método
- ✅ Detecta tipos de datos, validaciones y ejemplos
- ✅ Genera documentación HTML interactiva

### Paso 2: Acceder a la documentación

Una vez generada, accede a:
- **URL**: `http://localhost:8000/docs`
- **Solo disponible si** `API_DOC=true` en `.env`

### Paso 3: Regenerar cuando cambies rutas

Cada vez que agregues o modifiques rutas/controladores, regenera la documentación:

```bash
php artisan scribe:generate
```

## 🎯 Características Automáticas

### ✅ Detección Automática de Autenticación

Scribe detecta automáticamente qué rutas requieren autenticación JWT:
- Las rutas dentro de `Route::middleware(['check.jwt'])->group()` se marcan automáticamente como protegidas
- El header `Authorization: Bearer {token}` se agrega automáticamente a esas rutas
- **No necesitas agregar anotaciones** `@authenticated` o `@unauthenticated`

### ✅ Extracción Automática de Parámetros

Scribe extrae automáticamente los parámetros del body desde:
- `$request->validate([...])` - Detecta nombre, tipo, validaciones y si es requerido
- FormRequests - Si usas FormRequest classes
- Docblocks `@bodyParam` - Solo si quieres agregar descripciones personalizadas (opcional)

**Ejemplo automático:**
```php
public function login(Request $request)
{
    $request->validate([
        'nombre_usuario' => 'required|string|max:255',
        'password' => 'required|string|min:6',
    ]);
    // ...
}
```

Scribe detectará automáticamente:
- `nombre_usuario` (string, required, max:255)
- `password` (string, required, min:6)

## 📚 Usar L5-Swagger (Requiere Anotaciones)

Si prefieres seguir usando L5-Swagger (que requiere anotaciones OpenAPI):

1. **Generar documentación**:
   ```bash
   php artisan l5-swagger:generate
   ```

2. **Acceder a la documentación**:
   - URL: `http://localhost:8000/api/documentation`
   - Solo disponible si `API_DOC=true` en `.env`

## 🔒 Seguridad

- La documentación solo es accesible cuando `API_DOC=true` en el `.env`
- Si `API_DOC=false`, todas las rutas de documentación retornan 404
- Esto previene exposición accidental de la documentación en producción

## 🔧 Solución de Problemas

### Si el comando `scribe:generate` no funciona:

1. **Verificar que el service provider esté registrado**:
   ```bash
   php artisan package:discover
   ```

2. **Regenerar autoloader**:
   ```bash
   composer dump-autoload
   ```

3. **Limpiar caché**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Si la documentación no aparece en `/docs`:

1. Verifica que `API_DOC=true` en `.env`
2. Ejecuta `php artisan scribe:generate` nuevamente
3. Verifica que no haya errores en `storage/logs/laravel.log`

### Si los parámetros no aparecen automáticamente:

1. Asegúrate de que `$request->validate()` esté en el método del controlador
2. Las validaciones deben estar en las primeras líneas del método (primeras 10 líneas)
3. Si aún no aparecen, puedes agregar docblocks `@bodyParam` como ayuda (opcional)

## 📌 Notas Importantes

- ✅ **Scribe es completamente automático** - No requiere anotaciones en el código
- ✅ **Detecta middleware JWT automáticamente** - Las rutas protegidas se marcan automáticamente
- ✅ **Extrae parámetros automáticamente** - Desde `$request->validate()` sin necesidad de docblocks
- ✅ **L5-Swagger** requiere anotaciones OpenAPI pero ya está configurado
- ✅ Ambos respetan la variable `API_DOC` para controlar el acceso
- ✅ La configuración de Scribe está en `config/scribe.php` y ya está lista para usar
- ✅ La URL base usa automáticamente `APP_URL` del `.env` (ej: `http://localhost:8000`)

## 🎨 Personalización Opcional

Si quieres agregar descripciones personalizadas a los parámetros (opcional), puedes usar docblocks:

```php
/**
 * @bodyParam nombre_usuario string required El nombre de usuario. Example: admin
 * @bodyParam password string required La contraseña. Example: password123
 */
public function login(Request $request) { ... }
```

Pero **NO es necesario** - Scribe detectará automáticamente los parámetros desde `$request->validate()`.
