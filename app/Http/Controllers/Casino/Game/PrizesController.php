<?php

namespace App\Http\Controllers\Casino\Game;

use App\Models\Prize;
use App\Services\Casino;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class PrizesController extends Controller
{

    public function prizes(Request $request)
    {

        /**
         * @var $casinoService Casino
         */
        $casinoService = App::make('CasinoService');
        $gambler = $casinoService->getGambler();
        $bonusBalance = $gambler->bonus;
        $prizes = Prize::getPrizesOfGambler($gambler);
        $message = $request->session()->pull('message');
        $error = $request->session()->pull('error');

        return view('casino.prizes', [
            'prizes' => $prizes,
            'message' => $message,
            'error' => $error,
            'bonusBalance' => $bonusBalance
        ]);

    }

    public function prizeCancel(Request $request)
    {
        $prizeCancelId = request('cancel');
        $prizeConvertId = request('convert');

        if (!$prizeCancelId && !$prizeConvertId) {
            redirect()->back();
        }

        try {
            if ($prizeCancelId) {
                $prize = Prize::find($prizeCancelId);
                $prize->state = 'canceled';
            } else {
                $prize = Prize::find($prizeConvertId);
                $prize->state = 'converted';
            }
            $prize->save();
            $request->session()->flash('message', 'Successful!');

        } catch (\Exception $exception) {
            $request->session()->flash('error', $exception->getMessage());
        }
        return redirect()->route('casino.prizes');
    }
}
