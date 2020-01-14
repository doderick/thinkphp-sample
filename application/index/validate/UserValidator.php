<?php
/*
 * @Author: doderick
 * @Date: 2020-01-13 23:38:56
 * @LastEditTime : 2020-01-14 20:06:16
 * @LastEditors  : doderick
 * @Description: 用户注册表单验证
 * @FilePath: /tp5/application/index/validate/User.php
 */

namespace app\index\validate;

use think\Validate;

class UserValidator extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'name'     => ['require', 'max' => 50, 'token'],
        'email'    => ['require', 'max' => 255, 'email', 'unique' => 'user'],
        'password' => ['require', 'min' => 6, 'confirm'],
        'captcha'  => ['require', 'captcha'],
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'name.require'     => '名称 不能为空',
        'name.max'         => '名称 不能超过50字符',
        'email.require'    => '邮箱 不能为空',
        'email.email'      => '邮箱 格式不正确',
        'email.unique'     => '邮箱 已被注册',
        'email.max'        => '邮箱 长度过长',
        'password.require' => '密码 不能为空',
        'password.confirm' => '两次密码不一致',
        'password.min'     => '密码 长度不能低于6位',
        'captcha.require'  => '验证码 不能为空',
        'captcha.captcha'  => '验证吗 不正确',
    ];
}
