<?php
/*
 * @Author: doderick
 * @Date: 2020-01-18 23:12:10
 * @LastEditTime : 2020-01-19 00:02:38
 * @LastEditors  : doderick
 * @Description:用户编辑信息表单验证
 * @FilePath: /tp5/application/index/validate/UserUpdateValidator.php
 */

namespace app\index\validate;

use app\common\facade\Auth;
use think\Validate;

class UserUpdateValidator extends Validate
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
        'introduction' => [
            'max' => 80,
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
        'introduction.max' => '个人简介不能超过 80 个字符～',
    ];
}
