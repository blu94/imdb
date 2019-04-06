<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// admin middleware
Route::group(["middleware" => "admin"], function() {
  // upload asset
  Route::post("admin/asset/store", ["as" => "admin.asset.store", "uses" => "AssetController@store"]);

  // delete assets
  Route::get("admin/asset/destroy/{id}", ["as" => "admin.asset.destroy", "uses" => "AssetController@destroy"]);

  // admin dashboard controller
  Route::resource("/admin/", "admin\AdminLandingController", [
    "names"=> [
      "index"  => "admin.index"
    ]
  ]);

  // admin movie controller
  Route::resource("/admin/movie", "admin\AdminMovieController", [
    "names"=> [
      "index"  => "admin.movie.index",
      "create"  => "admin.movie.create",
      "store"  => "admin.movie.store",
      "edit"  => "admin.movie.edit",
      "update"  => "admin.movie.update",
      "show"  => "admin.movie.show",
      "destroy"  => "admin.movie.destroy"
    ]
  ]);

  // admin crew controller
  Route::resource("/admin/crew", "admin\AdminCrewController", [
    "names"=> [
      "index"  => "admin.crew.index",
      "create"  => "admin.crew.create",
      "show"  => "admin.crew.show",
      "store"  => "admin.crew.store",
      "edit"  => "admin.crew.edit",
      "update"  => "admin.crew.update",
      "destroy"  => "admin.crew.destroy"
    ]
  ]);
});
