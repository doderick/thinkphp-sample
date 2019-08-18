<?php

namespace app\index\controller;

use think\Request;
use think\Validate;
use think\Controller;
use app\index\model\User;
use think\facade\Session;
use app\doderick\facade\Auth;

class UsersController extends Controller
{

    // 使用中间件过滤请求
    protected $middleware = [
        'Auth'  => ['except' => ['create', 'save', 'read']],
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
        $result = $validate->batch()->check($request->param());
        if (!$result) {
            $errors = $validate->getError();
            $forms  = $request->param();
            return redirect()->with(['errors'=>$errors, 'forms'=>$forms])->restore();
        }

        // 验证通过
        $user = new User;
        $user->save([
            'name'     => $request->param('name'),
            'email'    => $request->param('email'),
            'password' => password_hash($request->param('password'), PASSWORD_BCRYPT),
        ]);

        // 注册后直接登录
        Auth::login($user);

        // 跳转至用户主页
        return redirect('users.read')->params(['id'=>$user->id])->with(['success'=>'欢迎，您将在这里开启一段新的旅程~']);
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
        $user = User::get($id);
        return view('users/edit', compact('user'));
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
        // 验证表单数据
        $validate = Validate::make([
            'name'     => 'require|max:50|token',
            'password' => 'confirm|min:6'
        ])->message([
            'name.require'     => '名称 不能为空',
            'name.max'         => '名称 不能超过50字符',
            'password.confirm' => '两次密码不一致',
            'password.min'     => '密码 长度不能低于6位',
        ]);
        $result= $validate->batch()->check($request->param());
        if (!$result) {
            $errors = $validate->getError();
            $forms  = $request->param();
            return redirect()->with(['errors'=>$errors, 'forms'=>$forms])->restore();
        }
        // 更新数据
        $data = [];
        $data['name'] = $request->param('name');
        if ($request->param('password')) {
            $data['password'] = password_hash($request->param('password'), PASSWORD_BCRYPT);
        }
        // 静态方法更新
        // User::update($data, ['id'=>$id]);

        // 显式更新,更新后直接刷新
        $user = User::get($id);
        $user->isUpdate(true)->save($data);

        // 输出修改成功,并重定向至主页
        // 如果用户修改了密码,要求用户重新登录
        if (!empty($data['password'])) {
            Auth::logout();
            $info = 'success';
            $msg  = '您的密码已修改成功，请重新登录！';
        } elseif (!empty($data['name'])) {
            // 刷新session中的用户名
            Session::set('user.name', $user->name);
            $info = 'success';
            $msg  = '您的用户名已修改成功！';
        } else {
            $info = 'info';
            $msg  = '您的资料未经修改！';
        }

        return redirect()->with([$info=>$msg])->restore();
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
