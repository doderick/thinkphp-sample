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

    // 关联粉丝
    public function followers()
    {
        return $this->belongsToMany('User', 'followers', 'follower_id', 'user_id');
    }

    // 关联关注的人
    public function followings()
    {
        return $this->belongsToMany('User', 'followers', 'user_id', 'follower_id');
    }

    /**
     * 用户进行关注的方法
     *
     * @param array|integer $user_ids 被关注人的id
     * @return void
     */
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $this->followings()->sync($user_ids);
    }

    /**
     * 用户取消关注的方法
     *
     * @param array|integer $user_ids 取消关注的用户的id
     * @return void
     */
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $this->followings()->detach($user_ids);
    }

    /**
     * 查询是否存在关联
     *
     * @param integer $user_id 需要查询的id
     * @return boolean
     */
    public function isFollowing($user_id)
    {
        return $this->followings()->attached($user_id);
    }
}
