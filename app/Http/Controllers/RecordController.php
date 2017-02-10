<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Round;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('round_id')){
            $round = Round::find(request()->get('round_id'));
            $records = $round->records;
            $records->load(['teams', 'winner']);
            return view('admin.record.index', compact('records', 'round'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        $record->load(['teams.submits', 'winner', 'round' ]);
        $round = $record->round;
        $runs = array();
        foreach ($record->teams as $team){
            array_push($runs, $team->submits->last()->runs()->with('test_case')->whereRoundId($round->id)->get());
        }
        return view('admin.record.view', compact('runs', 'round', 'record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        /*foreach ($record->teams as $team){
            RunSubmission::handle($team, $round);
        }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}
