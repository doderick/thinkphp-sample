<?php

namespace app\http\middleware;

use think\facade\Session;

class Middleware
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        Session::set('redirect_url', $request->url(true));

        return $response;
    }
}
