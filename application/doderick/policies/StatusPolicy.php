<?php

namespace app\doderick\policies;

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