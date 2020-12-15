<?php

namespace App\Http\Controllers\Casino\Game;

use App\Services\Casino;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class CasinoController extends Controller
{

    public function bank(Request $request)
    {
        /**
         * @var $casino Casino
         */
        $casino = App::make('CasinoService');

        $gifts = $casino->giftGetAvailable();
        $moneyBank = $casino->moneyGetAvailable();

        return view('casino.bank', ['moneyBank' => $moneyBank, 'gifts' => $gifts]);
    }
}
