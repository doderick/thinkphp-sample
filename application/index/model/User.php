<?php

namespace app\index\model;

use think\Model;

class User extends Model
{
    // 设置对应数据表
    protected $table = 'users';

    // 设置主键
    protected $pk = 'id';

    protected $autoWriteTimestamp = 'datetime';

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->getAttr('email'))));
        return "https://s.gravatar.com/avatar/{$hash}?s={$size}";
    }

    // 一个用户关联多条微博
    public function statuses()
    {
        return $this->hasMany('Status');
    }

    // 取出用户所有的微博
    public function feed()
    {
        return $this->statuses()
                    ->order('create_time', 'desc');
    }
}
