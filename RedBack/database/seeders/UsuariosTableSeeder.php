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
                'fk_idpersonas' => 1,
            ],
            [
                'codigo_usuario' => 'USR002',
                'estado' => true,
                'nomusu' => 'amartinez',
                'password' => bcrypt('password123'),
                'fk_idpersonas' => 2,
            ],
            [
                'codigo_usuario' => 'USR003',
                'estado' => true,
                'nomusu' => 'lramirez',
                'password' => bcrypt('password123'),
                'fk_idpersonas' => 3,
            ],
            [
                'codigo_usuario' => 'USR004',
                'estado' => false,
                'nomusu' => 'mvargas',
                'password' => bcrypt('password123'),
                'fk_idpersonas' => 4,
            ],
            [
                'codigo_usuario' => 'USR005',
                'estado' => true,
                'nomusu' => 'crojas',
                'password' => bcrypt('password123'),
                'fk_idpersonas' => 5,
            ],
        ]);

        $user = Usuario::find(1);
        $user->assignRole('superadmin');
        $user = Usuario::find(2);
        $user->assignRole('presidente');
        $user = Usuario::find(3);
        $user->assignRole('tesorero');
        $user = Usuario::find(4);
        $user->assignRole('secretario');
        $user = Usuario::find(5);
        $user->assignRole('contador');

        // presidente
        // superadmin
        // tesorero
        // secretario
        // vocal
        // administrador
        // operador
        // contador
    }
}
