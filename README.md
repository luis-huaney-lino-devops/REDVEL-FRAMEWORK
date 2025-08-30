# REDVEL FRAMEWORK

<div align="center">

<img src="https://raw.githubusercontent.com/luis-huaney-lino-devops/REDVEL-FRAMEWORK/2bba4caeea635812a1972124326697754dac2fdb/RedBack/public/logo/Redvel.svg" width="150" height="150" style="border-radius: 50%; border: 3px solid red;">

**Framework Full Stack Moderno para Desarrollo Web Rápido y Escalable**

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![React](https://img.shields.io/badge/React-19-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://reactjs.org)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.0-3178C6?style=for-the-badge&logo=typescript&logoColor=white)](https://www.typescriptlang.org)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)

</div>

---

## 👨‍💻 Desarrollador

<div align="center">

<img src="https://avatars.githubusercontent.com/u/178603947?v=4" alt="Luis Huaney Lino" width="150" height="150" style="border-radius: 50%; border: 3px solid #4338ca;">

### **Luis Huaney Lino**

**Full Stack Developer & DevOps Engineer**

_"Desarrollé REDVEL para simplificar la creación de aplicaciones web robustas y escalables, proporcionando herramientas modernas que aceleren el desarrollo sin comprometer la calidad."_

📧 **Email:** martinlinohuaney@gmail.com  
📱 **WhatsApp:** +51 946 587 273  
🌐 **GitHub:** [luis-huaney-lino-devops](https://github.com/luis-huaney-lino-devops)

**¿Tienes ideas para nuevas funcionalidades o necesitas soporte personalizado?**  
¡No dudes en contactarme! Estoy disponible para colaboraciones y mejoras del framework.

</div>

---

## 🎯 ¿Qué es REDVEL?

**REDVEL** es un framework full stack que combina lo mejor de **Laravel** y **React** para crear aplicaciones web modernas, seguras y escalables. Diseñado para desarrolladores que buscan:

- ⚡ **Desarrollo rápido** sin sacrificar calidad
- 🔒 **Seguridad robusta** con JWT y control de permisos granular
- 🎨 **UI moderna** y responsive por defecto
- 🛠️ **Herramientas automatizadas** para tareas repetitivas
- 📚 **Documentación completa** y fácil mantenimiento

---

## 📋 Tabla de Contenidos

<div style="columns: 2; gap: 2rem;">

- [🚀 Inicio Rápido](#-inicio-rápido)
- [✨ Características](#-características-principales)
- [🏗️ Arquitectura](#️-arquitectura-del-sistema)
- [🔐 Autenticación](#-sistema-de-autenticación)
- [👥 Roles y Permisos](#-sistema-de-permisos-y-roles)
- [🎨 Frontend](#-frontend---redfront)
- [🔧 Backend](#-backend---redback)
- [💾 Sistema de Caché](#-sistema-de-caché)
- [🛡️ Protección de Rutas](#️-protección-de-rutas)
- [🌐 Traducción](#-traducción-automática)
- [🎯 Gestor REDVEL](#-gestor-de-paquetes-redvel)
- [⚙️ Configuración](#️-configuración-del-entorno)
- [📚 Documentación API](#-documentación-api)
- [🤝 Contribuir](#-contribución)

</div>

---

## ✨ Características Principales

<div align="center">

|         🔐 **Autenticación JWT**         |  👥 **Control de Acceso**   |        🎨 **UI Moderna**         |
| :--------------------------------------: | :-------------------------: | :------------------------------: |
| Tokens seguros con renovación automática | Roles y permisos granulares | React 19 + TypeScript + Tailwind |

|         📱 **Responsive**          |   🔄 **Caché Inteligente**    |    🌐 **Multi-idioma**     |
| :--------------------------------: | :---------------------------: | :------------------------: |
| Adaptable a todos los dispositivos | Sistema TTL para optimización | Google Translate integrado |

|     🛡️ **Protección Total**      |   📊 **Dashboard Dinámico**   |       🔧 **Automatización**       |
| :------------------------------: | :---------------------------: | :-------------------------------: |
| Middleware en frontend y backend | Generación basada en permisos | Scripts y comandos personalizados |

</div>

---

## 🚀 Inicio Rápido

### 📋 Requisitos Previos

<div align="center">

|                                       Herramienta                                       | Versión Mínima | Estado |
| :-------------------------------------------------------------------------------------: | :------------: | :----: |
|        ![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)         |      8.2+      |   ✅   |
|   ![Node.js](https://img.shields.io/badge/Node.js-22+-339933?style=flat&logo=node.js)   |     22.0+      |   ✅   |
|     ![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql)      |      8.0+      |   ✅   |
| ![Composer](https://img.shields.io/badge/Composer-2.0+-885630?style=flat&logo=composer) |      2.0+      |   ✅   |

</div>

### ⚡ Instalación Automática (Windows)

```bash
# 1. Descargar el instalador
curl -O https://github.com/luis-huaney-lino-devops/REDVEL-FRAMEWORK/raw/refs/heads/main/redvel.exe

# 2. Ejecutar instalación completa
redvel install

# 3. Iniciar servidores
redvel run
```

### 🐧 Instalación Manual (Linux/macOS)

```bash
# 1. Clonar repositorio
git clone https://github.com/luis-huaney-lino-devops/REDVEL-FRAMEWORK.git
cd REDVEL-FRAMEWORK

# 2. Backend
cd RedBack
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# 3. Frontend
cd ../RedFront
npm install

# 4. Configurar base de datos en .env y ejecutar
php artisan migrate --seed
php artisan serve &
npm run dev
```

### 🌐 URLs de Acceso

- **🔧 Backend:** http://localhost:8000
- **⚛️ Frontend:** http://localhost:3000
- **📚 API Docs:** http://localhost:8000/api/documentation
- **🚀 Instalador:** http://localhost:8000/install

---

## 🏗️ Arquitectura del Sistema

<div align="center">

```mermaid
graph TD
    A[🌐 Cliente Web] --> B[⚛️ React Frontend]
    B --> C[🔧 Laravel Backend]
    C --> D[🗄️ MySQL Database]

    B --> E[🔐 JWT Auth]
    C --> F[👥 Spatie Permissions]
    C --> G[💾 Cache System]
    C --> H[🌐 Google Translate]

    I[🎯 REDVEL CLI] --> B
    I --> C
    I --> J[📦 Auto Installer]
```

</div>

### 📁 Estructura de Directorios

```
REDVEL-FRAMEWORK/
├── 🔧 RedBack/                 # Backend Laravel
│   ├── 📂 app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   └── Middleware/
│   ├── 📂 config/
│   ├── 📂 database/
│   │   ├── migrations/
│   │   └── seeders/
│   └── 📂 routes/
├── ⚛️ RedFront/               # Frontend React
│   ├── 📂 src/
│   │   ├── assets/
│   │   ├── components/
│   │   ├── pages/
│   │   └── hooks/
│   └── 📂 public/
├── 🎯 redvel.py               # CLI Manager
├── 🎯 redvel.exe              # Windows Installer
└── 📖 README.md
```

---

## 🔐 Sistema de Autenticación

### 🔒 JWT (JSON Web Tokens)

REDVEL utiliza JWT para autenticación segura y escalable:

<div align="center">

```mermaid
sequenceDiagram
    participant U as 👤 Usuario
    participant F as ⚛️ Frontend
    participant B as 🔧 Backend
    participant D as 🗄️ Database

    U->>F: 📝 Credenciales
    F->>B: 🔐 POST /api/login
    B->>D: ✅ Verificar usuario
    D-->>B: ✅ Usuario válido
    B-->>F: 🎫 JWT Token + Permisos
    F->>F: 💾 Guardar en localStorage

    Note over F,B: 🔄 Requests con token
    F->>B: 📡 API Request + JWT
    B->>B: ✅ Verificar token
    B-->>F: 📊 Respuesta autorizada
```

</div>

### ⚙️ Configuración JWT

```env
# Configuración en .env
JWT_SECRET=tu_clave_secreta_super_segura
JWT_TTL=60                    # 1 hora
TIEMPOSECION=60              # Tiempo de sesión
```

### 📡 Endpoints de Autenticación

```bash
POST   /api/login              # 🔐 Iniciar sesión
POST   /api/verificar-token    # ✅ Verificar token
POST   /api/renovar-token      # 🔄 Renovar token
POST   /api/logout             # 🚪 Cerrar sesión
```

---

## 👥 Sistema de Permisos y Roles

### 🎭 Roles del Sistema

REDVEL incluye un sistema flexible de roles para diferentes tipos de organizaciones:

<div align="center">

|         Rol          |        Descripción        | Nivel de Acceso |          Casos de Uso          |
| :------------------: | :-----------------------: | :-------------: | :----------------------------: |
|  🔧 **Super Admin**  | Control total del sistema |    **100%**     |  CTO, Administrador principal  |
| 👑 **Administrador** |      Gestión general      |     **90%**     |       Gerente, Director        |
|    👨‍💼 **Manager**    |  Supervisión de equipos   |     **70%**     |      Jefe de departamento      |
|    👨‍💻 **Editor**     |    Creación y edición     |     **60%**     | Content Manager, Desarrollador |
|    👁️ **Viewer**     |       Solo lectura        |     **30%**     |      Auditor, Consultante      |
|    🎓 **Usuario**    |       Acceso básico       |     **20%**     |     Cliente, Usuario final     |

</div>

### 🏷️ Categorías de Permisos

<details>
<summary><strong>👥 Gestión de Usuarios</strong></summary>

```php
// Usuarios - Administración de cuentas
'users.view'     → Ver listado de usuarios
'users.create'   → Crear nuevos usuarios
'users.edit'     → Editar información de usuarios
'users.delete'   → Eliminar usuarios
'users.restore'  → Restaurar usuarios eliminados
```

</details>

<details>
<summary><strong>📝 Gestión de Contenido</strong></summary>

```php
// Contenido - Posts, artículos, etc.
'content.view'     → Ver contenido
'content.create'   → Crear contenido
'content.edit'     → Editar contenido
'content.publish'  → Publicar contenido
'content.delete'   → Eliminar contenido
```

</details>

<details>
<summary><strong>📊 Reportes y Analytics</strong></summary>

```php
// Reportes - Estadísticas y métricas
'reports.view'      → Ver reportes básicos
'reports.advanced'  → Reportes avanzados
'reports.export'    → Exportar datos
'reports.create'    → Crear reportes personalizados
```

</details>

<details>
<summary><strong>⚙️ Configuración del Sistema</strong></summary>

```php
// Configuración - Ajustes del sistema
'config.view'    → Ver configuración
'config.edit'    → Modificar configuración
'config.system'  → Configuración del sistema
'config.security' → Configuración de seguridad
```

</details>

### 👤 Usuarios de Ejemplo

El sistema incluye usuarios predeterminados para testing y desarrollo:

<div align="center">

|    👤 Usuario    |     📧 Email     | 🔑 Contraseña |    🎭 Rol     |        💼 Perfil        |
| :--------------: | :--------------: | :-----------: | :-----------: | :---------------------: |
|   **john.doe**   | john@redvel.dev  |  `redvel123`  |  Super Admin  | Desarrollador Principal |
|  **jane.smith**  | jane@redvel.dev  |  `redvel123`  | Administrador |   Gerente de Proyecto   |
| **mike.johnson** | mike@redvel.dev  |  `redvel123`  |    Manager    |   Jefe de Desarrollo    |
| **anna.wilson**  | anna@redvel.dev  |  `redvel123`  |    Editor     |     Content Manager     |
|  **guest.user**  | guest@redvel.dev |  `redvel123`  |    Viewer     |   Usuario de Pruebas    |

</div>

### 🔧 Implementación de Roles

#### En el Seeder:

```php
// RolesAndPermissionsSeeder.php
class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 🎭 Crear Roles
        $roles = [
            'super_admin' => 'Control total del sistema',
            'admin' => 'Gestión general de la aplicación',
            'manager' => 'Supervisión de equipos y proyectos',
            'editor' => 'Creación y edición de contenido',
            'viewer' => 'Solo lectura de información',
            'user' => 'Acceso básico de usuario final'
        ];

        foreach ($roles as $role => $description) {
            Role::create([
                'name' => $role,
                'description' => $description
            ]);
        }

        // 🏷️ Crear Permisos por categorías
        $permissions = [
            'users' => ['view', 'create', 'edit', 'delete', 'restore'],
            'content' => ['view', 'create', 'edit', 'publish', 'delete'],
            'reports' => ['view', 'advanced', 'export', 'create'],
            'config' => ['view', 'edit', 'system', 'security']
        ];

        foreach ($permissions as $category => $actions) {
            foreach ($actions as $action) {
                Permission::create(['name' => "$category.$action"]);
            }
        }

        // 🔗 Asignar Permisos a Roles
        $superAdmin = Role::findByName('super_admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'users.view', 'users.create', 'users.edit',
            'content.view', 'content.create', 'content.edit', 'content.publish',
            'reports.view', 'reports.advanced', 'reports.export'
        ]);
    }
}
```

#### En el Controller:

```php
// Verificar permisos en controllers
class UserController extends Controller
{
    public function index()
    {
        // ✅ Verificar permiso específico
        if (!auth()->user()->can('users.view')) {
            return response()->json(['error' => 'Sin permisos'], 403);
        }

        return response()->json(['users' => User::all()]);
    }

    public function store(Request $request)
    {
        // ✅ Middleware de permisos
        $this->middleware('permission:users.create');

        // Lógica de creación...
    }
}
```

#### En el Frontend React:

```tsx
// Hook para verificar permisos
export function usePermissions() {
  const checkPermission = (permission: string): boolean => {
    const permissions = getPermissionsFromToken();
    return permissions.includes(permission);
  };

  return { checkPermission };
}

// Componente con permisos
export function UserManagement() {
  const { checkPermission } = usePermissions();

  return (
    <div>
      {checkPermission("users.view") && <UserList />}

      {checkPermission("users.create") && <CreateUserButton />}

      {checkPermission("users.edit") && <EditUserButton />}
    </div>
  );
}
```

---

## 🎨 Frontend - RedFront

### 🛠️ Stack Tecnológico

<div align="center">

![React](https://img.shields.io/badge/React-19-61DAFB?style=for-the-badge&logo=react&logoColor=black)
![TypeScript](https://img.shields.io/badge/TypeScript-5.0-3178C6?style=for-the-badge&logo=typescript&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5.0-646CFF?style=for-the-badge&logo=vite&logoColor=white)

</div>

### 📱 Características del Frontend

- **🎨 Diseño Moderno**: Interfaz limpia con Tailwind CSS
- **📱 Totalmente Responsive**: Adaptable a móviles, tablets y desktop
- **🔥 Hot Reload**: Desarrollo rápido con Vite
- **🧩 Componentes Reutilizables**: Arquitectura component-based
- **🎯 TypeScript**: Tipado estático para mayor confiabilidad
- **🚀 Optimización**: Bundle optimizado para producción

### 🧩 Componentes Principales

#### 🔐 Sistema de Autenticación

```tsx
// Componente de Login
export function LoginForm() {
  const [credentials, setCredentials] = useState({
    username: "",
    password: "",
  });

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();

    try {
      const response = await authAPI.login(credentials);

      // 💾 Guardar token y permisos
      localStorage.setItem("token", response.token);
      localStorage.setItem("permissions", JSON.stringify(response.permissions));

      // 🎉 Notificación de éxito
      toast.success("¡Bienvenido a REDVEL!");
      navigate("/dashboard");
    } catch (error) {
      toast.error("Credenciales incorrectas");
    }
  };

  return (
    <form onSubmit={handleLogin} className="space-y-6">
      <div>
        <label className="block text-sm font-medium text-gray-700">
          Usuario
        </label>
        <input
          type="text"
          value={credentials.username}
          onChange={(e) =>
            setCredentials({
              ...credentials,
              username: e.target.value,
            })
          }
          className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        />
      </div>

      <button
        type="submit"
        className="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        🔐 Iniciar Sesión
      </button>
    </form>
  );
}
```

#### 🛡️ Protección de Rutas

```tsx
// Componente de ruta protegida
export function ProtectedRoute({
  children,
  requiredPermissions = [],
}: ProtectedRouteProps) {
  const location = useLocation();
  const { checkPermission } = usePermissions();

  // ✅ Verificar sesión válida
  if (!checkSession()) {
    toast.error("Sesión expirada. Por favor, inicia sesión nuevamente.");
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  // ✅ Verificar permisos específicos
  if (requiredPermissions.length > 0) {
    const hasPermission = requiredPermissions.every((permission) =>
      checkPermission(permission)
    );

    if (!hasPermission) {
      toast.error("No tienes permisos para acceder a esta página.");
      return <Navigate to="/403" state={{ from: location }} replace />;
    }
  }

  return <>{children}</>;
}
```

#### 🎯 Hook de Permisos

```tsx
// Custom hook para manejo de permisos
export function usePermissions() {
  const [permissions, setPermissions] = useState<string[]>([]);

  useEffect(() => {
    const userPermissions = getPermissionsFromToken();
    setPermissions(userPermissions);
  }, []);

  const checkPermission = useCallback(
    (permission: string): boolean => {
      return permissions.includes(permission);
    },
    [permissions]
  );

  const checkMultiplePermissions = useCallback(
    (permissionList: string[], requireAll: boolean = false): boolean => {
      if (requireAll) {
        return permissionList.every((permission) =>
          permissions.includes(permission)
        );
      }
      return permissionList.some((permission) =>
        permissions.includes(permission)
      );
    },
    [permissions]
  );

  const executeWithPermission = useCallback(
    <T,>(
      permission: string,
      action: () => T,
      errorMessage?: string
    ): T | null => {
      if (checkPermission(permission)) {
        return action();
      }

      if (errorMessage) {
        toast.error(errorMessage);
      }

      return null;
    },
    [checkPermission]
  );

  return {
    permissions,
    checkPermission,
    checkMultiplePermissions,
    executeWithPermission,
  };
}
```

---

## 🔧 Backend - RedBack

### 🛠️ Stack Tecnológico

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=for-the-badge&logo=json-web-tokens&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

</div>

### 🏗️ Arquitectura del Backend

#### 📡 API Routes Principales

```php
// routes/api.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ValidateController;

// 🌐 Rutas públicas
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});

Route::post('/login', [LoginController::class, 'login']);

// 🔐 Rutas autenticadas
Route::middleware(['check.jwt'])->group(function () {
    // Autenticación
    Route::post('/verificar-token', [ValidateController::class, 'verificarToken']);
    Route::post('/renovar-token', [ValidateController::class, 'renovarToken']);
    Route::post('/logout', [ValidateController::class, 'logout']);

    // 👥 Usuarios (requiere permisos específicos)
    Route::middleware(['check.permission:users.view'])->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
    });

    Route::middleware(['check.permission:users.create'])->group(function () {
        Route::post('/users', [UserController::class, 'store']);
    });

    Route::middleware(['check.permission:users.edit'])->group(function () {
        Route::put('/users/{id}', [UserController::class, 'update']);
    });

    Route::middleware(['check.permission:users.delete'])->group(function () {
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });
});
```

#### 🔒 Middleware de Autenticación JWT

```php
// app/Http/Middleware/CheckJwtMiddleware.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CheckJwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // ✅ Verificar y decodificar token
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'error' => 'Usuario no encontrado',
                    'code' => 'USER_NOT_FOUND'
                ], 401);
            }

            // ✅ Verificar si el usuario está activo
            if (!$user->activo) {
                return response()->json([
                    'error' => 'Usuario inactivo',
                    'code' => 'USER_INACTIVE'
                ], 401);
            }

            // 📝 Registrar actividad del usuario
            $user->update(['ultima_actividad' => now()]);

        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Token inválido o expirado',
                'code' => 'TOKEN_INVALID',
                'message' => $e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}
```

#### 🛡️ Middleware de Permisos

```php
// app/Http/Middleware/CheckPermissionMiddleware.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();

        // ✅ Verificar si el usuario tiene el permiso
        if (!$user->can($permission)) {
            return response()->json([
                'error' => 'No tienes permisos para realizar esta acción',
                'required_permission' => $permission,
                'user_permissions' => $user->getAllPermissions()->pluck('name'),
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        // 📝 Log de actividad con permisos
        \Log::info("User {$user->id} accessed resource with permission: {$permission}");

        return $next($request);
    }
}
```

#### 👤 Modelo Usuario Mejorado

```php
// app/Models/Usuario.php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasRoles, SoftDeletes;

    protected $fillable = [
        'nomusu',
        'email',
        'password',
        'activo',
        'ultimo_login',
        'ultima_actividad',
        'intentos_login',
        'bloqueado_hasta'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'ultimo_login' => 'datetime',
        'ultima_actividad' => 'datetime',
        'bloqueado_hasta' => 'datetime',
        'intentos_login' => 'integer'
    ];

    // 🎫 JWT Methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'user_id' => $this->id,
            'username' => $this->nomusu,
            'email' => $this->email,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'last_login' => $this->ultimo_login?->toISOString(),
            'is_active' => $this->activo
        ];
    }

    // 🔐 Security Methods
    public function incrementLoginAttempts()
    {
        $this->increment('intentos_login');

        if ($this->intentos_login >= 5) {
            $this->update([
                'bloqueado_hasta' => now()->addMinutes(30)
            ]);
        }
    }

    public function resetLoginAttempts()
    {
        $this->update([
            'intentos_login' => 0,
            'bloqueado_hasta' => null,
            'ultimo_login' => now()
        ]);
    }

    public function isBlocked(): bool
    {
        return $this->bloqueado_hasta && $this->bloqueado_hasta->isFuture();
    }

    // 🔗 Relationships
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'fk_idpersonas');
    }

    // 📊 Scopes
    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

    public function scopeNotBlocked($query)
    {
        return $query->where(function($q) {
            $q->whereNull('bloqueado_hasta')
              ->orWhere('bloqueado_hasta', '<', now());
        });
    }
}
```

---

## 💾 Sistema de Caché

### 🚀 Caché Inteligente con TTL

REDVEL implementa un sistema de caché inteligente que optimiza el rendimiento y mejora la experiencia del usuario:

<div align="center">

```mermaid
graph LR
    A[🌐 Request] --> B{💾 Cache?}
    B -->|✅ Hit| C[📤 Cached Data]
    B -->|❌ Miss| D[🔍 Fetch Data]
    D --> E[💾 Store Cache]
    E --> F[📤 Fresh Data]

    G[⏰ TTL Expired] --> H[🗑️ Remove Cache]
```

</div>

### 🛠️ Implementación del Caché

```typescript
// lib/cache.ts
interface CacheItem {
  value: any;
  timestamp: number;
  ttl: number;
}

export class CacheManager {
  private static instance: CacheManager;
  private cache: Map<string, CacheItem> = new Map();

  public static getInstance(): CacheManager {
    if (!CacheManager.instance) {
      CacheManager.instance = new CacheManager();
    }
    return CacheManager.instance;
  }

  /**
   * 💾 Almacenar datos en caché
   */
  set(key: string, value: any, ttlMinutes: number = 10): void {
    const ttl = ttlMinutes * 60 * 1000; // Convertir a milisegundos

    try {
      const cacheItem: CacheItem = {
        value,
        timestamp: Date.now(),
        ttl,
      };

      // 💾 Memoria
      this.cache.set(key, cacheItem);

      // 💾 LocalStorage para persistencia
      localStorage.setItem(`cache_${key}`, JSON.stringify(cacheItem));
    } catch (error) {
      console.warn("Error al guardar en caché:", error);
    }
  }

  /**
   * 📤 Obtener datos del caché
   */
  get(key: string): any | null {
    try {
      // 🔍 Buscar en memoria primero
      let cacheItem = this.cache.get(key);

      // 🔍 Si no está en memoria, buscar en localStorage
      if (!cacheItem) {
        const stored = localStorage.getItem(`cache_${key}`);
        if (stored) {
          cacheItem = JSON.parse(stored);
          this.cache.set(key, cacheItem); // Restaurar a memoria
        }
      }

      if (!cacheItem) return null;

      // ⏰ Verificar expiración
      const now = Date.now();
      if (now - cacheItem.timestamp > cacheItem.ttl) {
        this.remove(key);
        return null;
      }

      return cacheItem.value;
    } catch (error) {
      console.warn("Error al leer caché:", error);
      return null;
    }
  }

  /**
   * 🗑️ Eliminar del caché
   */
  remove(key: string): void {
    this.cache.delete(key);
    localStorage.removeItem(`cache_${key}`);
  }

  /**
   * 🧹 Limpiar caché expirado
   */
  cleanup(): void {
    const now = Date.now();

    for (const [key, item] of this.cache.entries()) {
      if (now - item.timestamp > item.ttl) {
        this.remove(key);
      }
    }
  }

  /**
   * 🔄 Obtener o ejecutar función
   */
  async getOrSet<T>(
    key: string,
    fetchFn: () => Promise<T>,
    ttlMinutes: number = 10
  ): Promise<T> {
    // 📤 Intentar obtener del caché
    const cached = this.get(key);
    if (cached !== null) {
      return cached;
    }

    // 🔍 Ejecutar función y cachear resultado
    const result = await fetchFn();
    this.set(key, result, ttlMinutes);
    return result;
  }
}

// 🎯 Instancia singleton
export const cache = CacheManager.getInstance();

// 🧹 Limpieza automática cada 5 minutos
setInterval(() => {
  cache.cleanup();
}, 5 * 60 * 1000);
```

### 🎯 Uso Práctico del Caché

```typescript
// Ejemplo de uso en componentes React
export function useUserData(userId: string) {
  const [userData, setUserData] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchUserData = async () => {
      try {
        // 💾 Intentar obtener del caché primero
        const cachedUser = cache.get(`user_${userId}`);

        if (cachedUser) {
          setUserData(cachedUser);
          setLoading(false);
          return;
        }

        // 🔍 Si no hay caché, hacer request
        const response = await fetch(`/api/users/${userId}`);
        const user = await response.json();

        // 💾 Cachear por 15 minutos
        cache.set(`user_${userId}`, user, 15);
        setUserData(user);
      } catch (error) {
        console.error("Error fetching user:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchUserData();
  }, [userId]);

  return { userData, loading };
}
```

### ⚙️ Configuración de Caché

```typescript
// constants/cache.ts
export const CACHE_CONFIG = {
  // ⏰ Tiempos de vida (en minutos)
  TTL: {
    USER_DATA: 15, // Datos de usuario
    PERMISSIONS: 30, // Permisos del usuario
    MENU_DATA: 60, // Datos del menú
    REPORTS: 5, // Reportes dinámicos
    STATIC_DATA: 120, // Datos estáticos
  },

  // 🔑 Claves de caché
  KEYS: {
    USER_PREFIX: "user_",
    PERMISSIONS_PREFIX: "permissions_",
    MENU_PREFIX: "menu_",
    TOKEN_VERIFICATION: "token_verification",
    DASHBOARD_DATA: "dashboard_data",
  },
};

// Uso con configuración
cache.set(
  CACHE_CONFIG.KEYS.USER_PREFIX + userId,
  userData,
  CACHE_CONFIG.TTL.USER_DATA
);
```

---

## 🛡️ Protección de Rutas

### 🔒 Frontend - React Router Protection

```tsx
// components/ProtectedRoute.tsx
import React from "react";
import { Navigate, useLocation } from "react-router-dom";
import { toast } from "react-hot-toast";
import { useAuth } from "../hooks/useAuth";
import { usePermissions } from "../hooks/usePermissions";

interface ProtectedRouteProps {
  children: React.ReactNode;
  requiredPermissions?: string[];
  requiredRoles?: string[];
  requireAll?: boolean;
  fallbackPath?: string;
}

export const ProtectedRoute: React.FC<ProtectedRouteProps> = ({
  children,
  requiredPermissions = [],
  requiredRoles = [],
  requireAll = false,
  fallbackPath = "/403",
}) => {
  const location = useLocation();
  const { isAuthenticated, user } = useAuth();
  const { checkPermission, checkRole } = usePermissions();

  // 🔐 Verificar autenticación
  if (!isAuthenticated) {
    toast.error("🔒 Debes iniciar sesión para acceder a esta página");
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  // 👤 Verificar si el usuario está activo
  if (!user?.activo) {
    toast.error("❌ Tu cuenta está inactiva. Contacta al administrador.");
    return <Navigate to="/inactive" state={{ from: location }} replace />;
  }

  // 🛡️ Verificar permisos
  if (requiredPermissions.length > 0) {
    const hasPermissions = requireAll
      ? requiredPermissions.every((permission) => checkPermission(permission))
      : requiredPermissions.some((permission) => checkPermission(permission));

    if (!hasPermissions) {
      toast.error("🚫 No tienes permisos para acceder a esta página");
      return <Navigate to={fallbackPath} state={{ from: location }} replace />;
    }
  }

  // 🎭 Verificar roles
  if (requiredRoles.length > 0) {
    const hasRoles = requireAll
      ? requiredRoles.every((role) => checkRole(role))
      : requiredRoles.some((role) => checkRole(role));

    if (!hasRoles) {
      toast.error("🎭 Tu rol no tiene acceso a esta funcionalidad");
      return <Navigate to={fallbackPath} state={{ from: location }} replace />;
    }
  }

  return <>{children}</>;
};
```

### 🚦 Configuración de Rutas

```tsx
// App.tsx
function App() {
  return (
    <Router>
      <Routes>
        {/* 🌐 Rutas públicas */}
        <Route path="/" element={<HomePage />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/403" element={<ForbiddenPage />} />
        <Route path="/inactive" element={<InactivePage />} />

        {/* 🔒 Rutas protegidas básicas */}
        <Route
          path="/dashboard"
          element={
            <ProtectedRoute>
              <DashboardLayout />
            </ProtectedRoute>
          }
        >
          {/* 👥 Gestión de usuarios - Solo admins */}
          <Route
            path="users"
            element={
              <ProtectedRoute
                requiredRoles={["super_admin", "admin"]}
                fallbackPath="/dashboard"
              >
                <UsersPage />
              </ProtectedRoute>
            }
          />

          {/* 📊 Reportes - Múltiples permisos */}
          <Route
            path="reports"
            element={
              <ProtectedRoute
                requiredPermissions={["reports.view", "reports.advanced"]}
                requireAll={false} // Solo necesita uno de los permisos
              >
                <ReportsPage />
              </ProtectedRoute>
            }
          />

          {/* ⚙️ Configuración - Permisos específicos */}
          <Route
            path="settings"
            element={
              <ProtectedRoute
                requiredPermissions={["config.view", "config.edit"]}
                requireAll={true} // Necesita ambos permisos
              >
                <SettingsPage />
              </ProtectedRoute>
            }
          />
        </Route>

        {/* 🚫 Ruta 404 */}
        <Route path="*" element={<NotFoundPage />} />
      </Routes>
    </Router>
  );
}
```

### 🔧 Backend - Laravel Middleware

```php
// routes/api.php
Route::middleware(['auth:api', 'check.jwt'])->group(function () {

    // 👥 Rutas de usuarios con diferentes niveles de permisos
    Route::prefix('users')->group(function () {

        // 👁️ Ver usuarios - Permiso básico
        Route::get('/', [UserController::class, 'index'])
            ->middleware('permission:users.view');

        // 📝 Crear usuario - Permiso específico
        Route::post('/', [UserController::class, 'store'])
            ->middleware('permission:users.create');

        // ✏️ Editar usuario - Permiso + verificación de propiedad
        Route::put('/{id}', [UserController::class, 'update'])
            ->middleware(['permission:users.edit', 'check.ownership:user']);

        // 🗑️ Eliminar usuario - Solo super admin
        Route::delete('/{id}', [UserController::class, 'destroy'])
            ->middleware('role:super_admin');
    });

    // 📊 Rutas de reportes con permisos graduales
    Route::prefix('reports')->group(function () {

        // 📈 Reportes básicos
        Route::get('/basic', [ReportController::class, 'basic'])
            ->middleware('permission:reports.view');

        // 📊 Reportes avanzados
        Route::get('/advanced', [ReportController::class, 'advanced'])
            ->middleware('permission:reports.advanced');

        // 💾 Exportar reportes
        Route::post('/export', [ReportController::class, 'export'])
            ->middleware(['permission:reports.export', 'throttle:5,1']); // 5 por minuto
    });

    // ⚙️ Rutas de configuración - Múltiples verificaciones
    Route::prefix('config')->middleware('role:admin|super_admin')->group(function () {

        Route::get('/', [ConfigController::class, 'index'])
            ->middleware('permission:config.view');

        Route::put('/', [ConfigController::class, 'update'])
            ->middleware(['permission:config.edit', 'validate.config']);

        // 🔒 Configuración crítica - Solo super admin
        Route::put('/system', [ConfigController::class, 'updateSystem'])
            ->middleware(['role:super_admin', 'permission:config.system']);
    });
});
```

### 🛡️ Middleware Personalizado de Verificación de Propiedad

```php
// app/Http/Middleware/CheckOwnershipMiddleware.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOwnershipMiddleware
{
    public function handle(Request $request, Closure $next, string $resource)
    {
        $user = auth()->user();
        $resourceId = $request->route('id');

        switch ($resource) {
            case 'user':
                // ✅ Los usuarios solo pueden editar su propio perfil (a menos que sean admin)
                if (!$user->hasRole(['admin', 'super_admin']) && $user->id != $resourceId) {
                    return response()->json([
                        'error' => 'Solo puedes editar tu propio perfil',
                        'code' => 'OWNERSHIP_VIOLATION'
                    ], 403);
                }
                break;

            case 'content':
                // ✅ Los creadores solo pueden editar su propio contenido
                $content = \App\Models\Content::find($resourceId);
                if ($content && $content->creator_id !== $user->id && !$user->hasRole('admin')) {
                    return response()->json([
                        'error' => 'Solo puedes editar tu propio contenido',
                        'code' => 'CONTENT_OWNERSHIP_VIOLATION'
                    ], 403);
                }
                break;
        }

        return $next($request);
    }
}
```

---

## 🌐 Traducción Automática

### 🗣️ Sistema Multi-idioma con Google Translate

REDVEL incluye un potente sistema de traducción que permite internacionalizar la aplicación fácilmente:

<div align="center">

![Google Translate](https://img.shields.io/badge/Google_Translate-4285F4?style=for-the-badge&logo=google-translate&logoColor=white)
![Multi Language](https://img.shields.io/badge/Multi_Language-Success-28a745?style=for-the-badge&logo=language&logoColor=white)

</div>

### 🛠️ Implementación Backend

```php
// app/Http/Controllers/TraduccionController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class TraduccionController extends Controller
{
    private $supportedLanguages = [
        'es' => 'Español',
        'en' => 'English',
        'fr' => 'Français',
        'de' => 'Deutsch',
        'it' => 'Italiano',
        'pt' => 'Português',
        'ja' => '日本語',
        'ko' => '한국어',
        'zh' => '中文'
    ];

    /**
     * 🌐 Traducir texto
     */
    public function traducir(Request $request)
    {
        // 📝 Validación
        $validator = Validator::make($request->all(), [
            'texto' => 'required|string|max:5000',
            'from' => 'nullable|string|in:' . implode(',', array_keys($this->supportedLanguages)),
            'to' => 'required|string|in:' . implode(',', array_keys($this->supportedLanguages))
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Datos de entrada inválidos',
                'details' => $validator->errors()
            ], 422);
        }

        $texto = $request->input('texto');
        $from = $request->input('from', 'auto');
        $to = $request->input('to');

        // 🔑 Crear clave de caché
        $cacheKey = "translation_" . md5($texto . $from . $to);

        try {
            // 💾 Verificar caché primero
            $traduccion = Cache::remember($cacheKey, 3600, function () use ($texto, $from, $to) {
                $translator = new GoogleTranslate();
                $translator->setSource($from);
                $translator->setTarget($to);

                return $translator->translate($texto);
            });

            // 📊 Registrar uso de traducción
            $this->logTranslationUsage($request->user(), $from, $to, strlen($texto));

            return response()->json([
                'success' => true,
                'data' => [
                    'texto_original' => $texto,
                    'texto_traducido' => $traduccion,
                    'idioma_origen' => $from,
                    'idioma_destino' => $to,
                    'idioma_origen_nombre' => $this->supportedLanguages[$from] ?? 'Automático',
                    'idioma_destino_nombre' => $this->supportedLanguages[$to],
                    'cached' => Cache::has($cacheKey)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en la traducción',
                'message' => $e->getMessage(),
                'code' => 'TRANSLATION_ERROR'
            ], 500);
        }
    }

    /**
     * 📋 Obtener idiomas soportados
     */
    public function idiomasSoportados()
    {
        return response()->json([
            'idiomas' => $this->supportedLanguages,
            'total' => count($this->supportedLanguages)
        ]);
    }

    /**
     * 🔍 Detectar idioma automáticamente
     */
    public function detectarIdioma(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'texto' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Texto requerido'], 422);
        }

        try {
            $translator = new GoogleTranslate();
            $translator->setSource('auto');
            $translator->setTarget('en');

            // Traducir para detectar el idioma
            $translator->translate($request->texto);
            $detectedLang = $translator->getLastDetectedSource();

            return response()->json([
                'idioma_detectado' => $detectedLang,
                'idioma_nombre' => $this->supportedLanguages[$detectedLang] ?? 'Desconocido',
                'confianza' => 'alta' // Google Translate no proporciona score de confianza
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error detectando idioma',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 📊 Registrar uso de traducción
     */
    private function logTranslationUsage($user, $from, $to, $textLength)
    {
        // Aquí podrías guardar estadísticas de uso
        \Log::info('Translation used', [
            'user_id' => $user?->id,
            'from' => $from,
            'to' => $to,
            'text_length' => $textLength,
            'timestamp' => now()
        ]);
    }
}
```

### 🌍 Frontend - Hook de Traducción

```typescript
// hooks/useTranslation.ts
import { useState, useCallback } from "react";
import { toast } from "react-hot-toast";

interface TranslationResult {
  texto_original: string;
  texto_traducido: string;
  idioma_origen: string;
  idioma_destino: string;
  idioma_origen_nombre: string;
  idioma_destino_nombre: string;
  cached: boolean;
}

interface UseTranslationReturn {
  translate: (
    text: string,
    from: string,
    to: string
  ) => Promise<TranslationResult | null>;
  detectLanguage: (text: string) => Promise<string | null>;
  getSupportedLanguages: () => Promise<Record<string, string> | null>;
  isLoading: boolean;
  error: string | null;
}

export function useTranslation(): UseTranslationReturn {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  /**
   * 🌐 Traducir texto
   */
  const translate = useCallback(
    async (
      text: string,
      from: string = "auto",
      to: string = "es"
    ): Promise<TranslationResult | null> => {
      if (!text.trim()) {
        setError("El texto no puede estar vacío");
        return null;
      }

      setIsLoading(true);
      setError(null);

      try {
        const response = await fetch("/api/traduccion", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
          body: JSON.stringify({
            texto: text,
            from,
            to,
          }),
        });

        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.error || "Error en la traducción");
        }

        // 🎉 Mostrar notificación de éxito
        toast.success(`Traducido ${data.data.cached ? "(desde caché)" : ""}`, {
          icon: "🌐",
        });

        return data.data;
      } catch (err) {
        const errorMessage =
          err instanceof Error ? err.message : "Error desconocido";
        setError(errorMessage);
        toast.error(`Error: ${errorMessage}`);
        return null;
      } finally {
        setIsLoading(false);
      }
    },
    []
  );

  /**
   * 🔍 Detectar idioma
   */
  const detectLanguage = useCallback(
    async (text: string): Promise<string | null> => {
      if (!text.trim()) return null;

      setIsLoading(true);
      setError(null);

      try {
        const response = await fetch("/api/detectar-idioma", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
          body: JSON.stringify({ texto: text }),
        });

        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.error || "Error detectando idioma");
        }

        return data.idioma_detectado;
      } catch (err) {
        const errorMessage =
          err instanceof Error ? err.message : "Error desconocido";
        setError(errorMessage);
        return null;
      } finally {
        setIsLoading(false);
      }
    },
    []
  );

  /**
   * 📋 Obtener idiomas soportados
   */
  const getSupportedLanguages = useCallback(async (): Promise<Record<
    string,
    string
  > | null> => {
    try {
      const response = await fetch("/api/idiomas-soportados");
      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.error || "Error obteniendo idiomas");
      }

      return data.idiomas;
    } catch (err) {
      const errorMessage =
        err instanceof Error ? err.message : "Error desconocido";
      setError(errorMessage);
      return null;
    }
  }, []);

  return {
    translate,
    detectLanguage,
    getSupportedLanguages,
    isLoading,
    error,
  };
}
```

### 🎨 Componente de Traducción

```tsx
// components/TranslationWidget.tsx
import React, { useState, useEffect } from "react";
import { Languages, ArrowRightLeft, Volume2, Copy, Loader } from "lucide-react";
import { useTranslation } from "../hooks/useTranslation";
import { toast } from "react-hot-toast";

export function TranslationWidget() {
  const [sourceText, setSourceText] = useState("");
  const [translatedText, setTranslatedText] = useState("");
  const [sourceLang, setSourceLang] = useState("auto");
  const [targetLang, setTargetLang] = useState("es");
  const [supportedLanguages, setSupportedLanguages] = useState<
    Record<string, string>
  >({});

  const { translate, detectLanguage, getSupportedLanguages, isLoading } =
    useTranslation();

  // 🌍 Cargar idiomas soportados al inicializar
  useEffect(() => {
    const loadLanguages = async () => {
      const languages = await getSupportedLanguages();
      if (languages) {
        setSupportedLanguages({
          auto: "Detectar automáticamente",
          ...languages,
        });
      }
    };
    loadLanguages();
  }, [getSupportedLanguages]);

  // 🔄 Manejar traducción
  const handleTranslate = async () => {
    if (!sourceText.trim()) {
      toast.error("Ingresa texto para traducir");
      return;
    }

    const result = await translate(sourceText, sourceLang, targetLang);
    if (result) {
      setTranslatedText(result.texto_traducido);
    }
  };

  // 🔍 Detectar idioma automáticamente
  const handleDetectLanguage = async () => {
    if (!sourceText.trim()) return;

    const detectedLang = await detectLanguage(sourceText);
    if (detectedLang && detectedLang !== sourceLang) {
      setSourceLang(detectedLang);
      toast.success(
        `Idioma detectado: ${supportedLanguages[detectedLang] || detectedLang}`
      );
    }
  };

  // 🔄 Intercambiar idiomas
  const swapLanguages = () => {
    if (sourceLang === "auto") return;

    setSourceLang(targetLang);
    setTargetLang(sourceLang);
    setSourceText(translatedText);
    setTranslatedText(sourceText);
  };

  // 📋 Copiar texto
  const copyText = (text: string, type: "source" | "target") => {
    navigator.clipboard.writeText(text);
    toast.success(
      `${type === "source" ? "Texto original" : "Traducción"} copiada`
    );
  };

  return (
    <div className="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
      {/* 📋 Header */}
      <div className="flex items-center gap-2 mb-6">
        <Languages className="h-6 w-6 text-blue-600" />
        <h2 className="text-2xl font-bold text-gray-800">Traductor REDVEL</h2>
      </div>

      {/* 🌐 Selectores de idioma */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        {/* Idioma origen */}
        <select
          value={sourceLang}
          onChange={(e) => setSourceLang(e.target.value)}
          className="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          {Object.entries(supportedLanguages).map(([code, name]) => (
            <option key={code} value={code}>
              {name}
            </option>
          ))}
        </select>

        {/* Botón intercambiar */}
        <button
          onClick={swapLanguages}
          disabled={sourceLang === "auto"}
          className="flex items-center justify-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
        >
          <ArrowRightLeft className="h-4 w-4" />
          Intercambiar
        </button>

        {/* Idioma destino */}
        <select
          value={targetLang}
          onChange={(e) => setTargetLang(e.target.value)}
          className="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          {Object.entries(supportedLanguages)
            .filter(([code]) => code !== "auto")
            .map(([code, name]) => (
              <option key={code} value={code}>
                {name}
              </option>
            ))}
        </select>
      </div>

      {/* 📝 Áreas de texto */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Texto origen */}
        <div className="space-y-2">
          <div className="flex justify-between items-center">
            <label className="text-sm font-medium text-gray-700">
              Texto a traducir
            </label>
            <div className="flex gap-2">
              <button
                onClick={handleDetectLanguage}
                className="text-xs text-blue-600 hover:underline"
                disabled={!sourceText.trim()}
              >
                🔍 Detectar idioma
              </button>
              <button
                onClick={() => copyText(sourceText, "source")}
                className="text-xs text-gray-600 hover:text-gray-800"
                disabled={!sourceText.trim()}
              >
                <Copy className="h-3 w-3" />
              </button>
            </div>
          </div>

          <textarea
            value={sourceText}
            onChange={(e) => setSourceText(e.target.value)}
            placeholder="Escribe el texto que deseas traducir..."
            rows={8}
            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
          />

          <div className="text-xs text-gray-500">
            {sourceText.length}/5000 caracteres
          </div>
        </div>

        {/* Texto traducido */}
        <div className="space-y-2">
          <div className="flex justify-between items-center">
            <label className="text-sm font-medium text-gray-700">
              Traducción
            </label>
            <button
              onClick={() => copyText(translatedText, "target")}
              className="text-xs text-gray-600 hover:text-gray-800"
              disabled={!translatedText.trim()}
            >
              <Copy className="h-3 w-3" />
            </button>
          </div>

          <textarea
            value={translatedText}
            readOnly
            placeholder="La traducción aparecerá aquí..."
            rows={8}
            className="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 resize-none"
          />
        </div>
      </div>

      {/* 🚀 Botón de traducir */}
      <div className="mt-6 text-center">
        <button
          onClick={handleTranslate}
          disabled={isLoading || !sourceText.trim()}
          className="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
        >
          {isLoading ? (
            <Loader className="h-4 w-4 animate-spin" />
          ) : (
            <Languages className="h-4 w-4" />
          )}
          {isLoading ? "Traduciendo..." : "Traducir"}
        </button>
      </div>
    </div>
  );
}
```

---

## 🎯 Gestor de Paquetes REDVEL

### 🚀 Instalador Automático Inteligente

REDVEL incluye un potente gestor de paquetes que automatiza todo el proceso de instalación y configuración:

<div align="center">

![Windows](https://img.shields.io/badge/Windows-0078D6?style=for-the-badge&logo=windows&logoColor=white)
![Linux](https://img.shields.io/badge/Linux-FCC624?style=for-the-badge&logo=linux&logoColor=black)
![macOS](https://img.shields.io/badge/mac%20os-000000?style=for-the-badge&logo=apple&logoColor=white)

</div>

### 📥 Opciones de Instalación

|                                   Plataforma                                    |      Método       |          Comando           |      Estado       |
| :-----------------------------------------------------------------------------: | :---------------: | :------------------------: | :---------------: |
| ![Windows](https://img.shields.io/badge/Windows-0078D6?style=flat&logo=windows) |  **Ejecutable**   |    `redvel.exe install`    | ✅ **Disponible** |
|    ![Linux](https://img.shields.io/badge/Linux-FCC624?style=flat&logo=linux)    | **Script Python** | `python redvel.py install` | ✅ **Disponible** |
|    ![macOS](https://img.shields.io/badge/macOS-000000?style=flat&logo=apple)    | **Script Python** | `python redvel.py install` | ✅ **Disponible** |

### 🛠️ Características del Instalador

<div align="center">

```mermaid
graph TD
    A[🎯 Redvel CLI] --> B[🔍 Check Dependencies]
    B --> C{📦 Dependencies OK?}
    C -->|❌ No| D[📥 Install Missing]
    C -->|✅ Yes| E[📥 Download Framework]
    D --> E
    E --> F[⚙️ Configure Backend]
    F --> G[🎨 Setup Frontend]
    G --> H[🗄️ Database Setup]
    H --> I[🚀 Start Servers]
    I --> J[✅ Installation Complete]
```

</div>

### 🖥️ Comandos del CLI

```bash
# 🎯 GESTIÓN GENERAL
redvel                    # Mostrar menú interactivo
redvel help               # Ayuda completa
redvel version            # Versión del framework

# 📥 INSTALACIÓN Y DESCARGA
redvel download           # Descargar framework desde GitHub
redvel install            # Instalación completa automática
redvel update             # Actualizar framework a última versión

# 🔍 VERIFICACIÓN Y DIAGNÓSTICO
redvel check              # Verificar dependencias del sistema
redvel check --fix        # Verificar e intentar reparar problemas
redvel doctor             # Diagnóstico completo del sistema

# 🚀 EJECUCIÓN DE SERVIDORES
redvel run                # Iniciar backend + frontend
redvel run backend        # Solo servidor Laravel (puerto 8000)
redvel run frontend       # Solo servidor React (puerto 3000)
redvel run --port 8080    # Servidor en puerto personalizado

# 🧹 LIMPIEZA Y MANTENIMIENTO
redvel clean              # Menú interactivo de limpieza
redvel clean cache        # Limpiar caché Laravel
redvel clean node         # Limpiar node_modules
redvel clean all          # Limpieza completa

# 🔧 CONFIGURACIÓN
redvel config             # Menú de configuración
redvel config set key=value  # Establecer configuración
redvel config list        # Ver configuración actual

# 🗄️ BASE DE DATOS
redvel db:migrate         # Ejecutar migraciones
redvel db:seed            # Ejecutar seeders
redvel db:fresh           # Reset completo de BD
redvel db:backup          # Backup de base de datos

# 💬 HERRAMIENTAS ADICIONALES
redvel terminal           # Terminal interactiva REDVEL
redvel logs               # Ver logs del sistema
redvel serve              # Alias para 'redvel run'
```

### 🚀 Proceso de Instalación Paso a Paso

#### 1️⃣ **Verificación de Dependencias**

```bash
redvel check
```

<div align="center">

| Dependencia  | Mínimo | Recomendado |                         Estado                          |
| :----------: | :----: | :---------: | :-----------------------------------------------------: |
|   **PHP**    |  8.2   |    8.3+     | ![Status](https://img.shields.io/badge/Checking-yellow) |
| **Composer** |  2.0   |    2.6+     | ![Status](https://img.shields.io/badge/Checking-yellow) |
| **Node.js**  |  22.0  |    22.8+    | ![Status](https://img.shields.io/badge/Checking-yellow) |
|  **MySQL**   |  8.0   |    8.4+     |   ![Status](https://img.shields.io/badge/Manual-blue)   |

</div>

#### 2️⃣ **Descarga Automática**

```bash
# El instalador descarga automáticamente desde GitHub
✅ Clonando repositorio REDVEL-FRAMEWORK...
✅ Verificando integridad de archivos...
✅ Descomprimiendo estructura de directorios...
```

#### 3️⃣ **Configuración Backend**

```bash
# Configuración Laravel automática
✅ Copiando .env.example → .env
✅ Instalando dependencias Composer...
✅ Generando clave de aplicación Laravel...
✅ Configurando JWT secret...
✅ Preparando base de datos...
```

#### 4️⃣ **Configuración Frontend**

```bash
# Configuración React automática
✅ Instalando dependencias Node.js...
✅ Configurando TypeScript...
✅ Preparando assets de Tailwind...
✅ Optimizando configuración Vite...
```

#### 5️⃣ **Inicialización de Base de Datos**

```bash
# Setup automático de BD
✅ Ejecutando migraciones...
✅ Creando usuarios predeterminados...
✅ Asignando roles y permisos...
✅ Poblando datos de ejemplo...
```

### 🖥️ Terminal Interactiva

El CLI incluye una terminal interactiva para comandos continuos:

```bash
$ redvel terminal

╔══════════════════════════════════════════════╗
║           🚀 REDVEL FRAMEWORK CLI            ║
║              Terminal Interactiva            ║
╚══════════════════════════════════════════════╝

REDVEL> help
📋 Comandos disponibles:
  - install     🚀 Instalar framework completo
  - run         ▶️  Iniciar servidores
  - check       🔍 Verificar dependencias
  - clean       🧹 Limpiar archivos temporales
  - config      ⚙️ Configuración del sistema
  - logs        📝 Ver logs del sistema
  - exit        🚪 Salir de la terminal

REDVEL> install
🚀 Iniciando instalación de REDVEL Framework...

REDVEL> run
▶️ Iniciando servidores...
🔧 Backend Laravel: http://localhost:8000
⚛️ Frontend React: http://localhost:3000

REDVEL> exit
👋 ¡Gracias por usar REDVEL Framework!
```

### ⚙️ Archivo de Configuración

```yaml
# redvel.config.yml
framework:
  name: "REDVEL"
  version: "1.0.0"

paths:
  backend: "./RedBack"
  frontend: "./RedFront"

servers:
  backend:
    port: 8000
    host: "localhost"
  frontend:
    port: 3000
    host: "localhost"

database:
  default_connection: "mysql"
  auto_migrate: true
  auto_seed: true

features:
  swagger_ui: true
  translation: true
  caching: true

development:
  hot_reload: true
  debug_mode: true
  auto_refresh: true
```

---

## ⚙️ Configuración del Entorno

### 🔧 Variables de Entorno Completas

```env
# ========================================
# 🎯 CONFIGURACIÓN DE LA APLICACIÓN
# ========================================
APP_NAME="REDVEL Framework"
APP_ENV=local                    # local, staging, production
APP_KEY=                        # Generado automáticamente
APP_DEBUG=true                  # false en producción
APP_LOCALE=es                   # Idioma principal
APP_FALLBACK_LOCALE=en          # Idioma de respaldo
APP_TIMEZONE=America/Lima       # Zona horaria

# 🌐 URLs de la aplicación
APP_URL=http://localhost:8000           # Backend URL
APP_URL_FRONTEND=http://localhost:3000   # Frontend URL

# ========================================
# 🗄️ CONFIGURACIÓN DE BASE DE DATOS
# ========================================
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=redvel_framework    # ⚠️ Crear esta BD manualmente
DB_USERNAME=root
DB_PASSWORD=                    # Tu contraseña de MySQL

# 🔄 Configuración de conexión
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci

# ========================================
# 🔐 CONFIGURACIÓN JWT
# ========================================
JWT_SECRET=                     # Generado con php artisan jwt:secret
JWT_TTL=60                      # Tiempo de vida en minutos (60 = 1 hora)
JWT_REFRESH_TTL=20160          # Refresh token TTL (14 días)
JWT_ALGO=HS256                 # Algoritmo de cifrado

# ⏰ Configuración de sesión personalizada
TIEMPO_SESION=60               # Minutos de sesión activa
SESSION_WARNING=5              # Advertencia 5 min antes de expirar

# ========================================
# 💾 CONFIGURACIÓN DE CACHÉ
# ========================================
CACHE_DRIVER=file              # file, redis, memcached, database
CACHE_PREFIX=redvel_           # Prefijo para evitar colisiones

# Redis (si se usa)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=predis

# ========================================
# 📧 CONFIGURACIÓN DE EMAIL
# ========================================
MAIL_MAILER=smtp               # smtp, sendmail, mailgun, ses
MAIL_HOST=smtp.gmail.com       # Servidor SMTP
MAIL_PORT=587                  # Puerto SMTP
MAIL_USERNAME=                 # Tu email
MAIL_PASSWORD=                 # Contraseña de aplicación
MAIL_ENCRYPTION=tls            # tls o ssl
MAIL_FROM_ADDRESS="noreply@redvel.dev"
MAIL_FROM_NAME="${APP_NAME}"

# ========================================
# 🔄 CONFIGURACIÓN DE COLAS
# ========================================
QUEUE_CONNECTION=database      # sync, database, redis, sqs
QUEUE_FAILED_DRIVER=database

# ========================================
# 📁 CONFIGURACIÓN DE ARCHIVOS
# ========================================
FILESYSTEM_DISK=local          # local, public, s3
UPLOAD_MAX_SIZE=10240          # KB (10MB)
ALLOWED_FILE_TYPES=jpg,jpeg,png,pdf,doc,docx

# AWS S3 (si se usa)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

# ========================================
# 🌐 CONFIGURACIÓN DE TRADUCCIÓN
# ========================================
TRANSLATION_ENABLED=true       # Habilitar sistema de traducción
TRANSLATION_CACHE_TTL=3600     # Cache de traducciones en segundos
TRANSLATION_DEFAULT_SOURCE=auto # Idioma origen por defecto
TRANSLATION_DEFAULT_TARGET=es   # Idioma destino por defecto

# ========================================
# 📊 CONFIGURACIÓN DE LOGS
# ========================================
LOG_CHANNEL=daily              # single, daily, slack, stderr
LOG_LEVEL=debug                # emergency, alert, critical, error, warning, notice, info, debug
LOG_DAYS=14                    # Días que mantener logs

# ========================================
# 🛡️ CONFIGURACIÓN DE SEGURIDAD
# ========================================
# Rate Limiting
RATE_LIMIT_PER_MINUTE=60       # Requests por minuto
RATE_LIMIT_LOGIN=5             # Intentos login por minuto

# Session Security
SESSION_LIFETIME=120           # Minutos
SESSION_EXPIRE_ON_CLOSE=false
SESSION_ENCRYPT=false
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# CORS
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1

# ========================================
# 📚 SWAGGER DOCUMENTACIÓN
# ========================================
L5_SWAGGER_GENERATE_ALWAYS=true    # Regenerar docs automáticamente
L5_SWAGGER_OPEN_API_VERSION=3.0.0  # Versión OpenAPI
SWAGGER_UI_ENABLED=true             # Habilitar UI de documentación

# ========================================
# 🚀 CONFIGURACIÓN DE PRODUCCIÓN
# ========================================
# Estas variables se configuran automáticamente en producción
# APP_DEBUG=false
# APP_ENV=production
# LOG_LEVEL=error
# CACHE_DRIVER=redis
# SESSION_DRIVER=redis
# QUEUE_CONNECTION=redis

# ========================================
# 🔧 CONFIGURACIÓN DE DESARROLLO
# ========================================
TELESCOPE_ENABLED=false        # Laravel Telescope para debugging
DEBUGBAR_ENABLED=false         # Debug bar para desarrollo
VITE_PORT=5173                # Puerto del dev server de Vite
```

### 📋 Configuración de CORS

```php
// config/cors.php
<?php

return [
    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'traduccion/*'
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        env('APP_URL_FRONTEND', 'http://localhost:3000'),
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        // Añadir dominios de producción aquí
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [
        'Authorization',
        'X-Total-Count',
        'X-Per-Page',
        'X-Current-Page'
    ],

    'max_age' => 0,

    'supports_credentials' => true,
];
```

### 🔒 Configuración de Seguridad

```php
// config/security.php (archivo personalizado)
<?php

return [
    'password' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_symbols' => false,
        'expire_days' => 90,
    ],

    'login' => [
        'max_attempts' => 5,
        'lockout_duration' => 30, // minutos
        'track_attempts' => true,
    ],

    'session' => [
        'timeout_warning' => 5, // minutos antes de expirar
        'extend_on_activity' => true,
        'force_logout_inactive' => true,
    ],

    'api' => [
        'rate_limit' => 60, // requests por minuto
        'burst_limit' => 100, // burst requests
        'require_https' => env('APP_ENV') === 'production',
    ],

    'files' => [
        'max_upload_size' => '10M',
        'allowed_types' => [
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'documents' => ['pdf', 'doc', 'docx', 'txt'],
            'spreadsheets' => ['xls', 'xlsx', 'csv'],
        ],
        'scan_uploads' => true,
    ],
];
```

---

## 📚 Documentación API

### 🎯 Swagger UI Integrado

REDVEL incluye documentación automática de la API usando Swagger/OpenAPI 3.0:

<div align="center">

![Swagger](https://img.shields.io/badge/Swagger-85EA2D?style=for-the-badge&logo=swagger&logoColor=black)
![OpenAPI](https://img.shields.io/badge/OpenAPI-3.0-6BA539?style=for-the-badge&logo=openapiinitiative&logoColor=white)

**📖 URL de Documentación:** `http://localhost:8000/api/documentation`

</div>

### 📝 Ejemplo de Documentación de Controller

```php
<?php
// app/Http/Controllers/UserController.php

/**
 * @OA\Info(
 *     title="REDVEL Framework API",
 *     version="1.0.0",
 *     description="API completa para el framework REDVEL con autenticación JWT y sistema de permisos",
 *     @OA\Contact(
 *         email="martinlinohuaney@gmail.com",
 *         name="Luis Huaney Lino"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor de Desarrollo"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Listar usuarios",
     *     description="Obtiene una lista paginada de todos los usuarios del sistema",
     *     operationId="getUsersList",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Elementos por página",
     *         required=false,
     *         @OA\Schema(type="integer", example=15, maximum=100)
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Término de búsqueda",
     *         required=false,
     *         @OA\Schema(type="string", example="john")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios obtenida exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             ),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta"),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $users = Usuario::with('roles', 'permissions')
            ->when($request->search, function ($query, $search) {
                return $query->where('nomusu', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate($request->per_page ?? 15);

        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear usuario",
     *     description="Crea un nuevo usuario en el sistema",
     *     operationId="createUser",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del nuevo usuario",
     *         @OA\JsonContent(ref="#/components/schemas/CreateUserRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario creado exitosamente"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     )
     * )
     */
    public function store(CreateUserRequest $request)
    {
        $user = Usuario::create([
            'nomusu' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activo' => $request->active ?? true
        ]);

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'data' => $user->load('roles')
        ], 201);
    }
}
```

### 📊 Esquemas de Datos

```php
<?php
// app/Http/Controllers/Schemas/UserSchemas.php

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Usuario",
 *     description="Modelo de usuario del sistema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nomusu", type="string", example="john.doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="activo", type="boolean", example=true),
 *     @OA\Property(property="ultimo_login", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="roles",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Role")
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="CreateUserRequest",
 *     type="object",
 *     title="Crear Usuario Request",
 *     required={"username", "email", "password"},
 *     @OA\Property(property="username", type="string", minLength=3, maxLength=50, example="john.doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="password", type="string", minLength=8, example="password123"),
 *     @OA\Property(property="active", type="boolean", example=true),
 *     @OA\Property(
 *         property="roles",
 *         type="array",
 *         @OA\Items(type="string", example="user")
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="Role",
 *     type="object",
 *     title="Rol",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="admin"),
 *     @OA\Property(property="guard_name", type="string", example="api"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     title="Respuesta de Error",
 *     @OA\Property(property="error", type="string", example="Error message"),
 *     @OA\Property(property="code", type="string", example="ERROR_CODE"),
 *     @OA\Property(property="timestamp", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="ValidationErrorResponse",
 *     type="object",
 *     title="Errores de Validación",
 *     @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos."),
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         @OA\AdditionalProperties(
 *             type="array",
 *             @OA\Items(type="string")
 *         ),
 *         example={"email": {"El email ya está en uso"}, "password": {"La contraseña debe tener al menos 8 caracteres"}}
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     type="object",
 *     title="Metadatos de Paginación",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=10),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="to", type="integer", example=15),
 *     @OA\Property(property="total", type="integer", example=150)
 * )
 */

/**
 * @OA\Schema(
 *     schema="PaginationLinks",
 *     type="object",
 *     title="Enlaces de Paginación",
 *     @OA\Property(property="first", type="string", nullable=true),
 *     @OA\Property(property="last", type="string", nullable=true),
 *     @OA\Property(property="prev", type="string", nullable=true),
 *     @OA\Property(property="next", type="string", nullable=true)
 * )
 */
```

### 🎨 Personalización de Swagger UI

```php
// config/l5-swagger.php
<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'REDVEL Framework API',
            ],
            'routes' => [
                'api' => 'api/documentation',
            ],
            'paths' => [
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
                'annotations' => [
                    base_path('app'),
                ],
            ],
        ],
    ],
    'defaults' => [
        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
            'group_options' => [],
        ],
        'paths' => [
            'docs' => storage_path('api-docs'),
            'views' => base_path('resources/views/vendor/l5-swagger'),
            'base' => env('L5_SWAGGER_BASE_PATH', null),
            'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', null),
            'excludes' => [],
        ],
        'scanOptions' => [
            'analyser' => null,
            'analysis' => null,
            'processors' => [
                // Procesadores personalizados
            ],
            'pattern' => null,
            'exclude' => [],
            'open_api_spec_version' => env('L5_SWAGGER_OPEN_API_SPEC_VERSION', '3.0.0'),
        ],
        'securityDefinitions' => [
            'securitySchemes' => [
                'bearerAuth' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'JWT',
                    'description' => 'Ingresa el token JWT en el formato: Bearer {token}'
                ],
            ],
            'security' => [
                'bearerAuth' => []
            ],
        ],
        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', true),
        'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),
        'proxy' => false,
        'additional_config_url' => null,
        'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),
        'validator_url' => null,
        'ui' => [
            'display' => [
                'dark_mode' => env('L5_SWAGGER_UI_DARK_MODE', false),
                'doc_expansion' => env('L5_SWAGGER_UI_DOC_EXPANSION', 'none'),
                'filter' => env('L5_SWAGGER_UI_FILTERS', true),
            ],
            'authorization' => [
                'persist_authorization' => env('L5_SWAGGER_UI_PERSIST_AUTHORIZATION', false),
            ],
        ],
        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000'),
        ],
    ],
];
```

---

## 🤝 Contribución

### 🌟 ¡Tu Contribución es Bienvenida!

REDVEL Framework es un proyecto open source que crece con la comunidad. ¡Tu participación es fundamental!

<div align="center">

![Contributors](https://img.shields.io/badge/Contributors-Welcome-brightgreen?style=for-the-badge&logo=github)
![Issues](https://img.shields.io/badge/Issues-Open-blue?style=for-the-badge&logo=github-issues)
![Pull Requests](https://img.shields.io/badge/Pull_Requests-Welcome-orange?style=for-the-badge&logo=git)

</div>

### 🚀 Cómo Contribuir

#### 1️⃣ **Fork y Clone**

```bash
# 🍴 Fork el repositorio en GitHub
# Luego clona tu fork
git clone https://github.com/TU-USUARIO/REDVEL-FRAMEWORK.git
cd REDVEL-FRAMEWORK

# 🔗 Añadir upstream para sincronizar
git remote add upstream https://github.com/luis-huaney-lino-devops/REDVEL-FRAMEWORK.git
```

#### 2️⃣ **Crear Rama de Feature**

```bash
# 🌿 Crear y cambiar a nueva rama
git checkout -b feature/nombre-de-tu-feature

# Ejemplo de nombres de rama:
# feature/improved-authentication
# bugfix/cors-configuration
# enhancement/better-error-handling
# docs/api-documentation-update
```

#### 3️⃣ **Desarrollar y Testear**

```bash
# 🛠️ Instalar dependencias
redvel install

# 🧪 Ejecutar tests
cd RedBack && php artisan test
cd ../RedFront && npm test

# 🔍 Verificar código
php artisan code:analyse
npm run lint
```

#### 4️⃣ **Commit con Conventional Commits**

```bash
# 📝 Commits semánticos
git commit -m "feat: add user profile management"
git commit -m "fix: resolve CORS issues with frontend"
git commit -m "docs: update API documentation"
git commit -m "style: improve UI components styling"
git commit -m "refactor: optimize database queries"
```

#### 5️⃣ **Push y Pull Request**

```bash
# 📤 Push a tu fork
git push origin feature/nombre-de-tu-feature

# 🔄 Crear Pull Request en GitHub
# Describe claramente los cambios y por qué son necesarios
```

### 🎯 Tipos de Contribuciones

<div align="center">

|         Tipo         |       Descripción        |             Ejemplos             |   Etiqueta    |
| :------------------: | :----------------------: | :------------------------------: | :-----------: |
|   🐛 **Bug Fixes**   |  Corrección de errores   |   Bugs en autenticación, CORS    |   `bugfix`    |
|   ✨ **Features**    |  Nuevas funcionalidades  |  Nuevos módulos, API endpoints   |   `feature`   |
| 📚 **Documentation** | Mejoras en documentación |    README, comentarios, guías    |    `docs`     |
|     🎨 **UI/UX**     |     Mejoras visuales     | Componentes, estilos, responsive |     `ui`      |
|  ⚡ **Performance**  |      Optimizaciones      |   Queries, caché, bundle size    | `performance` |
|   🔒 **Security**    |   Mejoras de seguridad   |    Validaciones, sanitización    |  `security`   |

</div>

### 📋 Checklist de Pull Request

Antes de enviar tu PR, verifica:

- [ ] ✅ **Código funciona** - Probado localmente sin errores
- [ ] 🧪 **Tests pasan** - Todos los tests existentes funcionan
- [ ] 📝 **Documentación** - README y comentarios actualizados
- [ ] 🎨 **Estilo consistente** - Sigue las convenciones del proyecto
- [ ] 🔍 **No código duplicado** - Reutiliza funciones existentes
- [ ] 🚀 **Performance** - No introduce ralentizaciones
- [ ] 🔒 **Seguridad** - No introduce vulnerabilidades
- [ ] 📱 **Responsive** - Funciona en móviles (si aplica)

### 🛠️ Configuración de Desarrollo

#### 🔧 Herramientas Recomendadas

```json
// .vscode/extensions.json
{
  "recommendations": [
    "ms-vscode.vscode-typescript-next",
    "bradlc.vscode-tailwindcss",
    "ms-vscode.vscode-eslint",
    "esbenp.prettier-vscode",
    "bmewburn.vscode-intelephense-client",
    "ms-vscode.vscode-json"
  ]
}
```

#### ⚙️ Configuración ESLint

```json
// .eslintrc.json
{
  "extends": [
    "eslint:recommended",
    "@typescript-eslint/recommended",
    "prettier"
  ],
  "plugins": ["@typescript-eslint", "react-hooks"],
  "rules": {
    "react-hooks/rules-of-hooks": "error",
    "react-hooks/exhaustive-deps": "warn",
    "@typescript-eslint/no-unused-vars": "error",
    "prefer-const": "error"
  }
}
```

#### 🎨 Configuración Prettier

```json
// .prettierrc
{
  "semi": true,
  "trailingComma": "es5",
  "singleQuote": true,
  "printWidth": 100,
  "tabWidth": 2,
  "useTabs": false
}
```

### 📊 Proceso de Review

#### 🔍 Criterios de Evaluación

1. **📋 Funcionalidad**

   - ¿Resuelve el problema planteado?
   - ¿Funciona en diferentes navegadores?
   - ¿Es compatible con versiones anteriores?

2. **🏗️ Arquitectura**

   - ¿Sigue los patrones establecidos?
   - ¿Es escalable y mantenible?
   - ¿Integra bien con el código existente?

3. **🚀 Performance**

   - ¿No introduce ralentizaciones?
   - ¿Optimiza recursos cuando es posible?
   - ¿Usa caché apropiadamente?

4. **🔒 Seguridad**
   - ¿Valida entradas del usuario?
   - ¿Maneja errores apropiadamente?
   - ¿Sigue principios de seguridad?

### 🌟 Reconocimiento de Contribuidores

Los contribuidores destacados serán reconocidos en:

- 📖 **README principal** - Lista de colaboradores
- 🏆 **Hall of Fame** - Página especial para contribuidores
- 📧 **Newsletter** - Menciones en actualizaciones
- 🎁 **Swag exclusivo** - Merchandising para top contributors

### 📞 Comunicación

#### 💬 Canales de Comunicación

- **📧 Email directo:** martinlinohuaney@gmail.com
- **🐙 GitHub Issues:** Para reportar bugs y solicitar features
- **💬 GitHub Discussions:** Para preguntas generales y ideas
- **📱 WhatsApp:** +51 946 587 273 (para temas urgentes)

#### 🤝 Código de Conducta

- 🫱 **Respeto mutuo** - Trata a todos con cortesía
- 🎯 **Enfoque constructivo** - Críticas constructivas, no destructivas
- 📚 **Disposición a aprender** - Todos estamos aprendiendo
- 🌍 **Inclusividad** - Welcoming environment for everyone
- 🤝 **Colaboración** - Trabajamos juntos hacia objetivos comunes

---

## 📄 Licencia y Términos

### 📜 Licencia MIT

```
MIT License

Copyright (c) 2024 Luis Huaney Lino

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 🎊 Agradecimientos Especiales

### 🏢 Tecnologías y Librerías

Un agradecimiento especial a las increíbles herramientas que hacen posible REDVEL:

<div align="center">

#### Backend Stack

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![JWT](https://img.shields.io/badge/JWT-black?style=for-the-badge&logo=JSON%20web%20tokens)](https://jwt.io)
[![Spatie](https://img.shields.io/badge/Spatie-blue?style=for-the-badge)](https://spatie.be)

#### Frontend Stack

[![React](https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB)](https://reactjs.org)
[![TypeScript](https://img.shields.io/badge/TypeScript-007ACC?style=for-the-badge&logo=typescript&logoColor=white)](https://typescriptlang.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-B73BFE?style=for-the-badge&logo=vite&logoColor=FFD62E)](https://vitejs.dev)

</div>

### 🌟 Inspiración y Motivación

Este framework existe gracias a:

- **🚀 La comunidad Open Source** - Por compartir conocimiento libremente
- **👥 Desarrolladores que enfrentan problemas similares** - Por validar la necesidad
- **🏢 Proyectos reales** - Por proporcionar casos de uso auténticos
- **📚 Mentores y colegas** - Por feedback y orientación constante

---

## 🚀 ¿Listo para Empezar?

<div align="center">

### 🎯 **¡Construye tu próxima aplicación web con REDVEL!**

```bash
# 🚀 Un solo comando para empezar
redvel install && redvel run
```

### 📖 Recursos Útiles

[![Documentación](https://img.shields.io/badge/📚_Documentación-blue?style=for-the-badge)](http://localhost:8000/api/documentation)
[![GitHub](https://img.shields.io/badge/🐙_GitHub-black?style=for-the-badge&logo=github)](https://github.com/luis-huaney-lino-devops/REDVEL-FRAMEWORK)
[![Contacto](https://img.shields.io/badge/📧_Contacto-red?style=for-the-badge)](mailto:martinlinohuaney@gmail.com)

</div>

---

<div align="center">

**REDVEL Framework** - _Desarrollado con ❤️ para crear aplicaciones web modernas y escalables_

![Made with Love](https://img.shields.io/badge/Made%20with-❤️-red?style=for-the-badge)
![Peru](https://img.shields.io/badge/Huaraz-Ancash%2C%20Peru-green?style=for-the-badge&logo=peru)

---

_© 2024 Luis Huaney Lino. Todos los derechos reservados bajo Licencia MIT._

</div>
