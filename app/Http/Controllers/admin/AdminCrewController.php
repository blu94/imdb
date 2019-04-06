<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AdminCrewRequest;
use Illuminate\Support\Facades\Session;
use App\User;
use Auth;

class AdminCrewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $producers = User::where("role_id", 2)->get();
        $actors = User::where("role_id", 3)->get();

        return view("admin.crew.index", compact(
          "producers",
          "actors"
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.crew.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCrewRequest $request)
    {
        //
        // return $request->all();
        $user = User::create([
          "name" => $request->name,
          "email" => $request->email,
          "role_id" => $request->role,
          "birthday" => date("Y-m-d H:i:s", strtotime($request->birthday)),
          "gender" => $request->gender,
          "bio" => $request->bio
        ]);

        Session::flash("successMessage", $user->role->title." create succesfully");
        return redirect()->route("admin.crew.show", $user->id);
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
        $user = User::findOrFail($id);
        return view("admin.crew.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        return view("admin.crew.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminCrewRequest $request, $id)
    {
        //
        // return $request->all();
        $user = User::findOrFail($id);
        $user->update([
          "name" => $request->name,
          "email" => $request->email,
          "gender" => $request->gender,
          "birthday" => $request->birthday,
          "bio" => $request->bio
        ]);

        Session::flash("successMessage", $user->name." update succesfully");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
