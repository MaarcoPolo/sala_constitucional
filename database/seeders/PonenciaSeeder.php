<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PonenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ponencias')->insert([
            'nombre' => 'PONENCIA 1',
            'titular' => 'MARA GÓMEZ PÉREZ',
        ]);
        DB::table('ponencias')->insert([
            'nombre' => 'PONENCIA 2',
            'titular' => 'JOSÉ NORBERTO RODRÍGUEZ MEDINA',
        ]);
        DB::table('ponencias')->insert([
            'nombre' => 'PONENCIA 3',
            'titular' => 'ISMAEL DE GANTE LÓPEZ',
        ]);
        DB::table('ponencias')->insert([
            'nombre' => 'PONENCIA 4',
            'titular' => 'YRINA YANET SIERRA JIMÉNEZ',
        ]);
        DB::table('ponencias')->insert([
            'nombre' => 'PONENCIA 5',
            'titular' => 'EMMA MÓNICA GARIBAY HERNÁNDEZ',
        ]);
        DB::table('ponencias')->insert([
            'nombre' => 'PONENCIA 5',
            'titular' => 'EMMA MÓNICA GARIBAY HERNÁNDEZ',
        ]);
        DB::table('ponencias')->insert([
            'nombre' => 'SECRETARÍA DE PLENO',
            'titular' => 'JOSÉ HERMINIO PÉREZ MERLIN',
        ]);
    }
}
