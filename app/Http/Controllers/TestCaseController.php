<?php

namespace App\Http\Controllers;

use App\Models\TestCase;
use Illuminate\Http\Request;

class TestCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $rules = [
            "round_id" => "required|exists:rounds,id",
            "input" => "required|file",
            "output" => "required|file",
        ];
        $this->validate($request, $rules);

        $tc = TestCase::create([
            'round_id' => $request->get('round_id')
        ]);

        $tc->saveFile('input', true);
        $tc->saveFile('output', true);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestCase  $test_case
     * @return \Illuminate\Http\Response
     */
    public function show(TestCase $test_case)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestCase  $test_case
     * @return \Illuminate\Http\Response
     */
    public function edit(TestCase $test_case)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestCase  $test_case
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestCase $test_case)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestCase  $test_case
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestCase $test_case)
    {
        $test_case->delete();
        return back();
    }
}
