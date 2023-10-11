<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Carrera;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            DepartamentoSeeder::class,
            CarreraSeeder::class,
            PlazaSeeder::class,
            PuestoSeeder::class,
            RoleSeeder::class,
            PosgradoSeeder::class,
            RolHasModelSeeder::class,
            DocenteSeeder::class,
        ]);
    }
}
