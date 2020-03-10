<?php
/*
 * @Author: doderick
 * @Date: 2019-07-07 11:03:36
 * @LastEditTime: 2020-03-10 09:50:43
 * @LastEditors: doderick
 * @Description: 静态页面控制器
 * @FilePath: /application/index/controller/StaticPagesController.php
 */
namespace app\index\controller;

use think\Controller;
use app\common\facade\Auth;

class StaticPagesController extends Controller
{
    // 显示主页
    public function home()
    {
        return view('static_pages/home');
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

    // 显示动态页
    public function status()
    {
        $feed_items = [];
        if (Auth::isLoggedIn()) {
            $feed_items = Auth::user()->feed()->paginate(25, false);
        }
        return view('static_pages/status', compact('feed_items'));
    }
}
