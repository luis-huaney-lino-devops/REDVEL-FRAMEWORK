<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class VerificarPermisos extends Command
{
    protected $signature = 'permisos:verificar {usuario_id?}';
    protected $description = 'Verifica los permisos de un usuario y muestra información de debugging';

    public function handle()
    {
        $usuarioId = $this->argument('usuario_id') ?? 1;

        // Limpiar caché
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $usuario = Usuario::find($usuarioId);

        if (!$usuario) {
            $this->error("Usuario con ID {$usuarioId} no encontrado");
            return 1;
        }

        $this->info("=== Verificación de Permisos para Usuario: {$usuario->nomusu} (ID: {$usuario->idusuarios}) ===\n");

        // Verificar guard del modelo
        $this->info("1. Guard del modelo Usuario: " . ($usuario->guard_name ?? 'no definido'));
        $this->info("");

        // Verificar permisos en BD
        $this->info("2. Permisos en la base de datos:");
        $permisosApi = Permission::where('guard_name', 'api')->get(['id', 'name', 'guard_name']);
        $permisosWeb = Permission::where('guard_name', 'web')->get(['id', 'name', 'guard_name']);

        $this->info("   Permisos con guard 'api': " . $permisosApi->count());
        foreach ($permisosApi as $perm) {
            $this->line("   - {$perm->name} (guard: {$perm->guard_name})");
        }

        if ($permisosWeb->count() > 0) {
            $this->warn("   ⚠️  Permisos con guard 'web' encontrados: " . $permisosWeb->count());
            foreach ($permisosWeb as $perm) {
                $this->line("   - {$perm->name} (guard: {$perm->guard_name})");
            }
        }
        $this->info("");

        // Verificar roles del usuario
        $this->info("3. Roles del usuario:");
        $roles = $usuario->getRoleNames();
        foreach ($roles as $rol) {
            $this->line("   - {$rol}");
        }
        if ($roles->isEmpty()) {
            $this->warn("   ⚠️  El usuario NO tiene roles asignados");
        }
        $this->info("");

        // Verificar permisos del usuario
        $this->info("4. Permisos del usuario (directos + a través de roles):");
        $permisosUsuario = $usuario->getAllPermissions();
        foreach ($permisosUsuario as $perm) {
            $this->line("   - {$perm->name} (guard: {$perm->guard_name})");
        }
        if ($permisosUsuario->isEmpty()) {
            $this->warn("   ⚠️  El usuario NO tiene permisos asignados");
        }
        $this->info("");

        // Verificar permiso específico
        $this->info("5. Verificación de permiso 'usuarios.view':");
        $tienePermiso = $usuario->hasPermissionTo('usuarios.view', 'api');
        if ($tienePermiso) {
            $this->info("   ✅ El usuario TIENE el permiso 'usuarios.view'");
        } else {
            $this->error("   ❌ El usuario NO tiene el permiso 'usuarios.view'");
        }
        $this->info("");

        // Verificar roles en BD
        $this->info("6. Roles en la base de datos:");
        $rolesApi = Role::where('guard_name', 'api')->get(['id', 'name', 'guard_name']);
        $rolesWeb = Role::where('guard_name', 'web')->get(['id', 'name', 'guard_name']);

        $this->info("   Roles con guard 'api': " . $rolesApi->count());
        foreach ($rolesApi as $rol) {
            $permisosRol = $rol->permissions->pluck('name')->toArray();
            $this->line("   - {$rol->name} (guard: {$rol->guard_name})");
            $this->line("     Permisos: " . (empty($permisosRol) ? 'ninguno' : implode(', ', $permisosRol)));
        }

        if ($rolesWeb->count() > 0) {
            $this->warn("   ⚠️  Roles con guard 'web' encontrados: " . $rolesWeb->count());
        }
        $this->info("");

        // Recomendaciones
        $this->info("=== Recomendaciones ===");
        if ($permisosWeb->count() > 0 || $rolesWeb->count() > 0) {
            $this->warn("⚠️  Hay permisos/roles con guard 'web'. Ejecuta:");
            $this->line("   php artisan db:seed --class=RolesAndPermissionsSeeder");
            $this->line("   php artisan permission:cache-reset");
        }

        if ($roles->isEmpty()) {
            $this->warn("⚠️  El usuario no tiene roles. Asigna un rol:");
            $this->line("   \$usuario = Usuario::find({$usuarioId});");
            $this->line("   \$usuario->assignRole('administrador');");
        }

        return 0;
    }
}
