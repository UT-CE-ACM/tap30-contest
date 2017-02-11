<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('members')->get();
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.insert')->with('user', new User());
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
            "name" => "required",
            "username" => "required",
            "password" => "required|confirmed",
            "password_confirmation" => "required",
            "m1_name" => "required",
            "m1_email" => "required|email",
            "m2_name" => "required",
            "m2_email" => "required|email",
        ];
        $this->validate($request,$rules);
        $user = User::create([
            "name" => $request->get("name"),
            "username" => $request->get("username"),
            "password" => bcrypt($request->get("password"))
        ]);
        Member::create([
                "name" => $request->get('m1_name'),
                "email" => $request->get('m1_email'),
                "user_id" => $user->id
            ]);
        Member::create([
                "name" => $request->get('m2_name'),
                "email" => $request->get('m2_email'),
                "user_id" => $user->id
            ]);
        return redirect('admin/user');
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
        return view('admin.user.insert')->with('user', User::with('members')->find($id));
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
            "name" => "required",
            "username" => "required",
            "password" =>"confirmed",
            "m1_name" => "required",
            "m1_email" => "required|email",
            "m2_name" => "required",
            "m2_email" => "required|email"
        ];
        $this->validate($request, $rules);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        if ($request->get('password') > 0) {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();

        $counter = 1;
        foreach ($user->members as $member){
            $member->name = $request->get('m'.$counter.'_name');
            $member->email = $request->get('m'.$counter.'_email');
            $member->save();
            $counter += 1;
        }
        if ($user->members->isEmpty()){
            Member::create([
                "name" => $request->get('m1_name'),
                "email" => $request->get('m1_email'),
                "user_id" => $user->id
            ]);
            Member::create([
                "name" => $request->get('m2_name'),
                "email" => $request->get('m2_email'),
                "user_id" => $user->id
            ]);
        }


        return redirect('/admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return back();
    }
}
