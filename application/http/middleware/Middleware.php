<?php

namespace app\http\middleware;

use think\facade\Session;

class Middleware
{
    // 不需要记住的url
    protected $ignoredUrl = [
        'captcha', 'login', 'logout'
    ];

    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        // 不需要记住的url直接返回
        foreach ($this->ignoredUrl as $urlStr) {
            if (strpos($request->url(), $urlStr)) {
                return $response;
            }
        }

        Session::set('redirect_url', $request->url(true));

        return $response;
    }
}
