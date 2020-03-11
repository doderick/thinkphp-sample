<?php
/*
 * @Author: doderick
 * @Date: 2020-03-11 23:33:56
 * @LastEditTime: 2020-03-11 23:39:41
 * @LastEditors: doderick
 * @Description: 回帖操作权限策略
 * @FilePath: /application/common/policies/ReplyPolicy.php
 */

namespace app\common\policies;

use app\index\model\User;
use app\forums\model\Reply;

class ReplyPolicy
{
    public function delete(User $currentUser, Reply $reply) : bool
    {
        return $currentUser->isOwnerOf($reply) || $currentUser->isOwnerOf($reply->topic);
    }
}
