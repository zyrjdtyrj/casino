<?php

namespace Database\Seeders;

use App\Models\Gambler;
use App\Services\Casino;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class Prizes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var $casinoService Casino
         */
        $casinoService = App::make('CasinoService');

        $gamblers = Gambler::all();
        $count = $gamblers->count() * 10;

        for ($i = 0; $i < $count; $i++) {
            $gambler = $gamblers->random(1)->first();
            $casinoService->generatePrize($gambler);
        }
    }
}
