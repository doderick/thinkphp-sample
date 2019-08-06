<?php

// 封装facade类(Str)

namespace app\doderick\facade;

use think\Facade;

/**
 * @see \app\doderick\Str
 *
 * @method string random($length = 16) 生成随机字串
 */
class Str extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'app\doderick\Str';
    }
}