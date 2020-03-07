<?php

namespace app\index\controller;

use think\Request;
use think\Validate;
use think\Controller;
use app\index\model\User;
use app\common\facade\Auth;

class FollowersController extends Controller
{
    // 使用中间件过滤请求
    // 用户登录后才有权限操作
    protected $middleware = [
        'Auth'
    ];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 关注操作
     *
     * @param  \think\Request  $request
     * @param  \app\index\model\User $user
     * @return \think\Response
     */
    public function save(Request $request, User $user)
    {
        // 验证令牌
        $validate = Validate::make([
            'id' =>'token',
        ]);

        if (!$validate->batch()->check($request->param())) {
            return redirect()->restore();
        }

        // 没有权限
        if (false == Auth::authorize('follow', $user)) {
            return redirect()->restore();
        }

        // 有权限，执行关注
        Auth::user()->follow($user->id);
        $info = "success";
        $msg  = "关注成功！";
        return redirect()->with([$info=>$msg])->restore();
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 取消关注操作
     *
     * @param  \think\Request  $request
     * @param  \app\index\model\User $user
     * @return \think\Response
     */
    public function delete(Request $request, User $user)
    {
        // 验证令牌
        $validate = Validate::make([
            'id' => 'token',
        ]);

        if (!$validate->batch()->check($request->param())) {
            return redirect()->restore();
        }

        // 没有权限
        if (false == Auth::authorize('follow', $user)) {
            return redirect()->restore();
        }

        // 有权限，执行取消关注
        Auth::user()->unfollow($user->id);
        $info = "success";
        $msg  = "取消关注成功！";
        return redirect()->with([$info=>$msg])->restore();
    }
}
