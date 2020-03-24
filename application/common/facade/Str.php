<?php
/*
 * @Author: doderick
 * @Date: 2020-03-02 14:09:12
 * @LastEditTime: 2020-03-24 21:32:12
 * @LastEditors: doderick
 * @Description: 封装facade类(Str)
 * @FilePath: /application/common/facade/Str.php
 */

namespace app\common\facade;

use think\Facade;

/**
 * @see \app\common\Str
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
        return 'app\common\Str';
    }
}
