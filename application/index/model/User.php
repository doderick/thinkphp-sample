<?php

namespace app\index\model;

use think\Model;

class User extends Model
{
    // 设置对应数据表
    protected $table = 'users';

    // 设置主键
    protected $pk = 'id';
}
