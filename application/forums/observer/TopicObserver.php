<?php
/*
 * @Author: doderick
 * @Date: 2020-02-17 19:49:53
 * @LastEditTime : 2020-02-17 19:54:46
 * @LastEditors  : doderick
 * @Description: 帖子模型事件观察器
 * @FilePath: /tp5/application/forums/observer/TopicObserver.php
 */

namespace app\forums\observer;

use app\forums\model\Topic;

class TopicObserver
{
    public function beforeInsert(Topic $topic)
    {
        $topic->excerpt = make_excerpt($topic->body);
    }
}
