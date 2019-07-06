<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 静态页面相关路由
Route::get('', 'index/home')->name('home');
Route::get('home', 'index/home')->name('home');
Route::get('help', 'index/help')->name('help');
Route::get('about', 'index/about')->name('about');

// 用户资源相关路由
Route::get('signup', 'user/create')->name('signup');

return [

];
