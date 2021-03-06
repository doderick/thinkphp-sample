<?php
/*
 * @Author: doderick
 * @Date: 2020-03-02 14:09:12
 * @LastEditTime: 2020-03-24 21:31:57
 * @LastEditors: doderick
 * @Description: 封装facade类(mail)
 * @FilePath: /application/common/facade/Mail.php
 */

namespace app\common\facade;

use think\Facade;

/**
 * @see \app\common\Auth
 *
 * @method bool login() 登录
 */
class Mail extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'app\common\Mail';
    }
}
