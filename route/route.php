<?php
/*
 * @Author: doderick
 * @LastEditors: doderick
 * @Description: 路由
 */
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
Route::get('status', 'StaticPagesController/status')->name('status');

// 用户资源相关路由
Route::get('signup$', 'UsersController/create')->name('signup');
Route::get('user/:id$', 'UsersController/read')->name('users.read');
Route::get('user/:id/edit', 'UsersController/edit')->name('users.edit');
Route::get('users$', 'UsersController/index')->name('users.index');
Route::post('user', 'UsersController/save')->name('users.save');
Route::patch('user/:id', 'UsersController/update')->name('users.update');
Route::delete('user/:id', 'UsersController/delete')->name('users.delete');

// 会话相关路由
Route::get('login', 'SessionsController/create')->name('login');
Route::post('login', 'SessionsController/save')->name('login');
Route::delete('logout', 'SessionsController/delete')->name('logout');

// 邮件激活相关路由
Route::get('signup/:id/activate/:token', 'UsersController/activate')->name('activate_email');

// 密码重置相关路由
Route::get('password/reset$', 'PasswordController/showLinkRequestForm')->name('password.request');
Route::post('password/email', 'PasswordController/sendResetLinkEmail')->name('password.email');
Route::get('password/reset/:token', 'PasswordController/showResetForm')->name('password.reset');
Route::post('password/reset', 'PasswordController/reset')->name('password.update');

// 注册微博相关路由
Route::post('status', 'status/StatusesController/save')->name('statuses.save');
Route::delete('status/:id', 'status/StatusesController/delete')->name('statuses.delete');

// 注册关注者列表和粉丝列表路由
Route::get('users/:id/followings', 'UsersController/followings')->name('users.followings');
Route::get('users/:id/followers','UsersController/followers')->name('users.followers');

// 注册关注按钮相关路由
Route::post('users/followers/:id', 'FollowersController/save')->name('followers.save');
Route::delete('users/followers/:id', 'FollowersController/delete')->name('followers.delete');

// 帖子资源相关路由
Route::get('topics$', 'forums/TopicsController/index')->name('topics.index');
Route::get('topic/:id$', 'forums/TopicsController/read')->name('topics.read');
Route::get('topics/create$', 'forums/TopicsController/create')->name('topics.create');
Route::get('topic/:id/edit', 'forums/TopicsController/edit')->name('topics.edit');
Route::post('topic', 'forums/TopicsController/save')->name('topics.save');
Route::patch('topic/:id', 'forums/TopicsController/update')->name('topics.update');
Route::post('upload_image', 'forums/TopicsController/uploadImage')->name('topics.upload_image');

// 分类资源相关路由
Route::get('category/:id$', 'forums/CategoriesController/read')->name('categories.read');

return [

];
