<?php
/*
 * @Author: doderick
 * @Date: 2020-01-13 23:38:56
 * @LastEditTime : 2020-02-10 23:37:13
 * @LastEditors  : doderick
 * @Description: 用户注册表单验证
 * @FilePath: /tp5/application/index/validate/UserSaveValidator.php
 */

namespace app\index\validate;

use think\Validate;

class UserSaveValidator extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'name' => [
            'require',
            'length' => '3,25',
            'regex'  => '/^[A-Za-z0-9\-\_]+$/',
            'unique' => 'users,name',
            'token',
        ],
        'email' => [
            'require',
            'max'    => 255,
            'unique' => 'users',
            'email',
        ],
        'password' => [
            'require',
            'min' => 6,
            'confirm',
        ],
        'captcha' => [
            'require',
            'captcha',
        ],
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'name.require'     => '用户名不能为空~',
        'name.length'      => '用户名必须介于 3 - 25 个字符之间~',
        'name.regex'       => '用户名只支持英文、数字、横杠和下划线~',
        'name.unique'      => '用户名已被占用，请重新填写~',
        'email.require'    => '邮箱地址不能为空～',
        'email.email'      => '邮箱地址格式不正确～',
        'email.unique'     => '邮箱地址已被注册～',
        'email.max'        => '邮箱地址长度过长～',
        'password.require' => '密码不能为空～',
        'password.confirm' => '两次密码不一致～',
        'password.min'     => '密码长度不能低于6位～',
        'captcha.require'  => '验证码不能为空～',
        'captcha.captcha'  => '验证吗不正确～',
    ];
}
