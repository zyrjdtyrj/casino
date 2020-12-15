<?php

namespace Database\Seeders;

use App\Models\PrizeMoney;
use Illuminate\Database\Seeder;

class CasinoMoney extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('casino_money')
            ->insert([
                'id' => 1,
                'bank' => 10000
            ]);
    }
}
