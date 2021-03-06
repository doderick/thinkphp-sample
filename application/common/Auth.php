<?php
/*
 * @Author: doderick
 * @Date: 2020-03-02 14:09:12
 * @LastEditTime: 2020-03-24 21:31:16
 * @LastEditors: doderick
 * @Description: 用户认证类
 * @FilePath: /application/common/Auth.php
 */

namespace app\common;

use think\facade\Cookie;
use think\facade\Session;
use app\index\model\User;
use app\common\facade\Str;

class Auth
{
    protected $user;

    /**
     * 调用logout方法的标识
     *
     * @var boolean
     */
    protected $loggedOut = false;

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

        $this->user = $user;
        $this->loggedOut = false;
    }

    /**
     * 退出登录状态
     *
     * @return void
     */
    public function logout()
    {
        //$user = $this->user();
        Session::delete('user');
        if (Cookie::get('remember_token')) {
            Cookie::delete('remember_token');
        }
        $this->user = null;
        $this->loggedOut = true;

    }

    /**
     * 检查登录状态
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return !is_null($this->user());
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
        // 判断有没有调用过logout方法,即用户是否执行了登出操作
        if ($this->loggedOut) {
            return false;
        }
        // 尝试获取用户信息,并返回
        if (!is_null($this->user)) {
            return $this->user;
        }
        // 尝试从session中取出用户信息并返回
        $userFromSession = Session::get('user');
        if (!is_null($userFromSession)) {
            $user = User::where('id', $userFromSession->id)->find();
            $this->user = $user;
        }
        // 尝试从cookie中取出用户信息
        else {
            $userFromCookie = Cookie::get('remember_token');
            if (!is_null($userFromCookie)) {
                $user = User::where('rememberToken', $userFromCookie)->find();
                Session::set('user', $user);
                $this->user = $user;
            }
        }

        return $this->user;
    }

    /**
     * 用户操作授权验证
     *
     * @param array $method 需要进行验证的方法
     * @param array $args   验证参数
     * @param string $model 需要进行验证的模型策略
     * @return bool
     */
    public function authorize($method, $args = [], $model = 'User') : bool
    {
        // 先判断用户是否登录
        if (!$this->user) return false;

        $modelPolicy = '\app\common\policies\\' . ucfirst($model) . 'Policy';
        $policy = new $modelPolicy;
        return $policy->$method($this->user, $args);
    }

    /**
     * 微博操作授权验证
     *
     * @param string $method    需要进行验证的方法
     * @param array $args       验证参数
     * @return boolean
     */
    public function status($method, $args = []) : bool
    {
        // 先判断用户是否登录
        if (!$this->user) return false;

        $policy = new \app\common\policies\StatusPolicy;
        return $policy->$method($this->user, $args);
    }
}
