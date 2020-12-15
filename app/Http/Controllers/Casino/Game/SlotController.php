<?php

namespace App\Http\Controllers\Casino\Game;

use App\Models\Prize;
use App\Services\Casino;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class SlotController extends Controller
{
    public function show()
    {

        /**
         * @var $casinoService Casino
         */
        $casinoService = App::make('CasinoService');
        $gambler = $casinoService->getGambler();
        $prizes = Prize::getPrizesOfGambler($gambler);
        //dd($prizes);

        return view('casino.slot', ['message' => null]);

    }

    public function play()
    {
        /**
         * @var Casino $casino
         */
        $casino = App::make('CasinoService');
        $prize = $casino->generatePrize();

        return view('casino.slot', ['message' => $prize->getPrizeName()]);

    }
}
