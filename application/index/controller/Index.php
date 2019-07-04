<?php
namespace app\index\controller;

class Index
{
    public function home()
    {
        return view('home');
    }
    public function help()
    {
        return view('help');
    }
    public function about()
    {
        return view('about');
    }
}
