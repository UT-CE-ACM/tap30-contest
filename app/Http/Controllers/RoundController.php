<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Round;
use App\Models\User;
use App\Utils\Submissions\RunSubmission;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.round.index')->with('rounds', Round::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::with('records')->allowed()->get();
        if ($users->count() <= 1)
            return back();
        $round = Round::create([
            "number" => Round::all()->count()+1
        ]);
        while($users->count() > 1){
            $user1 = $users->splice(rand(0, $users->count()-1), 1)->first();
            $user2 = $users->splice(rand(0, $users->count()-1), 1)->first();

            if($user1->records->count() == 0){
                $first_user_record = null;
            } else{
                $first_user_record = $user2->records->max('id');
            }
            if($user2->records->count() == 0){
                $second_user_record = null;
            } else{
                $second_user_record = $user2->records->max('id');
            }

            $record = Record::create([
                "round_id" => $round->id,
                "first_record_id" => $first_user_record,
                "second_record_id" => $second_user_record,
            ]);

            $record->teams()->attach([$user1->id, $user2->id]);
            echo $record->id .'. ';
            echo $user1->name . '  -  ' . $user2->name;
            echo "<br><br>";
        }

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
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function show(Round $round)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function edit(Round $round)
    {
        $round->load(['test_cases', 'records.teams']);
        return view('admin.round.insert', compact('round'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Round $round)
    {
        $round->load(['test_cases', 'records.teams.submits.language']);
        if ($round->test_cases()->count() == 0){
            die("There is no test case to run the round!!");
        }
        if (!$round->attachment){
            die("There is no data file to run the round!!");
        }
        // return $round;
        // running the rounds
        foreach ($round->records as $record){
            foreach ($record->teams as $team){
                RunSubmission::handle($team, $round);
            }
            $firstTeamScore = RunSubmission::finalScore($record->teams[0], $round);
            $secondTeamScore = RunSubmission::finalScore($record->teams[1], $round);
            if ($secondTeamScore < $firstTeamScore){
                $record->winner_id = $record->teams[1]->id;
                $record->teams[0]->has_lost = true;
                $record->teams[0]->save();
            }
            else{
                $record->winner_id = $record->teams[0]->id;
                $record->teams[1]->has_lost = true;
                $record->teams[1]->save();
            }
            $record->save();
        }
        $round->is_finished = true;
        $round->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function destroy(Round $round)
    {
        $round->delete();
        return back();
    }
    public function saveDataFile(Request $request, $id){
        $rules = [
            "attachment" => 'file | required',
        ];
        $this->validate($request, $rules);
        Round::find($id)->saveFile('attachment');
        return back();
    }
}
