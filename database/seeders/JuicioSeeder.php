<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('juicios')->insert([
            'nombre' => 'Acción de Tutela',
            'nomenclatura' => 'AT'
        ]);
        DB::table('juicios')->insert([
            'nombre' => 'Acciones de Inconstitucionalidad',
            'nomenclatura' => 'AI'
        ]);
        DB::table('juicios')->insert([
            'nombre' => 'Controversia Competenciales',
            'nomenclatura' => 'CC'
        ]);
        DB::table('juicios')->insert([
            'nombre' => 'Acción por Omisión Legislativa',
            'nomenclatura' => 'OL'
        ]);
        DB::table('juicios')->insert([
            'nombre' => 'Consulta interpretación de la Ley Orgánica del Poder Judicial del Estado de Puebla',
            'nomenclatura' => 'NO TIENE'
        ]);
        DB::table('juicios')->insert([
            'nombre' => 'Recurso de Revocación',
            'nomenclatura' => 'RR'
        ]);
        DB::table('juicios')->insert([
            'nombre' => 'Recurso de Revisión',
            'nomenclatura' => 'REV'
        ]);
    }
}
