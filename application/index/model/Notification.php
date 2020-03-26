<?php
/*
 * @Author: doderick
 * @Date: 2020-03-25 11:07:48
 * @LastEditTime: 2020-03-26 21:05:52
 * @LastEditors: doderick
 * @Description: 用户通知模型
 * @FilePath: /application/index/model/Notification.php
 */

namespace app\index\model;

use think\Model;
use Carbon\Carbon;

class Notification extends Model
{
    // 设置数据表
    protected $table = 'notifications';

    // 设置主键
    protected $pk = 'id';

    /**
     * 标记已读状态
     *
     * @return void
     */
    public function markAsRead()
    {
        if (is_null($this->read_time)) {
            $this->read_time = Carbon::now();
            $this->save();
        }
    }

    /**
     * 标记未读状态
     *
     * @return void
     */
    public function markAsUnread()
    {
        if (!is_null($this->read_time)) {
            $this->read_time = null;
            $this->save();
        }
    }
}
