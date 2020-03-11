<?php
/*
 * @Author: doderick
 * @Date: 2020-03-11 16:57:55
 * @LastEditTime: 2020-03-11 17:08:45
 * @LastEditors: doderick
 * @Description: 保存回帖验证器
 * @FilePath: /application/forums/validate/ReplySaveValidator.php
 */

namespace app\forums\validate;

use think\Validate;

class ReplySaveValidator extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'content'  => 'require|min:3',
        'topic_id' => 'require|number|token'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'content.require'  => '回帖内容不能为空',
        'content.min'      => '回帖内容必须至少三个字',
        'topic_id.require' => '帖子错误',
        'topic_id.number'  => '帖子错误',
    ];
}
