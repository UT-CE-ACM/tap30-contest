<?php

namespace App\Http\Controllers;

use App\Models\Timer;
use Illuminate\Http\Request;

class TimerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.timer.index')->with('timers', Timer::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.timer.insert')->with('timer', new Timer());
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
            "starts_at" => "required|date",
            "ends_at" => 'required|date',
        ];
        $this->validate($request, $rules);

        Timer::create([
            'starts_at' => $request->get('starts_at'),
            'ends_at' => $request->get('ends_at'),
        ]);

        return redirect('/admin/timer');
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.timer.insert')->with('timer', Timer::find($id));
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
            "starts_at" => "required|date",
            "ends_at" => 'required|date',
        ];
        $this->validate($request, $rules);

        $timer = Timer::find($id);
        $timer->update([
            'starts_at' => $request->get('starts_at'),
            'ends_at' => $request->get('ends_at'),
        ]);

        return redirect('/admin/timer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Timer::find($id)->delete();
        return back();
    }
}
