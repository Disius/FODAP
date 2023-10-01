<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosgradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posgrado')->insert([
            ['nombre' => 'Licenciatura'],
            ['nombre' => 'Maestría'],
            ['nombre' => 'Doctorado'],
        ]); 
    }
}
