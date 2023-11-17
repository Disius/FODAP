<?php

namespace Database\Seeders;

use App\Models\Director;
use FontLib\Table\DirectoryEntry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Director::create([
            'nameDirector' => 'José Manuel Rosado Pérez'
        ]);
    }
}
