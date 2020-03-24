<?php
/*
 * @Author: doderick
 * @Date: 2020-01-04 22:09:05
 * @LastEditTime: 2020-03-24 23:50:54
 * @LastEditors: doderick
 * @Description: 用户模型
 * @FilePath: /application/index/model/User.php
 */

namespace app\index\model;

use think\Model;
use app\common\facade\Auth;
use app\forums\model\Topic;
use app\forums\model\Reply;
use app\status\model\Status;

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
        return $this->hasMany(Status::class);
    }

    // 取出用户所有的微博
    public function feed()
    {
        $user_ids = array_column(User::get($this->id)->followings->toArray(), 'id');
        array_push($user_ids, $this->id);
        return Status::where('user_id', 'in', $user_ids)
                        ->with('user')
                        ->order('create_time', 'desc');
    }

    // 关联粉丝
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    // 关联关注的人
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    // 设置回帖关联
    public function replies()
    {
        return $this->hasMany(Reply::class);
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

        $this->followings()->sync($user_ids, false);
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

    // 关联帖子
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * 判断当前用户是否为模型的所有者
     *
     * @param \think\model $model
     * @return boolean
     */
    public function isOwnerOf($model) : bool
    {
        return $this->id == $model->user_id;
    }

    /**
     * 发送通知
     *
     * @param object $instance 通知实例
     * @return void
     */
    public function notify($instance)
    {
        // 如果回帖给自己则不进行通知
        if ($this->id == Auth::user()->id) {
            return;
        }

        // 通知类型为数据库时，通知计数器进行累加操作
        if ('database' == config('notification.channel')) {
            $this->notification_count = ['inc', 1];
            $this->save();
        }

        // 将数据转换为数据库写入的格式
        $message = $instance->toDatabase();

        // 调用通知
        $instance->notify(get_class($this), $this->id, $message);
    }
}
