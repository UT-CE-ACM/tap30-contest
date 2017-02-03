<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
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
}
