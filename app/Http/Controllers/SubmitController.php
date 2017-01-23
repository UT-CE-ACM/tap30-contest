<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Submit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.submit.index')
            ->with('submits', Submit::withTrashed()->with('attachment')->with('team')->with('problem')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $rules = [
            "lang" => "required|integer|between:0,".(count(Submit::$langs)-1),
            "attachment" => 'required|file',
        ];
        $this->validate($request, $rules);

        $submit = Submit::create([
            "user_id" => Auth::user()->id,
            "problem_id" => $id,
            "lang" => $request->get('lang'),
        ]);

        $submit->saveFile('attachment');

        return back();
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
        $submit = Submit::with('team')->with('problem')->with('attachment')->find($id);
        return view('admin.submit.insert', compact('submit'));
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
            "lang" => "required|integer|between:0,".(count(Submit::$langs)-1),
            "attachment" => 'file',
        ];
        $this->validate($request, $rules);

        $submit = Submit::find($id);
        $submit->lang = $request->get('lang');
        $submit->save();

        if ($request->hasFile('attachment')){
            $submit->saveFile('attachment');
        }
        return redirect('/admin/submit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $submit = Submit::withTrashed()->find($id);
        if ($submit->trashed()){
            if (request()->has('force_delete'))
                $submit->forceDelete();
            else
                $submit->restore();
        }
        else
            $submit->delete();
        return back();
    }
}
