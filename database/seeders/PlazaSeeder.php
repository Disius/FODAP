<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlazaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_plaza')->insert([
            ['nombre' => 'Directivo'],
            ['nombre' => 'Docente / Interinato'],
            ['nombre' => 'Honorarios'],
        ]);
    }
}
