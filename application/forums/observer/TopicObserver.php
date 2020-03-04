<?php
/*
 * @Author: doderick
 * @Date: 2020-02-17 19:49:53
 * @LastEditTime: 2020-03-05 00:44:50
 * @LastEditors: doderick
 * @Description: 帖子模型事件观察器
 * @FilePath: /application/forums/observer/TopicObserver.php
 */

namespace app\forums\observer;

use app\common\facade\Str;
use app\forums\model\Topic;
use app\common\handlers\BaiduTranslateHandler;

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

        // 对title进行翻译，生成slug
        $topic->slug = Str::slug(app(BaiduTranslateHandler::class)->translate($topic->title));

        // 如果生成的slug正好与路由冲突，则放弃此slug
        if (trim($topic->slug) === 'edit') {
            $topic->slug = '';
        }
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
            // 对title进行翻译，生成slug
            $topic->slug = Str::slug(app(BaiduTranslateHandler::class)->translate($topic->title));

            // 如果生成的slug正好与路由冲突，则放弃此slug
            if (trim($topic->slug) === 'edit') {
                $topic->slug = '';
            }
        }
    }
}
