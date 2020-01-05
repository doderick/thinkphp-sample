<?php
namespace app\index\controller;

use think\Controller;
use app\common\facade\Auth;

class StaticPagesController extends Controller
{
    // 显示主页
    public function home()
    {
        $feed_items = [];
        if (Auth::isLoggedIn()) {
            $feed_items = Auth::user()->feed()->paginate(25, false);
        }
        return view('static_pages/home', compact('feed_items'));
    }

    // 显示帮助页
    public function help()
    {
        return view('static_pages/help');
    }

    // 显示关于页
    public function about()
    {
        return view('static_pages/about');
    }
}
