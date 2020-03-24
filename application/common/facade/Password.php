<?php
/*
 * @Author: doderick
 * @Date: 2020-03-02 14:09:12
 * @LastEditTime: 2020-03-24 21:32:03
 * @LastEditors: doderick
 * @Description: 封装facade类(password)
 * @FilePath: /application/common/facade/Password.php
 */

namespace app\common\facade;

use think\Facade;

/**
 * @see \app\common\Password
 *
 *
 */
class Password extends Facade
{

    const RESET_LINK_SENT  = 'passwords.sent';

    const PASSWORD_RESET   = 'passwords.reset';

    const INVALID_USER     = 'passwords.user';

    const INVALID_PASSWORD = 'passwords.password';

    const INVALID_TOKEN    = 'passwords.token';
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'app\common\Password';
    }
}
