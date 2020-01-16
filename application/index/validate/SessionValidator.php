<?php
/*
 * @Author: doderick
 * @Date: 2020-01-16 21:59:53
 * @LastEditTime : 2020-01-16 22:05:38
 * @LastEditors  : doderick
 * @Description: 用户登录表单验证
 * @FilePath: /tp5/application/index/validate/SessionValidator.php
 */

namespace app\index\validate;

use think\Validate;

class SessionValidator extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'email'    => ['require', 'email', 'max' => 255, 'token'],
        'password' => ['require'],
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'email.require'    => '邮箱 不能为空',
        'email.email'      => '邮箱 格式不正确',
        'email.max'        => '邮箱 长度过长',
        'password.require' => '密码 不能为空',
    ];
}
