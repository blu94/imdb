<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request);
        if(Auth::check()) {
          if (Auth::user()->isActive == 1) {
            if(Auth::user()->isAdmin()) {
              $response = $next($request);
              return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
              ->header('Pragma','no-cache') //HTTP 1.0
              ->header('Expires','Sat, 01 Jan 1990 00:00:00 GMT');
            }
          }
          else if (Auth::user()->isActive != 1) {
            Auth::logout();
            return redirect('/')->withErrors(["warning"=>"Account is suspended"]);
          }
        }

        return redirect('/');
    }
}
