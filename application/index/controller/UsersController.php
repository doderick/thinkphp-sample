<?php
/*
 * @Author: doderick
 * @Date: 2019-07-07 12:05:03
 * @LastEditTime: 2020-04-05 19:36:47
 * @LastEditors: doderick
 * @Description: 用户控制器
 * @FilePath: /application/index/controller/UsersController.php
 */

namespace app\index\controller;

use Carbon\Carbon;
use think\Request;
use app\common\Str;
use think\Validate;
use think\Controller;
use app\index\model\User;
use think\facade\Session;
use app\common\facade\Auth;
use app\common\facade\Mail;
use app\index\validate\UploaderValidator;
use app\index\validate\UserSaveValidator;
use app\common\handlers\ImageUploadHandler;
use app\index\validate\UserUpdateValidator;

class UsersController extends Controller
{
    // 使用中间件过滤请求
    protected $middleware = [
        'Auth'  => ['except' => ['create', 'save', 'read', 'activate']],
        'Guest' => ['only'   => ['create']]
    ];

    /**
     * 显示用户列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $users = User::paginate(10, false);
        return view('users/index', compact('users'));
    }

    /**
     * 显示用户注册页面
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('users/create');
    }

    /**
     * 保存注册的用户
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        // 验证表单数据
        $validate = new UserSaveValidator;
        if (!$validate->batch()->check($request->param())) {
            $errors = $validate->getError();
            $forms  = $request->param();
            return redirect()->with([
                'errors'=>$errors,
                'forms'=>$forms
                ])->restore();
        }

        // 验证通过
        $user = User::create([
            'name'             => $request->param('name'),
            'email'            => $request->param('email'),
            'password'         => password_hash($request->param('password'), PASSWORD_BCRYPT),
            'activation_token' => Str::random(),
            'avatar'           => config('app.app_host') .'/images/avatar_0.png'
        ]);

        // 注册后发送激活邮件
        $this->sendActivateEmailTo($user);

        // 跳转至用户主页
        // return redirect('users.read')->params(['id'=>$user->id])->with(['success'=>'欢迎，您将在这里开启一段新的旅程~']);

        // 跳转至首页
        return redirect('home')->with(['info'=>'激活邮件已发送到您的邮箱上，请注意查收～']);
    }

    /**
     * 显示用户主页
     *
     * @param  \app\index\model\User $user
     * @return \think\Response
     */
    public function read(User $user)
    {
        // 取出该用户的所有微博
        $statuses = $user->statuses()
                            ->order('create_time', 'desc')
                            ->paginate(10, false);
        $topics = $user->topics()
                        ->withOrder('recent')
                        ->paginate(5, false);
        return view('users/show', compact('user', 'statuses', 'topics'));
    }

    /**
     * 显示用户编辑个人资料页面
     *
     * @param  \app\index\model\User $user
     * @return \think\Response
     */
    public function edit(User $user)
    {
        // 验证操作权限
        if (false == Auth::authorize('update', $user)) {
            $info = 'danger';
            $msg  = '抱歉,您没有权限!';
            return redirect()->with([$info=>$msg])->restore();
        }
        return view('users/edit', compact('user'));
    }

