<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('personas')->insert([
            [
                'dni' => '12345678',
                'fotografia' => null,
                'fecha_nacimiento' => '1990-05-12',
                'primer_apell' => 'García',
                'segundo_apell' => 'Pérez',
                'nombres' => 'Juan Carlos',
                'correo' => 'juan@example.com',
                'telefono' => '987654321',
                'direccion' => 'Av. Los Olivos 123',
                'fk_idgeneros' => 1,
            ],
            [
                'dni' => '87654321',
                'fotografia' => null,
                'fecha_nacimiento' => '1988-03-22',
                'primer_apell' => 'Martínez',
                'segundo_apell' => 'López',
                'nombres' => 'Ana María',
                'correo' => 'ana@example.com',
                'telefono' => '912345678',
                'direccion' => 'Calle Luna 456',
                'fk_idgeneros' => 2,
            ],
            [
                'dni' => '11223344',
                'fotografia' => null,
                'fecha_nacimiento' => '1995-07-10',
                'primer_apell' => 'Ramírez',
                'segundo_apell' => 'Torres',
                'nombres' => 'Luis Alberto',
                'correo' => 'luis@example.com',
                'telefono' => '923456789',
                'direccion' => 'Jr. Sol 789',
                'fk_idgeneros' => 1,
            ],
            [
                'dni' => '44332211',
                'fotografia' => null,
                'fecha_nacimiento' => '1992-11-01',
                'primer_apell' => 'Vargas',
                'segundo_apell' => 'Soto',
                'nombres' => 'María Fernanda',
                'correo' => 'maria@example.com',
                'telefono' => '934567890',
                'direccion' => 'Av. Primavera 321',
                'fk_idgeneros' => 2,
            ],
            [
                'dni' => '55667788',
                'fotografia' => null,
                'fecha_nacimiento' => '1985-09-30',
                'primer_apell' => 'Rojas',
                'segundo_apell' => 'Delgado',
                'nombres' => 'Carlos Andrés',
                'correo' => 'carlos@example.com',
                'telefono' => '945678901',
                'direccion' => 'Pasaje Libertad 654',
                'fk_idgeneros' => 1,
            ],
        ]);
    }
}
