<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Sample;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sample.index')->with('samples', Sample::with('problem')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $problems = [];
        foreach (Problem::all() as $problem){
            $problems[$problem->id] = $problem->title;
        }
        $sample = new Sample();
        return view('admin.sample.insert', compact('problems', 'sample'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "problem_id" => "required|exists:problems,id",
            "input" => "required",
            "output" => "required"
        ];
        $this->validate($request, $rules);

        Sample::create([
            'problem_id' => $request->get('problem_id'),
            'input' => $request->get('input'),
            'output' => $request->get('output'),
        ]);
        return redirect('/admin/sample');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $problems = [];
        foreach (Problem::all() as $problem){
            $problems[$problem->id] = $problem->title;
        }
        return view('admin.sample.insert',compact('problems'))->with('sample', Sample::with('problem')->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "problem_id" => "required|exists:problems,id",
            "input" => "required",
            "output" => "required"
        ];
        $this->validate($request, $rules);

        $sample = Sample::find($id);
        $sample->problem_id = $request->get('problem_id');
        $sample->input = $request->get('input');
        $sample->output = $request->get('output');
        $sample->save();

        return redirect('/admin/sample');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sample::find($id)->delete();
        return back();
    }
}
