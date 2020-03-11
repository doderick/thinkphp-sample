<?php
/*
 * @Author: doderick
 * @Date: 2020-03-11 20:38:54
 * @LastEditTime: 2020-03-11 23:35:12
 * @LastEditors: doderick
 * @Description: 动态操作权限策略
 * @FilePath: /application/common/policies/StatusPolicy.php
 */

namespace app\common\policies;

class StatusPolicy
{
    /**
     * 验证删除权限
     *
     * @param object $currentUser 当前用户
     * @param object $stauts      删除操作对象
     * @return bool
     */
    public function delete($currentUser, $status) : bool
    {
        return $currentUser->id === $status->user_id;
    }
}
