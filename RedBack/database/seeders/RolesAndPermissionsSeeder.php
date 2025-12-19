<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

class RolesAndPermissionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    $personasPermissions = [
      'personas.view',
      'personas.create',
      'personas.update',
      'personas.delete',
    ];

    // 2. GESTIÓN DE EMPADRONADOS
    $empadronadosPermissions = [
      'empadronados.view',
      'empadronados.create',
      'empadronados.update',
      'empadronados.delete',
      'empadronados.export',
    ];

    // 3. GESTIÓN DE FAMILIARES
    $familiaresPermissions = [
      'familiares.view',
      'familiares.create',
      'familiares.update',
      'familiares.delete',
    ];

    // 4. GESTIÓN DE VIVIENDAS
    $viviendasPermissions = [
      'viviendas.view',
      'viviendas.create',
      'viviendas.update',
      'viviendas.delete',
      'viviendas.cortes',
      'viviendas.reconexiones',
    ];

    // 5. GESTIÓN DE USUARIOS
    $usuariosPermissions = [
      'usuarios.view',
      'usuarios.create',
      'usuarios.update',
      'usuarios.delete',
      'usuarios.activate',
      'usuarios.deactivate',
    ];


    // 6. ADMINISTRADOR - Gestión técnica del sistema
    $administrador = Role::create(['name' => 'administrador']);
    $administradorPermissions = array_merge(
      $usuariosPermissions,

      [
        'personas.view',
        'empadronados.view',
        'reportes.general',
        'reportes.export',
      ]
    );
    $administrador->givePermissionTo($administradorPermissions);

    // 7. OPERADOR - Personal operativo para registro diario
    $operador = Role::create(['name' => 'operador']);
    $operadorPermissions = [
      'personas.view',
      'personas.create',
      'personas.update',
      'empadronados.view',
      'empadronados.create',
      'empadronados.update',
      'familiares.view',
      'familiares.create',
      'familiares.update',
      'viviendas.view',
      'viviendas.update',
      'pagos.view',
      'pagos.create',
      'pagos.registrar',
      'config.view',
    ];
    $operador->givePermissionTo($operadorPermissions);

    // 8. CONTADOR - Rol especializado en finanzas y contabilidad
    $contador = Role::create(['name' => 'contador']);
    $contadorPermissions = array_merge(
      [
        'empadronados.view',
        'personas.view',
        'viviendas.view',
      ],

      [
        'inventarios.view',
        'reportes.financieros',
        'reportes.egresos',
        'reportes.general',
        'reportes.export',
        'multas.view',
        'config.view',
      ]
    );
    $contador->givePermissionTo($contadorPermissions);
  }
}
