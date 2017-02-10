<?php

namespace App\Http\Controllers;

use App\Models\Timer;
use Illuminate\Http\Request;
use App\Models\Language;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('landing');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::listLanguages();
        return view('home', compact('languages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function leaderBoard()
    {
        return view('public.leaderboard');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function landing()
    {
        return view('public.landing');
    }
}
