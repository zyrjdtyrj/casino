<?php

namespace App\Http\Controllers;

use App\Models\Gambler;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        if (Auth::user()) {
            return redirect()->route('casino');
        } else {
            $users = Gambler::all();

            return view('home', ['users' => $users]);
        }
    }
}