    /**
     * 用户更新个人资料
     *
     * @param  \think\Request  $request
     * @param  \app\common\handlers\ImageUploadHandler $uploader
     * @param  \app\index\model\User $user
     * @return \think\Response
     */
    public function update(Request $request, ImageUploadHandler $uploader, User $user)
    {
        // 验证操作权限
        if (false == Auth::authorize('update', $user)) {
            $info = 'danger';
            $msg  = '抱歉,您没有权限!';
            return redirect()->with([$info=>$msg])->restore();
        }
        // 验证表单数据
        $validate = new UserUpdateValidator();
        if (!$validate->batch()->check($request->param())) {
            $errors = $validate->getError();
            $forms  = $request->param();
            return redirect()->with(['errors'=>$errors, 'forms'=>$forms])->restore();
        }
        // 更新数据
        $data = $request->param();
        if ($user->name === $request->param('name')) {
            unset($data['name']);
        }
        if ($user->introduction === $request->param('introduction')) {
            unset($data['introduction']);
        }

        if ($request->param('password')) {
            $data['password'] = password_hash($request->param('password'), PASSWORD_BCRYPT);
        }
        // 静态方法更新
        // User::update($data, ['id'=>$id]);

        // 如果上传了头像，执行更新操作
        if (isset($request->file()['avatar'])) {
            $avatar = $request->file('avatar');
            $avatarRule = [
                'mimes'      => 'jpeg,bmp,png,gif',
                'dimensions' => '200,200'
            ];

            // 上传验证
            $avatarValidate = new UploaderValidator;
            if (!$avatarValidate->image($avatar, $avatarRule)) {
                $forms  = $request->param();
                $errors['avatar'] = '头像' . $avatarValidate->getError();
                return redirect()->with(['errors'=>$errors, 'forms'=>$forms])->restore();
            }

            $result = $uploader->save($avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['image_path'];
            }
        }

        // 显式更新,更新后直接刷新
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
        } elseif (!empty($data['introduction'])) {
            $info = 'success';
            $msg  = '您的个人简介已修改成功！';
        } elseif (!empty($data['avatar'])) {
            $info = 'success';
            $msg  = '您的头像已修改成功！';
        } else {
            $info = 'info';
            $msg  = '您的资料未经修改！';
        }

        if (count($data) > 1) {
            $info = 'success';
            $msg  = '您的资料已修改成功！';
        }

        return redirect()->with([$info=>$msg])->restore();
    }

    /**
     * 删除用户操作
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
        if (false == Auth::authorize('delete', $user)) {
            // 如果是管理员自己,直接返回
            if (Auth::user()->is_admin) {
                return redirect()->restore();
            }
            // 非管理员携带信息返回
            $info = 'danger';
            $msg  = '抱歉,您没有权限!';
            return redirect()->with([$info=>$msg])->restore();
        }
        // 有权限，执行删除
        $user->delete();
        $info = 'success';
        $msg  = '删除用户操作执行成功！';
        return redirect()->with([$info=>$msg])->restore();
    }

    /**
     * 激活账户的方法
     *
     * @param integer $id 用户的id
     * @param string $token 激活token
     * @return void
     */
    public function activate($id, $token)
    {
        // 根据id寻找用户
        $user = User::where(['id' => $id, 'is_activated' => false])->findOrFail();

        // 比对token
        if ($user->activation_token === $token) {
            $user->is_activated      = true;
            $user->activation_token  = null;
            $user->email_verified_at = Carbon::now();
            $user->save();
        }

        // 验证完成后自动登录
        Auth::login($user);
        // 跳转至用户主页
        return redirect('users.read')->params(['id'=>$user->id])->with(['success'=>'恭喜，您的账户已成功激活！']);
    }

    /**
     * 发送激活邮件的方法
     *
     * @param $user 新注册的用户
     * @return void
     */
    public function sendActivateEmailTo($user)
    {
        $view    = 'emails/users/activate';
        $data    = compact('user');
        $body    = Mail::getMailBody($view, $data);
        $to      = $user->email;
        $subject = "感谢您注册Sample！请确认您的邮箱地址。";
        Mail::send($to, $subject, $body);
    }

    /**
     * 显示关注的人列表
     *
     * @param  \app\index\model\User $user
     * @return void
     */
    public function followings(User $user)
    {
        $users = $user->followings()->paginate(25, false);
        $title = $user->name . '关注的人';
        return view('users/show_follow', compact('users', 'title'));
    }

    /**
     * 显示粉丝列表
     *
     * @param  \app\index\model\User $user
     * @return void
     */
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(25, false);
        $title = $user->name . '的粉丝';
        return view('users/show_follow', compact('users', 'title'));
    }
}
