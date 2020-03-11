<?php
/*
 * @Author: doderick
 * @Date: 2020-03-10 13:27:36
 * @LastEditTime: 2020-03-11 22:12:12
 * @LastEditors: doderick
 * @Description: 回帖模型
 * @FilePath: /application/forums/model/Reply.php
 */

namespace app\forums\model;

use app\index\model\User;
use app\forums\observer\ReplyObserver;

class Reply extends Model
{
    // 设置数据表名
    protected $table = 'replies';

    // 自动写入时间
    protected $autoWriteTimestamp = 'datetime';

    // 设置事件观察者
    protected $observerClass = ReplyObserver::class;

    // 设置用户关联
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 设置帖子关联
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
