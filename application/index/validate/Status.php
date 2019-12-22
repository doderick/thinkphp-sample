<?php

namespace app\index\validate;

use think\Validate;

class Status extends Validate
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
