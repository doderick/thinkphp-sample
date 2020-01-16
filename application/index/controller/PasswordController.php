<?php

namespace app\index\controller;

use think\Db;
use think\Request;
use think\Validate;
use think\Controller;
use app\index\model\User;
use app\common\facade\Str;
use app\common\facade\Mail;
use app\common\facade\Password;

class PasswordController extends Controller
{
    protected $hashKey;

    public function __construct()
    {
        $this->hashKey = 'PasswordReset';
    }

    /**
     * 显示密码重置请求链接
     *
     * @return void
     */
    public function showLinkRequestForm()
    {
        return view('passwords/email');
    }

    /**
     * 发送密码重置邮件
     *
     * @param \think\Request $request
     * @return void
     */
    public function sendResetLinkEmail(Request $request)
    {
        // 验证邮件格式是否符合规则
        $emailValidateRes = $this->validateEmail($request);
        if (true !== $emailValidateRes) {
            return redirect()->with(['errors'=>$emailValidateRes, 'forms'=>$request->param()])->restore();
        }

        $response = $this->sendResetLink($request->only('email'));

        if (Password::INVALID_USER === $response) {
            return redirect()->with(['warning'=>'用户不存在'])->restore();
        }

        if (Password::RESET_LINK_SENT === $response) {
            return redirect()->with(['info'=>'密码重置邮件已发送,请注意查收!'])->restore();
        }
        return redirect()->with(['errors'=>'操作失败'])->restore();
    }

    /**
     * 显示密码重置表单
     *
     * @return void
     */
    public function showResetForm($token = null)
    {
        $reset = Db::table('password_resets')->where('token', $token)->find();
        if ($reset) {
            return view('passwords/reset', ['email'=>$reset['email'],'token'=>$token]);
        }
    }

    /**
     * 执行密码重置操作
     *
     * @return void
     */
    public function reset(Request $request)
    {
        // 验证密码是否符合规则
        $passwordValidateRes = $this->validatePassword($request);
        if (true !== $passwordValidateRes) {
            return redirect()->with(['errors'=>$passwordValidateRes, 'forms'=>$request->param()])->restore();
        }

        $user = User::where($request->only('email'))->find();
        if (is_null($user)) {
            return redirect()->with(['warning'=>'用户不存在'])->restore();
        }
        $response = $this->resetPassword($user, $request->param('password'));
        if (Password::PASSWORD_RESET === $response) {
            return redirect('login')->with(['info'=>'您的密码已经重置,请重新登录~']);
        }
        return redirect()->with(['errors'=>'抱歉,操作失败'])->restore();
    }

    /**
     * 验证邮箱地址的合法性
     *
     * @param Request $request
     * @return Mixed
     */
    protected function validateEmail(Request $request)
    {
        $validate = Validate::make([
            'email' => 'require|email|max:255|token',
        ])->message([
            'email.require' => '邮箱 不能为空',
            'email.email'   => '邮箱 格式不正确',
            'email.max'     => '邮箱 长度过长',
        ]);
        $result = $validate->check($request->param());
        if (!$result) {
            $errors = $validate->getError();
            return $errors;
        }
        return true;
    }

    /**
     * 验证密码合法性
     *
     * @param Request $request
     * @return Mixed
     */
    protected function validatePassword(Request $request)
    {
        $validate = Validate::make([
            'password' => 'require|confirm|min:6|token'
        ])->message([
            'password.require' => '密码 不能为空',
            'password.confirm' => '两次密码不一致',
            'password.min'     => '密码 长度不能低于6位',
        ]);
        $result = $validate->batch()->check($request->param());
        if (!$result) {
            $errors = $validate->getError();
            return $errors;
        }
        return true;
    }

    /**
     * 发送密码重置链接
     *
     * @param array $credentials
     * @return void
     */
    public function sendResetLink(array $credentials)
    {
        // 通过传入参数查找用户
        $user = User::where($credentials)->find();

        if (is_null($user)) {
            return Password::INVALID_USER;
        }

        // 根据请求来源发送重置链接
        // email，sms
        switch (key($credentials)) {
            case 'email':
                $this->sendPasswordResetEmail($user);
                break;
            case 'phone':
                // $this->sendPasswordResetSms($user);
                break;
            default:
                # code...
                break;
        }
        return Password::RESET_LINK_SENT;
    }

    /**
     * 重置密码
     *
     * @param User $user
     * @param String $password
     * @return void
     */
    public function resetPassword($user, $password)
    {
        $user->password = password_hash($password, PASSWORD_BCRYPT);
        $user->save();
        return Password::PASSWORD_RESET;
    }

    /**
     * 发送密码重置邮件
     *
     * @param User $user
     * @return void
     */
    public function sendPasswordResetEmail(User $user)
    {
        $id      = $this->createPasswordResetRecord($user);
        $record  = DB::table('password_resets')->find($id);
        $view    = 'emails/passwords/reset';
        $data    = compact('record');
        $to      = $record['email'];
        $subject = "密码重置";
        Mail::send($view, $data, $to, $subject);
    }

    /**
     * 创建密码重置记录
     *
     * @param User $user
     * @return void
     */
    public function createPasswordResetRecord(User $user)
    {
        $record = [
            'email' => $user->email,
            'token' => $this->createNewToken(),
        ];
        return DB::table('password_resets')->insertGetId($record);
    }

    /**
     * 生成新token
     *
     * @return String
     */
    public function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }
}
