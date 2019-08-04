<?php

namespace app\doderick;

use think\facade\Cookie;
use app\index\model\User;
use think\facade\Session;
use app\doderick\facade\Str;

class Auth
{
    /**
     * 登录操作
     *
     * @param object $user
     * @param boolean $remember
     * @return boolean
     */
    public function login(User $user, $remember = false)
    {
        // 设置session
        Session::set('user', $user);
        // 判断用户是否勾选记住我
        if ($remember) {
            // 如果用户的rememberToken为空,则生成新的token
            if (empty($user->rememberToken)) {
                $remember_token = Str::random(60);
                User::where('email', $user->email)->update(['rememberToken'=>$remember_token]);
            } else {
                $remember_token = $user->rememberToken;
            }

            // 调用cookie的forver方法,写入rememberToken
            Cookie::forever('remember_token', $remember_token);
        }
        return 'login';
    }

    /**
     * 退出登录状态
     *
     * @return void
     */
    public function logout()
    {
        return 'logout';
    }

    /**
     * 检查登录状态
     *
     * @return boolean
     */
    public function isLogin()
    {
        return 'isLogin';

    }

    /**
     * 验证登录信息
     *
     * @param array $credentials 登录验证信息
     * @return boolean
     */
    public function attempt(array $credentials = []) : bool
    {
        $user = User::where('email', $credentials['email'])->find();
        if (!is_null($user) && password_verify($credentials['password'], $user->password)) {

            $this->login($user, $credentials['remember']);
            return true;
        }
        return false;
    }

    /**
     * 获取当前用户信息
     *
     * @return void
     */
    public function user()
    {
        return Session::get('user');
    }

}