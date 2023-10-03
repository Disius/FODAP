<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['email' => 'dda_tgutierrez@tecnm.mx', 'password' => 'desarrollo123'],
            ['email' => 'eleyeca@tuxtla.tecnm.mx', 'password' => 'eleyeca123'],
            ['email' => 'industrial@tuxtla.tecnm.mx', 'password' => 'indus123'],
            ['email' => 'mecanica@tuxtla.tecnm.mx', 'password' => 'mecanica123'],
            ['email' => 'quimica@tuxtla.tecnm.mx', 'password' => 'quimica123'],
            ['email' => 'sistemas@tuxtla.tecnm.mx', 'password' => 'sistemas123'],
            ['email' => 'cead_tgutierrez@tecnm.mx', 'password' => 'cead123'],
            ['email' => 'ing_tgutierrez@tecnm.mx', 'password' => 'ingeni123'],
            ['email' => 'cbas_tgutierrez@tecnm.mx', 'password' => 'cbas123'],
            ['email' => 'cformacion@tuxtla.tecnm.mx', 'password' => 'cformacion123'],
        ]);
    }
}
