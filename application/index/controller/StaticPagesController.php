<?php
namespace app\index\controller;

use think\Controller;

class StaticPagesController extends Controller
{
    public function home()
    {
        return view('static_pages/home');
    }
    public function help()
    {
        return view('static_pages/help');
    }
    public function about()
    {
        return view('static_pages/about');
    }
}
