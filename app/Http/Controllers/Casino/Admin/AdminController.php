<?php

namespace App\Http\Controllers\Casino\Admin;

use App\Models\Prize;
use App\Services\Casino;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{

    public function prizesShow(Request $request)
    {
        /**
         * @var $casino Casino
         */

        $prizes = Prize::where('state', 'wait')->orderBy('id')->limit(20)->get();
        // !!! Preloading completed but not used. This is weird and shouldn't be!
        $prizes->load('gambler');

        $message = $request->session()->pull('message');
        $error = $request->session()->pull('error');

        return view('admin.prizes', ['prizes' => $prizes, 'message' => $message, 'error' => $error]);
    }

    public function prizeAction(Request $request)
    {
        $prizeCancelId = request('cancel');
        $prizeSendId = request('send');

        if (!$prizeCancelId && !$prizeSendId) {
            redirect()->back();
        }

        try {
            if ($prizeCancelId) {
                $prize = Prize::find($prizeCancelId);
                $prize->state = 'canceled';
            }  else {
                $prize = Prize::find($prizeSendId);
                $prize->state = 'receive';
            }
            $prize->save();
            $request->session()->flash('message', 'Successful!');

        } catch (\Exception $exception) {
            $request->session()->flash('error', $exception->getMessage());
        }

        return redirect()->back();
    }
}
