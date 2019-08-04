<?php

// 封装facade类(auth)

namespace app\doderick\facade;

use think\Facade;

/**
 * @see \app\doderick\Auth
 *
 * @method bool login() 登录
 */
class Auth extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'app\doderick\Auth';
    }
}