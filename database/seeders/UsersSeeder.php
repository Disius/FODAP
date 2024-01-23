<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['email' => 'dda_tgutierrez@tecnm.mx', 'password' => Hash::make('desarrollo123'), 'departamento_id' => 2, 'role' => 1, 'docente_id' => 1],
            ['email' => 'eleyeca@tuxtla.tecnm.mx', 'password' => Hash::make('eleyeca123'), 'departamento_id' => 3, 'role' => 3, 'docente_id' => 2],
            ['email' => 'industrial@tuxtla.tecnm.mx', 'password' => Hash::make('indus123'), 'departamento_id' => 4, 'role' => 3, 'docente_id' => 3],
            ['email' => 'mecanica@tuxtla.tecnm.mx', 'password' => Hash::make('mecanica123'), 'departamento_id' => 5, 'role' => 3,  'docente_id' => 4],
            ['email' => 'quimica@tuxtla.tecnm.mx', 'password' => Hash::make('quimica123'), 'departamento_id' => 6, 'role' => 3,  'docente_id' => 5],
            ['email' => 'sistemas@tuxtla.tecnm.mx', 'password' => Hash::make('sistemas123'), 'departamento_id' => 7,'role' => 3,  'docente_id' => 6],
            ['email' => 'cead_tgutierrez@tecnm.mx', 'password' => Hash::make('cead123'), 'departamento_id' => 8, 'role' => 3,  'docente_id' => 7],
            ['email' => 'ing_tgutierrez@tecnm.mx', 'password' => Hash::make('ingeni123'), 'departamento_id' => 9, 'role' => 3,  'docente_id' => 8],
            ['email' => 'cbas_tgutierrez@tecnm.mx', 'password' => Hash::make('cbas123'), 'departamento_id' => 1,'role' => 3,  'docente_id' => 9],
            ['email' => 'cformacion@tuxtla.tecnm.mx', 'password' => Hash::make('cformacion123'), 'departamento_id' => 2,'role' => 2,  'docente_id' => 10],
            ['email' => 'l17270705@tuxtla.tecnm.mx', 'password' => Hash::make('exalumnotecnm123'), 'departamento_id' => 7,'role' => 4,  'docente_id' => 36],
        ]);

        $user = User::create([
            'email' => 'admin@tuxtla.tecnm.mx',
            'password' => Hash::make('admin123'),
            'role' => 5
        ]);

        $user->save();

        $user->assignRole('Super Admin');
    }
}
