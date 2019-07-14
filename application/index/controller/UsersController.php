<?php

namespace app\index\controller;

use think\Request;
use think\Validate;
use think\Controller;
use think\Session;
use app\index\model\User;

class UsersController extends Controller
{
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
        return view('users/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        // 验证表单数据
        $validate = Validate::make([
            'name'     => 'require|max:50|token',
            'email'    => 'require|email|unique:user|max:255',
            'password' => 'require|confirm|min:6'
        ])->message([
            'name.require'     => '名称 不能为空',
            'name.max'         => '名称 不能超过50字符',
            'email.require'    => '邮箱 不能为空',
            'email.email'      => '邮箱 格式不正确',
            'email.unique'     => '邮箱 已被注册',
            'email.max'        => '邮箱 长度过长',
            'password.require' => '密码 不能为空',
            'password.confirm' => '两次密码不一致',
            'password.min'     => '密码 长度不能低于6位',
        ]);
        // echo '<pre>';
        // print_r(Session::get());
        $result = $validate->batch()->check($request->param());
        if (!$result) {
            $errors = $validate->getError();
            // print_r($errors);
            return view('users/create', ['errors'=>$errors]);
            //return redirect('users/create', ['errors'=>$validate->getError()]);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $user = User::get($id);
        return view('users/show', compact('user'));
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
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
