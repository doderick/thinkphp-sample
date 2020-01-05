<?php

namespace app\status\model;

use think\Model;
use app\index\model\User;

class Status extends Model
{
    // 设置数据表名
    protected $table = 'statuses';

    // 一条微博关联一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
