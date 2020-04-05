<?php
/*
 * @Author: doderick
 * @Date: 2020-01-04 22:09:05
 * @LastEditTime: 2020-04-05 19:40:25
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

    // 关联帖子
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 设置回帖关联
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // 设置通知关联
    public function notifications()
    {
        return $this->morphMany('Notification', 'notifiable');
    }

    // 未读通知
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_time')->order('create_time', 'desc');
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

        // 获取通知方式
        $channels = explode(',', $instance->getChannel());

        if (in_array('database', $channels)) {
            // 通知类型为数据库时，通知计数器进行累加操作
            $this->notification_count = ['inc', 1];
            $this->save();
            // 将数据转换为数据库写入格式
            $message['database'] = $instance->toDatabase();
        }

        if (in_array('mail', $channels)) {
            // 通知类型为邮件类型时，将数据转换为邮件格式
            $message['mail'] = $instance->toMail();
        }

        // 调用通知
        $instance->notify(get_class($this), $this->id, $message);
    }

    /**
     * 将通知标记为已读
     *
     * @return void
     */
    public function markAsRead()
    {
        $this->unreadNotifications->each(function($notification) {
            $notification->markAsRead();
        });
        $this->notification_count = 0;
        $this->save();
    }

    /**
     * 将通知标记为未读
     *
     * @return void
     */
    public function markAsUnread()
    {
        $this->notifications->each(function($notification) {
            $notification->markAsUnread();
        });
        $this->notification_count = $this->unreadNotifications->count();
        $this->save();
    }
}
