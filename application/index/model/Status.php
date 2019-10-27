<?php

namespace app\index\model;

use think\Model;

class Status extends Model
{
    // 一条微博关联一个用户
    public function user()
    {
        return $this->belongsTo('user');
    }
}
