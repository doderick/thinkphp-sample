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
Route::get('', 'StaticPagesController/home')->name('home');
Route::get('home', 'StaticPagesController/home')->name('home');
Route::get('help', 'StaticPagesController/help')->name('help');
Route::get('about', 'StaticPagesController/about')->name('about');

// 用户资源相关路由
Route::get('signup$', 'UsersController/create')->name('signup');
Route::get('user/:id$', 'UsersController/read')->name('users.read');
Route::get('user/:id/edit', 'UsersController/edit')->name('users.edit');
Route::get('users', 'UsersController/index')->name('users.index');
Route::post('user', 'UsersController/save')->name('users.save');
Route::patch('user/:id', 'UsersController/update')->name('users.update');
Route::delete('user/:id', 'UsersController/delete')->name('users.delete');

// 会话相关路由
Route::get('login', 'SessionsController/create')->name('login');
Route::post('login', 'SessionsController/save')->name('login');
Route::delete('logout', 'SessionsController/delete')->name('logout');

// 邮件激活相关路由
Route::get('signup/:id/activate/:token', 'UsersController/activate')->name('activate_email');

return [

];
