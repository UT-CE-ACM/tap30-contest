<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Round;
use App\Models\Timer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Language;
use League\Flysystem\Exception;

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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function table()
    {
        $roundsRecords = [];
        $lastRound = Round::all()->last();
        if ($lastRound == null)
            return response()->redirectTo('/home');
        $endFlag = false;

        $roundRecords = $lastRound->records;
        array_push($roundsRecords, $roundRecords);

        while (!$endFlag){
            $roundRecords->load(['first_record', 'second_record', 'round']);
            $prevRoundRecords = new Collection();
            foreach ($roundRecords as $record){
                if (!$record->first_record) {
                    $endFlag = true;
                    break;
                }
                $prevRoundRecords->push($record->first_record);
                $prevRoundRecords->push($record->second_record);
            }
            if (!$endFlag){
                array_push($roundsRecords, $prevRoundRecords);
                $roundRecords = $prevRoundRecords;
            }
        }

        $roundsRecords = array_reverse($roundsRecords);
        return view('public.table', compact('roundsRecords'));
    }


}
