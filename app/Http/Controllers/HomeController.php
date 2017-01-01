<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $languages = array(
            "C - gcc 5.4.0",
            "C++ - g++ 9.0",
            "Java - java 1.6",
            "Python - python 2.7",
            "Python - python 3.5"
        );
        return view('home', compact('languages'));
    }
}
