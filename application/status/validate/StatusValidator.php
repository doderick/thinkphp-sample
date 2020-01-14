<?php
/*
 * @Author: doderick
 * @Date: 2020-01-05 20:52:38
 * @LastEditTime : 2020-01-14 20:08:24
 * @LastEditors  : doderick
 * @Description: 动态验证器
 * @FilePath: /tp5/application/status/validate/StatusValidator.php
 */

namespace app\status\validate;

use think\Validate;

class StatusValidator extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'content' => 'require|max:140|token'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'content.require' => '说点什么吧～',
        'content.max'     => '内容太长，限140字～'
    ];
}
