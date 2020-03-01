<?php
/*
 * @Author: doderick
 * @Date: 2020-02-17 19:49:53
 * @LastEditTime: 2020-03-01 22:54:28
 * @LastEditors: doderick
 * @Description: 帖子模型事件观察器
 * @FilePath: /tp5/application/forums/observer/TopicObserver.php
 */

namespace app\forums\observer;

use app\forums\model\Topic;

class TopicObserver
{
    public function beforeInsert(Topic $topic)
    {
        // XSS攻击预防
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成摘录
        $topic->excerpt = make_excerpt($topic->body);
    }
}
