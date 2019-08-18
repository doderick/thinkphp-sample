<?php

namespace app\http\middleware;

use app\doderick\facade\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, \Closure $next)
    {
        if (Auth::isLoggedIn()) {

            switch ($request->path()) {
                case 'signup':
                    $msg = '您已注册且处于登录状态！';
                    break;
                case 'login':
                    $msg = '您已登录，无需重复操作！';
                    break;
                default:
                    break;
            }
            return redirect()->with(['info'=>$msg])->restore();
        }

        return $next($request);
    }
}
