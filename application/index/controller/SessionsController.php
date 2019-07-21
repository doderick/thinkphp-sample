<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\index\model\User;
use think\facade\Session;

class SessionsController extends Controller
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
        return view('sessions/create');
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
        $rule = [
            'email'    => 'require|email|max:255|token',
            'password' => 'require'
        ];
        $msg  = [
            'email.require'    => '邮箱 不能为空',
            'email.email'      => '邮箱 格式不正确',
            'email.max'        => '邮箱 长度过长',
            'password.require' => '密码 不能为空',
        ];
        $data = [
            'email'    => $request->param('email'),
            'password' => $request->param('password'),
            '__token__' => $request->param('__token__')
        ];
        $valiadte = Validate::make($rule, $msg);
        $result = $valiadte->batch()->check($data);
        if (!$result) {
            $errors = $valiadte->getError();
            $this->redirect($_SERVER["HTTP_REFERER"], [], 200, ['errors'=>$errors, 'forms'=>$data]);
        }

        // 验证通过，登录逻辑
        $user = User::where('email', $data['email'])->find();
        if (!$user) {
            $errors = ['该邮箱尚未在本站注册～'];
            return redirect($_SERVER["HTTP_REFERER"])->with(['errors'=>$errors, 'forms'=>$data]);
        } elseif (!password_verify($data['password'], $user->password)) {
            $message = '很抱歉，您的邮箱和密码不匹配';
            return redirect($_SERVER["HTTP_REFERER"])->with(['danger'=>$message, 'forms'=>$data]);
        } else {
            $message = $user->name.'，欢迎回来！';
            Session::set('user_name', $user->name);
            Session::set('user_id', $user->id);
            return redirect('users.read')->params(['id'=>$user->id])->with(['success'=>$message]);
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
     * 删除指定资源
     *
     * @return \think\Response
     */
    public function delete()
    {
        Session::clear();
        $message = '您已成功退出！';
        return redirect('login')->with(['success'=>$message]);
    }
}
