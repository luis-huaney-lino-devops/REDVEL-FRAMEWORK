<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'codigo_usuario' => 'USR001',
                'estado' => true,
                'nomusu' => 'jgarcia',
                'password' => bcrypt('password123'),
                'tipo_autenticacion' => 'local',
                'fk_idpersonas' => 1,
                'fecha_creacion' => now(),
                'fecha_ultimo_acceso' => now(),
            ],
            [
                'codigo_usuario' => 'USR002',
                'estado' => true,
                'nomusu' => 'amartinez',
                'password' => bcrypt('password123'),
                'tipo_autenticacion' => 'local',
                'fk_idpersonas' => 2,
                'fecha_creacion' => now(),
                'fecha_ultimo_acceso' => now(),
            ],
            [
                'codigo_usuario' => 'USR003',
                'estado' => true,
                'nomusu' => 'lramirez',
                'password' => bcrypt('password123'),
                'tipo_autenticacion' => 'local',
                'fk_idpersonas' => 3,
                'fecha_creacion' => now(),
                'fecha_ultimo_acceso' => now(),
            ],
            [
                'codigo_usuario' => 'USR004',
                'estado' => false,
                'nomusu' => 'mvargas',
                'password' => bcrypt('password123'),
                'tipo_autenticacion' => 'local',
                'fk_idpersonas' => 4,
                'fecha_creacion' => now(),
                'fecha_ultimo_acceso' => now(),
            ],
            [
                'codigo_usuario' => 'USR005',
                'estado' => true,
                'nomusu' => 'crojas',
                'password' => bcrypt('password123'),
                'tipo_autenticacion' => 'local',
                'fk_idpersonas' => 5,
                'fecha_creacion' => now(),
                'fecha_ultimo_acceso' => now(),
            ],
        ]);

        $user = Usuario::find(1);
        $user->assignRole('administrador');
        $user = Usuario::find(2);
        $user->assignRole('operador');
        $user = Usuario::find(3);
        $user->assignRole('rrhh');
    }
}
