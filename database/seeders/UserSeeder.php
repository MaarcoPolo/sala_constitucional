<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nombre' => 'Informatica',
            'apellido_paterno' => 'informatica',
            'apellido_materno' => 'informatica',
            'email' => 'marco.olivares@pjpuebla.gob.mx',
            'username' => 'superadmin',
            'password' => 'password',
            'tipo_usuario_id' => 1,
        ]);
        DB::table('users')->insert([
            'nombre' => 'Administrador',
            'apellido_paterno' => 'Administrador',
            'apellido_materno' => 'Administrador',
            'email' => 'Administrador@Administradorpj.gob.mx',
            'username' => 'administrador',
            'password' => 'password',
            'tipo_usuario_id' => 2,
        ]);
    }
}
