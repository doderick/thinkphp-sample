<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 23:25:36
 * @LastEditTime : 2020-02-11 23:13:45
 * @LastEditors  : doderick
 * @Description: 帖子模型
 * @FilePath: /tp5/application/forums/model/Topic.php
 */

namespace app\forums\model;

use app\index\model\User;
use think\Model;

class Topic extends Model
{
    // 设置数据表名
    protected $table = 'topics';

    // 自动写入时间
    protected $autoWriteTimestamp = 'datetime';

    // 设置用户关联
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 设置分类关联
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
