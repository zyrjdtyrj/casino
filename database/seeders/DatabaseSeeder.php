<?php

namespace Database\Seeders;

use App\Models\CasinoGift;
use App\Models\Gambler;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CasinoMoney::class);
        CasinoGift::factory(50)->create();
        Gambler::factory(10)->create();
        $this->call(Prizes::class);
    }
}
