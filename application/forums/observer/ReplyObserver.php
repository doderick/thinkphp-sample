<?php
/*
 * @Author: doderick
 * @Date: 2020-03-11 17:26:49
 * @LastEditTime: 2020-03-11 22:42:38
 * @LastEditors: doderick
 * @Description: 回帖模型事件观察器
 * @FilePath: /application/forums/observer/ReplyObserver.php
 */

namespace app\forums\observer;

use app\forums\model\Reply;

class ReplyObserver
{
    /**
     * 回帖写入数据库的前置动作
     *
     * @param \app\forums\model\Reply $reply
     * @return void
     */
    public function beforeInsert(Reply $reply)
    {
        // XSS 攻击预防
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    /**
     * 回帖写入数据库后的动作
     *
     * @param \app\forums\model\Reply $reply
     * @return void
     */
    public function afterInsert(Reply $reply)
    {
        // 相关帖子的回帖计数增加
        // $reply->topic->reply_count = ['inc', 1];
        // $reply->topic->save();

        // 更优的方案是统计所有回帖数量后写入
        $reply->topic->reply_count = $reply->topic->replies()->count();
        $reply->topic->save();
    }
}
