<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization{
    
    public function handle(Request $request, Closure $next){
        if(auth()->user()){
            App::setLocale(auth()->user()->lang);
        }
        return $next($request);
    }
    
}
