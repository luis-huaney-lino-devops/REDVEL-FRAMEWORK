# Comandos para Corregir Permisos

## ⚠️ Problema

Los permisos fueron creados con `guard_name = 'web'` pero el sistema usa `guard_name = 'api'`.

## ✅ Solución Rápida

Ejecuta estos comandos en orden:

```bash
cd RedBack

# 1. Limpiar caché de permisos de Spatie
php artisan permission:cache-reset

# 2. Ejecutar el seeder actualizado (creará permisos con guard 'api')
php artisan db:seed --class=RolesAndPermissionsSeeder

# 3. Limpiar caché nuevamente
php artisan permission:cache-reset

# 4. Limpiar caché general de Laravel
php artisan config:clear
php artisan cache:clear
```

## 🔍 Verificar que Funcionó

```bash
php artisan tinker
```

Luego ejecuta:

```php
use Spatie\Permission\Models\Permission;
Permission::where('guard_name', 'api')->pluck('name');
```

Deberías ver: `['personas.view', 'personas.create', ..., 'usuarios.view', ...]`

## 🚀 Probar la Ruta

Ahora la ruta `/api/usuarios` debería funcionar correctamente si el usuario tiene el permiso `usuarios.view`.
