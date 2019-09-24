<?php

namespace app\http\middleware;

use app\doderick\facade\Auth;
use think\facade\Session;

class authmiddleware
{
    public function handle($request, \Closure $next)
    {
        // return view('static_pages/home');
        if (Auth::isLoggedIn()) {


            return redirect()->with(['success'=>$request->path()])->restore();
        }

        return $next($request);
    }
}
