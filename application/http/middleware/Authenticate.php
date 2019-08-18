<?php

namespace app\http\middleware;

use app\doderick\facade\Auth;

class Authenticate
{
    public function handle($request, \Closure $next)
    {
        if (!Auth::isLoggedIn()) {

            $msg = '请先登录后才能继续浏览';

            return redirect('login')->with(['info'=>$msg]);
        }

        return $next($request);
    }
}
