# Solución: Error de Permisos con Guard 'api'

## 🔍 Problema Identificado

El error `There is no permission named 'usuarios.view' for guard 'api'` ocurre porque:

1. **El modelo `Usuario`** tiene `protected $guard_name = 'api';` (línea 55)
2. **El middleware `CheckPermission`** usa `auth('api')` (línea 20)
3. **El seeder `RolesAndPermissionsSeeder`** estaba creando permisos con `guard_name = 'web'` ❌

## ✅ Solución Aplicada

Se cambió el seeder para crear permisos con `guard_name = 'api'`:

```php
// Antes (INCORRECTO):
$guard = 'web';

// Ahora (CORRECTO):
$guard = 'api';
```

## 🔧 Pasos para Corregir

### Opción 1: Ejecutar el Seeder Nuevamente (Recomendado)

Si ya tienes permisos creados con guard `web`, necesitas:

1. **Ejecutar el seeder actualizado**:

    ```bash
    cd RedBack
    php artisan db:seed --class=RolesAndPermissionsSeeder
    ```

    Esto creará los permisos con guard `api` (si no existen) y actualizará los roles.

2. **Limpiar caché de permisos**:
    ```bash
    php artisan permission:cache-reset
    ```

### Opción 2: Migrar Permisos Existentes (Si ya tienes datos)

Si ya tienes permisos con guard `web` y quieres migrarlos a `api`:

1. **Crear un script de migración** o ejecutar manualmente en la base de datos:

    ```sql
    UPDATE permissions SET guard_name = 'api' WHERE guard_name = 'web';
    UPDATE roles SET guard_name = 'api' WHERE guard_name = 'web';
    ```

2. **Limpiar caché**:
    ```bash
    php artisan permission:cache-reset
    ```

### Opción 3: Ejecutar Todos los Seeders (Recomendado para Desarrollo)

Si estás en desarrollo y puedes resetear la base de datos:

```bash
cd RedBack
php artisan migrate:fresh --seed
```

## ✅ Verificación

Después de ejecutar el seeder, verifica que los permisos estén correctos:

```bash
php artisan tinker
```

Luego ejecuta:

```php
use Spatie\Permission\Models\Permission;
Permission::where('guard_name', 'api')->get(['name', 'guard_name']);
```

Deberías ver todos los permisos con `guard_name = 'api'`.

## 📝 Notas Importantes

-   **El guard debe ser consistente**:

    -   Modelo `Usuario`: `guard_name = 'api'` ✅
    -   Permisos en BD: `guard_name = 'api'` ✅
    -   Roles en BD: `guard_name = 'api'` ✅
    -   Middleware: `auth('api')` ✅

-   **Spatie Permission cachea los permisos**: Siempre ejecuta `php artisan permission:cache-reset` después de cambiar permisos.

-   **El método `assignRole()`** en `UsuariosTableSeeder` funciona correctamente porque el modelo `Usuario` ya tiene `guard_name = 'api'` definido.
