<?php
/*
 * @Author: doderick
 * @Date: 2020-02-17 19:49:53
 * @LastEditTime: 2020-03-10 09:52:21
 * @LastEditors: doderick
 * @Description: 帖子模型事件观察器
 * @FilePath: /application/forums/observer/TopicObserver.php
 */

namespace app\forums\observer;

use think\Queue;
use app\forums\model\Topic;

class TopicObserver
{
    /**
     * 新增帖子前
     *
     * @param \app\forums\model\Topic $topic
     * @return void
     */
    public function beforeInsert(Topic $topic)
    {
        // XSS攻击预防
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    /**
     * 更新帖子前
     *
     * @param \app\forums\model\Topic $topic
     * @return void
     */
    public function beforeUpdate(Topic $topic)
    {

        // XSS攻击预防
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成摘录
        $topic->excerpt = make_excerpt($topic->body);

        // 判断是否需要更新 slug
        // 更新前后 title 发生变化时才重新生成 slug
        $oldTopic = Topic::get($topic->id);

        if (trim($oldTopic->title) != trim($topic->title)) {
            // 推送至队列执行
            Queue::push('forums/SlugTranslate', $topic);
        }
    }

    /**
     * 新建帖子后
     *
     * @param \app\forums\model\Topic $topic
     * @return void
     */
    public function afterInsert(Topic $topic)
    {
        // 推送至队列执行
        Queue::push('forums/SlugTranslate', $topic);
    }
}
