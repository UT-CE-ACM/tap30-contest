<?php

namespace App\Http\Controllers;

use App\Models\Record;
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

    /**
     * @param Record $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recordDetail(Record $record)
    {
        $record->load(['teams.submits.runs.test_case.attachments', 'round.attachment']);
        $round = $record->round;
        $runs = array();
        foreach ($record->teams as $team){
            array_push($runs, $team->submits->last()->runs()->with('test_case')->whereRoundId($round->id)->get());
        }
        return view('public.record_detail', compact('record', 'runs', 'round'));
    }
}
