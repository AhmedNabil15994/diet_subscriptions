<?php

namespace Modules\Authentication\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {

        if (! $request->expectsJson()) {
            if($request->start){
                session()->put('start',$request->start);
            }
            session()->put('last_url',URL::current());
            return route('frontend.auth.login');
        }
    }
}
