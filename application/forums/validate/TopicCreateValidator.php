<?php
/*
 * @Author: doderick
 * @Date: 2020-02-17 15:55:57
 * @LastEditTime : 2020-02-18 00:08:40
 * @LastEditors  : doderick
 * @Description: 创建帖子验证器
 * @FilePath: /tp5/application/forums/validate/TopicCreateValidator.php
 */

namespace app\forums\validate;

use think\Validate;

class TopicCreateValidator extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'title'       => 'require|min:2|token',
        'body'        => 'require|min:3',
        'category_id' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'title.require'       => '帖子标题不能为空',
        'title.min'           => '帖子标题必须至少两个字',
        'body.require'        => '帖子内容不能为空',
        'body.min'            => '帖子内容必须至少三个字',
        'category_id.require' => '帖子分类不能为空',
        'category_id.number'  => '帖子分类错误',
    ];
}
