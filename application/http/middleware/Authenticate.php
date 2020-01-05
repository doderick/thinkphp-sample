<?php

namespace app\http\middleware;

use think\facade\Session;
use app\common\facade\Auth;

class Authenticate
{
    public function handle($request, \Closure $next)
    {
        if (!Auth::isLoggedIn()) {

            $msg = '请先登录后才能继续浏览';

            Session::set('url.intended', $request->path());

            return redirect('login')->with(['info'=>$msg]);
        }

        return $next($request);
    }
}
