<?php
/*
 * @Author: doderick
 * @Date: 2020-03-01 23:25:50
 * @LastEditTime: 2020-03-02 22:48:10
 * @LastEditors: doderick
 * @Description: 帖子操作权限策略
 * @FilePath: /application/common/policies/TopicPolicy.php
 */

namespace app\common\policies;

use app\index\model\User;
use app\forums\model\Topic;

class TopicPolicy
{
    /**
     * 验证更新权限
     *
     * @param User $currentUser 当前用户
     * @param Topic $topic      更新操作对象
     * @return boolean
     */
    public function update(User $currentUser, Topic $topic) : bool
    {
        // return $currentUser->id == $topic->user_id;
        // 优化可读性
        return $currentUser->isOwnerOf($topic);
    }

    /**
     * 验证删除权限
     *
     * @param User $currentUser 当前用户
     * @param Topic $topic      更新操作对象
     * @return boolean
     */
    public function delete(User $currentUser, Topic $topic) : bool
    {
        // return $currentUser->id == $topic->user_id;
        // 优化可读性
        return $currentUser->isOwnerOf($topic);
    }
}
