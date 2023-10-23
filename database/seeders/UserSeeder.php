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
    }
}
