<?php
/*
 * @Author: doderick
 * @Date: 2020-01-05 20:29:01
 * @LastEditTime: 2020-03-02 10:07:23
 * @LastEditors: doderick
 * @Description: 用户操作权限策略
 * @FilePath: /application/common/policies/UserPolicy.php
 */

namespace app\common\policies;

use app\index\model\User;

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

    /**
     * 验证关注权限
     *
     * @param object $currentUser 当前用户
     * @param object $user        关注对象
     * @return boolean
     */
    public function follow($currentUser, $user) : bool
    {
        return $currentUser->id !== $user->id;
    }
}
