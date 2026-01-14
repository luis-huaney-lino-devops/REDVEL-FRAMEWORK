<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Limpieza de caché de permisos
        |--------------------------------------------------------------------------
        | Spatie mantiene los permisos en caché.
        | Si no se limpia, los cambios en BD no se reflejan en tiempo de ejecución.
        */
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Usar 'api' porque el modelo Usuario tiene guard_name = 'api' y las rutas API usan auth('api')
        $guard = 'api';

        /*
        |--------------------------------------------------------------------------
        | 2. Catálogo de permisos del sistema
        |--------------------------------------------------------------------------
        | Un permiso representa una acción atómica del negocio.
        |
        | Diagrama conceptual:
        |
        |  [USUARIO]
        |      |
        |      v
        |  [ROL] --------------> [PERMISOS]
        |                            |
        |                            +--> personas.view
        |                            +--> usuarios.create
        |
        */
        $permissions = [
            // Módulo Personas
            'personas.view',
            'personas.create',
            'personas.update',
            'personas.delete',

            // Módulo Usuarios
            'usuarios.view',
            'usuarios.create',
            'usuarios.update',
            'usuarios.delete',
            'usuarios.activate',
            'usuarios.deactivate',
        ];

        /*
        |--------------------------------------------------------------------------
        | 3. Creación de permisos
        |--------------------------------------------------------------------------
        | - firstOrCreate evita duplicados
        | - guard_name debe coincidir con el guard de autenticación
        |
        | BD:
        |  permissions
        |  ┌────┬───────────────────────┬──────────┐
        |  | id | name                  | guard    |
        |  └────┴───────────────────────┴──────────┘
        */
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Definición de roles y asignación de permisos
        |--------------------------------------------------------------------------
        | Un rol es un conjunto de permisos.
        | Los roles NO contienen lógica, solo agrupan capacidades.
        */

        /*
        |----------------------------------------------------------------------
        | ROL: administrador
        |----------------------------------------------------------------------
        | Acceso completo al sistema.
        |
        | administrador
        |     └──> TODOS los permisos
        */
        $administrador = Role::firstOrCreate([
            'name' => 'administrador',
            'guard_name' => $guard,
        ]);
        $administrador->syncPermissions($permissions);

        /*
        |----------------------------------------------------------------------
        | ROL: rrhh
        |----------------------------------------------------------------------
        | Gestión operativa de personas.
        | Acceso de solo lectura al módulo usuarios.
        |
        | rrhh
        |   ├── personas.view
        |   ├── personas.create
        |   ├── personas.update
        |   └── usuarios.view
        */
        $rrhh = Role::firstOrCreate([
            'name' => 'rrhh',
            'guard_name' => $guard,
        ]);
        $rrhh->syncPermissions([
            'personas.view',
            'personas.create',
            'personas.update',
            'usuarios.view',
        ]);

        /*
        |----------------------------------------------------------------------
        | ROL: operador
        |----------------------------------------------------------------------
        | Usuario con acceso de solo consulta.
        |
        | operador
        |   ├── personas.view
        |   └── usuarios.view
        */
        $operador = Role::firstOrCreate([
            'name' => 'operador',
            'guard_name' => $guard,
        ]);
        $operador->syncPermissions([
            'personas.view',
            'usuarios.view',
        ]);
    }
}
