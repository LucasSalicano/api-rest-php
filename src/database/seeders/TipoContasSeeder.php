<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoContasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_conta')->insert([[
            'nome' => 'POUPANCA'
        ],[
            'nome' => 'CORRENTE'
        ]]);
    }
}
