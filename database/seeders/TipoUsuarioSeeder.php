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
            'nombre' => 'Magistrado Presidente',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Magistrado',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Secretario(a) Particular',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Secretario(a) de Acuerdos',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Secretario(a) de Estudio y Cuenta',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Auxiliar',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Notificador',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Secretario(a) de Pleno',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Auxiliar del Secretario de Pleno',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Oficial Mayor',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'Auxiliar de  Oficial Mayor',
        ]);
    }
}
