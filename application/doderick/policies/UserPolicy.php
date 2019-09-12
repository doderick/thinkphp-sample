<?php

namespace app\doderick\policies;

class UserPolicy
{
    /**
     * 验证删除权限
     *
     * @param object $currentUser 当前用户
     * @param object $user        删除操作对象
     * @return bool
     */
    public function delete($currentUser, $user) : bool
    {
        return $currentUser->is_admin && $currentUser->id != $user->id;
    }

    /**
     * 验证更新权限
     *
     * @param object $currentUser 当前用户
     * @param object $user        更新操作对象
     * @return bool
     */
    public function update($currentUser, $user) : bool
    {
        return $currentUser->id === $user->id;
    }
}