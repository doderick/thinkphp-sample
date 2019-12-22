<?php

namespace app\index\model;

use think\Model;

class Status extends Model
{
    // 设置数据表名
    protected $table = 'statuses';

    // 一条微博关联一个用户
    public function user()
    {
        return $this->belongsTo('user');
    }
}
