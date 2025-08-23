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

        // 6. JUNTAS DIRECTIVAS
        $juntasPermissions = [
            'juntas.view',
            'juntas.create',
            'juntas.update',
            'juntas.delete',
            'juntas.assign_cargo',
        ];

        // 7. REUNIONES
        $reunionesPermissions = [
            'reuniones.view',
            'reuniones.create',
            'reuniones.update',
            'reuniones.delete',
            'reuniones.participaciones',
            'reuniones.asistencia',
        ];

        // 8. PAGOS Y COBRANZAS
        $pagosPermissions = [
            'pagos.view',
            'pagos.create',
            'pagos.update',
            'pagos.delete',
            'pagos.registrar',
            'pagos.anular',
            'pagos.reportes',
            'pagos.comprobantes',
        ];

        // 9. MULTAS
        $multasPermissions = [
            'multas.view',
            'multas.create',
            'multas.update',
            'multas.delete',
            'multas.aplicar',
            'multas.exonerar',
        ];

        // 10. INVENTARIOS
        $inventariosPermissions = [
            'inventarios.view',
            'inventarios.create',
            'inventarios.update',
            'inventarios.delete',
            'inventarios.entrada',
            'inventarios.salida',
        ];

        // 11. EGRESOS
        $egresosPermissions = [
            'egresos.view',
            'egresos.create',
            'egresos.update',
            'egresos.delete',
            'egresos.aprobar',
            'egresos.reportes',
        ];

        // 12. CAMBIOS DE TITULAR
        $cambiosTitularPermissions = [
            'cambios_titular.view',
            'cambios_titular.create',
            'cambios_titular.update',
            'cambios_titular.delete',
            'cambios_titular.aprobar',
        ];

        // 13. REPORTES Y ESTADÍSTICAS
        $reportesPermissions = [
            'reportes.financieros',
            'reportes.empadronados',
            'reportes.asistencias',
            'reportes.morosos',
            'reportes.inventarios',
            'reportes.egresos',
            'reportes.general',
            'reportes.export',
        ];

        // 14. CONFIGURACIÓN DEL SISTEMA
        $configuracionPermissions = [
            'config.view',
            'config.update',
            'config.generos',
            'config.profesiones',
            'config.actividades',
            'config.estados_civiles',
            'config.grados_instruccion',
            'config.departamentos',
            'config.provincias',
            'config.distritos',
            'config.direcciones',
            'config.tipos_reunion',
            'config.metodos_pago',
            'config.conceptos_pago',
            'config.frecuencias_pago',
            'config.cargos',
            'config.tipos_familiares',
            'config.conceptos_cambio',
        ];


        // 15. DOCUMENTOS Y ACTAS

        $documentosPermissions = [
            'documentos.view',
            'documentos.create',
            'documentos.update',
            'documentos.delete',
            'documentos.actas',
            'documentos.oficios',
            'documentos.certificados',
        ];

        // ===============================
        // CREAR TODOS LOS PERMISOS
        // ===============================
        $allPermissions = array_merge(
            $personasPermissions,
            $empadronadosPermissions,
            $familiaresPermissions,
            $viviendasPermissions,
            $usuariosPermissions,
            $juntasPermissions,
            $reunionesPermissions,
            $pagosPermissions,
            $multasPermissions,
            $inventariosPermissions,
            $egresosPermissions,
            $cambiosTitularPermissions,
            $reportesPermissions,
            $configuracionPermissions,
            $documentosPermissions
        );

        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ===============================
        // CREAR ROLES Y ASIGNAR PERMISOS
        // ===============================

        // 1. SUPERADMIN - Acceso total
        $superAdmin = Role::create(['name' => 'superadmin']);
        $superAdmin->givePermissionTo($allPermissions);

        // 2. PRESIDENTE - Acceso completo excepto configuración crítica del sistema
        $presidente = Role::create(['name' => 'presidente']);
        $presidentePermissions = array_merge(
            $personasPermissions,
            $empadronadosPermissions,
            $familiaresPermissions,
            $viviendasPermissions,
            $juntasPermissions,
            $reunionesPermissions,
            $pagosPermissions,
            $multasPermissions,
            $inventariosPermissions,
            $egresosPermissions,
            $cambiosTitularPermissions,
            $reportesPermissions,
            $documentosPermissions,
            [
                'usuarios.view',
                'usuarios.create',
                'usuarios.update',
                'config.view',
                'config.generos',
                'config.profesiones',
                'config.actividades',
                'config.estados_civiles',
                'config.grados_instruccion',
                'config.direcciones',
                'config.tipos_reunion',
                'config.metodos_pago',
                'config.conceptos_pago',
                'config.frecuencias_pago',
                'config.cargos',
                'config.tipos_familiares',
                'config.conceptos_cambio',
            ]
        );
        $presidente->givePermissionTo($presidentePermissions);

        // 3. TESORERO - Enfoque en finanzas y pagos
        $tesorero = Role::create(['name' => 'tesorero']);
        $tesoreroPermissions = array_merge(
            [
                'empadronados.view',
                'personas.view',
                'viviendas.view',
            ],
            $pagosPermissions,
            $egresosPermissions,
            $multasPermissions,
            [
                'inventarios.view',
                'reportes.financieros',
                'reportes.morosos',
                'reportes.egresos',
                'reportes.export',
                'config.view',
                'config.metodos_pago',
                'config.conceptos_pago',
                'config.frecuencias_pago',
            ]
        );
        $tesorero->givePermissionTo($tesoreroPermissions);

        // 4. SECRETARIO - Enfoque en documentos, actas y reuniones
        $secretario = Role::create(['name' => 'secretario']);
        $secretarioPermissions = array_merge(
            [
                'personas.view',
                'empadronados.view',
                'familiares.view',
                'viviendas.view',
            ],
            $reunionesPermissions,
            $documentosPermissions,
            [
                'juntas.view',
                'reportes.asistencias',
                'reportes.empadronados',
                'reportes.export',
                'config.view',
                'config.tipos_reunion',
            ]
        );
        $secretario->givePermissionTo($secretarioPermissions);

        // 5. VOCAL - Solo visualización de información general
        $vocal = Role::create(['name' => 'vocal']);
        $vocalPermissions = [
            'personas.view',
            'empadronados.view',
            'familiares.view',
            'viviendas.view',
            'reuniones.view',
            'reuniones.participaciones',
            'pagos.view',
            'inventarios.view',
            'reportes.general',
            'documentos.view',
            'config.view',
        ];
        $vocal->givePermissionTo($vocalPermissions);

        // 6. ADMINISTRADOR - Gestión técnica del sistema
        $administrador = Role::create(['name' => 'administrador']);
        $administradorPermissions = array_merge(
            $usuariosPermissions,
            $configuracionPermissions,
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
            $pagosPermissions,
            $egresosPermissions,
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
