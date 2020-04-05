<?php
/*
 * @Author: doderick
 * @Date: 2020-03-13 16:00:26
 * @LastEditTime: 2020-04-05 19:32:09
 * @LastEditors: doderick
 * @Description: 回帖通知类
 * @FilePath: /application/common/notifications/TopicReplied.php
 */

namespace app\common\notifications;

use app\forums\model\Reply;
use app\common\Notification;

class TopicReplied extends Notification
{
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
        parent::__construct();
    }

    /**
     * 将数据转换为数据记录格式
     *
     * @return array
     */
    public function toDatabase() : array
    {
        $topic = $this->reply->topic;
        $link = $topic->link([], 'reply' . $this->reply->id);

        return [
            'reply_id'      => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id'       => $this->reply->user->id,
            'user_name'     => $this->reply->user->name,
            'user_avatar'   => $this->reply->user->avatar,
            'topic_link'    => $link,
            'topic_id'      => $topic->id,
            'topic_title'   => $topic->title,
        ];
    }

    /**
     * 将数据转换为邮件参数
     *
     * @return array
     */
    public function toMail() : array
    {
        $topic = $this->reply->topic;
        $link = $topic->link([], 'reply' . $this->reply->id);
        $replier = $this->reply->user;

        return [
            'view'          => 'emails/notifications/topic_replied',
            'subject'       => $replier->name . ' 回复了你的帖子',
            'body'          => [
                'replier_id'    => $replier->id,
                'replier_name'  => $replier->name,
                'topic_link'    => $link,
                'topic_id'      => $topic->id,
                'topic_title'   => $topic->title,
                'reply_content' => $this->reply->content
            ]
        ];
    }
}
