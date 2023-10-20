<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Superadministrador',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Administrador',
        ]);
    }
}
