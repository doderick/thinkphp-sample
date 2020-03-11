<?php
/*
 * @Author: doderick
 * @Date: 2019-07-04 12:03:43
 * @LastEditTime: 2020-03-11 22:05:58
 * @LastEditors: doderick
 * @Description: 路由
 * @FilePath: /route/route.php
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
Route::group('users', function() {
    Route::get('<id>/edit', 'UsersController/edit')->name('users.edit');
    Route::get('<id>', 'UsersController/read')->name('users.read');
    Route::patch('<id>', 'UsersController/update')->name('users.update');
    Route::delete('<id>', 'UsersController/delete')->name('users.delete');
    Route::get('<id>/followings', 'UsersController/followings')->name('users.followings');
    Route::get('<id>/followers','UsersController/followers')->name('users.followers');
    Route::post('followers/<id>', 'FollowersController/save')->name('followers.save');
    Route::delete('followers/<id>', 'FollowersController/delete')->name('followers.delete');
})->model('app\index\model\User');
Route::get('signup$', 'UsersController/create')->name('signup');
Route::get('users$', 'UsersController/index')->name('users.index');
Route::post('users/save', 'UsersController/save')->name('users.save');

// 会话相关路由
Route::get('login', 'SessionsController/create')->name('login');
Route::post('login', 'SessionsController/save')->name('login');
Route::delete('logout', 'SessionsController/delete')->name('logout');

// 邮件激活相关路由
Route::get('signup/<id>/activate/<token>', 'UsersController/activate')->name('activate_email');

// 密码重置相关路由
Route::get('password/reset$', 'PasswordController/showLinkRequestForm')->name('password.request');
Route::post('password/email', 'PasswordController/sendResetLinkEmail')->name('password.email');
Route::get('password/reset/<token>', 'PasswordController/showResetForm')->name('password.reset');
Route::post('password/reset', 'PasswordController/reset')->name('password.update');

// 动态相关路由
Route::post('status/save', 'status/StatusesController/save')->name('statuses.save');
Route::group('status', function() {
    Route::delete('<id>', 'status/StatusesController/delete')->name('statuses.delete');
})->model('app\status\model\Status');

// 帖子资源相关路由
Route::group('topics', function() {
    Route::get('<id>/edit$', 'forums/TopicsController/edit')->name('topics.edit');
    Route::get('<id>/<slug?>', 'forums/TopicsController/read')->name('topics.read');
    Route::patch('<id>', 'forums/TopicsController/update')->name('topics.update');
    Route::delete('<id>', 'forums/TopicsController/delete')->name('topics.delete');
})->model('app\forums\model\Topic');
Route::get('topics$', 'forums/TopicsController/index')->name('topics.index');
Route::get('topics/create$', 'forums/TopicsController/create')->name('topics.create');
Route::post('topics/save', 'forums/TopicsController/save')->name('topics.save');

Route::post('upload_image', 'forums/TopicsController/uploadImage')->name('topics.upload_image');

// 分类资源相关路由
Route::get('categories/<id>$', 'forums/CategoriesController/read')->name('categories.read');

// 回帖相关资源路由
Route::group('replies', function() {
    Route::delete('<id>', 'forums/RepliesController/delete')->name('replies.delete');
});
Route::post('replies/save', 'forums/RepliesController/save')->name('replies.save');


return [

];
