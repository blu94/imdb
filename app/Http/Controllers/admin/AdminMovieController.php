<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AdminMovieRequest;
use Illuminate\Support\Facades\Session;
use App\Movie;
use App\User;
use App\Asset;
use App\Meta;
use Auth;


class AdminMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $movies = Movie::all();
        return view("admin.movie.index", compact("movies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $producers = User::where("role_id", 2)->get();
        $actors = User::where("role_id", 3)->get();
        return view("admin.movie.create", compact("producers", "actors"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminMovieRequest $request)
    {
        //
        // return $request->all();
        $producer = User::firstOrCreate([
          "name" => $request->producer,
          "role_id" => 2
        ],[
          "name" => $request->producer,
          "email" => null,
          "password" => null,
          "role_id" => 2,
          "birthday" => date("Y-m-d H:i:s"),
          "gender" => "M",
          "bio" => null
        ]);

        $movie = Movie::create([
          "name" => $request->name,
          "releseDate" => date("Y-m-d H:i:s", strtotime($request->yearOfRelease)),
          "plot" => $request->plot,
          "user_id" => Auth::user()->id,
          "producer_id" => $producer->id
        ]);

        // save images
        if (count($request->movieImages) > 0) {
          foreach ($request->movieImages as $imageKey => $image) {
            $asset = Asset::findOrFail($image);
            $asset->update([
              "orders" => $imageKey,
              "assetable_id" => $movie->id,
              "assetable_type" => "App\\Movie"
            ]);
          }
        }

        foreach ($request->actor as $actor) {
          $actor = User::firstOrCreate([
            "name" => $actor,
            "role_id" => 3
          ],[
            "name" => $actor,
            "email" => null,
            "password" => null,
            "role_id" => 3,
            "birthday" => date("Y-m-d H:i:s"),
            "gender" => "M",
            "bio" => null
          ]);

          $meta = Meta::create([
            "type" => "ACTOR_IN_MOVIE",
            "status" => 1,
            "user_id" => $actor->id,
            "metaable_id" => $movie->id,
            "metaable_type" => "App\\Movie"
          ]);
        }

        // return $announcement;
        Session::flash("successMessage", "Movie create succesfully");
        return redirect()->route("admin.movie.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$
        $movie = Movie::findOrFail($id);
        return view("admin.movie.show", compact("movie"));
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
        $movie = Movie::findOrFail($id);
        $producers = User::where("role_id", 2)->get();
        $actors = User::where("role_id", 3)->get();
        return view("admin.movie.edit", compact("movie", "producers", "actors"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminMovieRequest $request, $id)
    {
        //
        // return $request->all();
        $movie = Movie::findOrFail($id);
        if ($request->operationBtn == "delete") {
          $movie->delete();
          Session::flash("successMessage", "Movie delete succesfully");
          return redirect("admin/movie");
        }
        elseif ($request->operationBtn == "update") {
          $producer = User::firstOrCreate([
            "name" => $request->producer,
            "role_id" => 2
          ],[
            "name" => $request->producer,
            "email" => null,
            "password" => null,
            "role_id" => 2,
            "birthday" => date("Y-m-d H:i:s"),
            "gender" => "M",
            "bio" => null
          ]);

          $movie->update([
            "name" => $request->name,
            "releseDate" => date("Y-m-d H:i:s", strtotime($request->yearOfRelease)),
            "plot" => $request->plot,
            "user_id" => Auth::user()->id,
            "producer_id" => $producer->id
          ]);

          // save images
          if (count($request->movieImages) > 0) {
            foreach ($request->movieImages as $imageKey => $image) {
              $asset = Asset::findOrFail($image);
              $asset->update([
                "orders" => $imageKey,
                "assetable_id" => $movie->id,
                "assetable_type" => "App\\Movie"
              ]);
            }
          }

          Meta::where("metaable_id", $movie->id)
          ->where('metaable_type', "App\\Movie")
          ->delete();
          foreach ($request->actor as $actor) {
            $actor = User::firstOrCreate([
              "name" => $actor,
              "role_id" => 3
            ],[
              "name" => $actor,
              "email" => null,
              "password" => null,
              "role_id" => 3,
              "birthday" => date("Y-m-d H:i:s"),
              "gender" => "M",
              "bio" => null
            ]);

            $meta = Meta::firstOrCreate([
              "type" => "ACTOR_IN_MOVIE",
              "status" => 1,
              "user_id" => $actor->id,
              "metaable_id" => $movie->id,
              "metaable_type" => "App\\Movie"
            ],[
              "type" => "ACTOR_IN_MOVIE",
              "status" => 1,
              "user_id" => $actor->id,
              "metaable_id" => $movie->id,
              "metaable_type" => "App\\Movie"
            ]);
          }
        }
        else {
          return redirect()->back();
        }




        Session::flash("successMessage", "Movie update succesfully");
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
