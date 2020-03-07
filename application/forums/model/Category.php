<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 14:24:29
 * @LastEditTime: 2020-03-07 00:58:54
 * @LastEditors: doderick
 * @Description: 分类控制器
 * @FilePath: /application/forums/model/Category.php
 */

namespace app\forums\model;

use think\Model;

class Category extends Model
{
    // 设置数据表名
    protected $table = 'categories';

    // 关联帖子
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
