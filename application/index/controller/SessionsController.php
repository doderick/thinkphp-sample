<?php

namespace app\index\controller;

use think\Request;
use think\Validate;
use think\Controller;
use think\facade\Session;
use app\common\facade\Auth;

class SessionsController extends Controller
{
    // 使用中间件过滤请求
    protected $middleware = [
        'Guest' => ['only'   => ['create']]
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
            'email'     => $request->param('email'),
            'password'  => $request->param('password'),
            'remember'  => $request->param('remember'),
            '__token__' => $request->param('__token__')
        ];
        $valiadte = Validate::make($rule, $msg);
        $result = $valiadte->batch()->check($data);
        if (!$result) {
            $errors = $valiadte->getError();
            $this->redirect($_SERVER["HTTP_REFERER"], [], 200, ['errors'=>$errors, 'forms'=>$data]);
            $this->redirect($_SERVER["HTTP_REFERER"], [], 200, ['errors'=>$errors, 'forms'=>$data]);
        }

        // 验证通过，登录逻辑
        if (Auth::attempt($data)) {
            if (Auth::user()->is_activated) {
                $message = Auth::user()->name.'，欢迎回来！';

                // 判断是否返回登录前页面
                if ($url = Session::pull('url.intended')) {
                    return redirect()->with(['success'=>$message])->restore();
                }
                // 不需要返回登录前页面，直接进入用户主页
                return redirect('users.read')->params(['id'=>Auth::user()->id])->with(['success'=>$message]);
            } else{
                Auth::logout();
                $message = '你的账号未激活，请检查邮箱中的注册邮件进行激活';
                return redirect(url('home'))->with(['warning'=>$message]);
            }
        } else {
            $message = '很抱歉，您的邮箱和密码不匹配';
            return redirect()->with(['danger'=>$message, 'forms'=>$data])->restore();
        }
        exit;
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
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function delete(Request $request)
    {
        // 验证令牌
        $validate = Validate::make([
            'delete' => 'token',
        ]);

        if (!$validate->batch()->check($request->param())) {
            return redirect()->restore();
        }

        Auth::logout();
        $message = '您已成功退出！';
        return redirect('login')->with(['success'=>$message]);
    }
}
