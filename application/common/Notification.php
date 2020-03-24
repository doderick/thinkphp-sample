<?php
/*
 * @Author: doderick
 * @Date: 2020-03-13 16:00:26
 * @LastEditTime: 2020-03-24 23:58:44
 * @LastEditors: doderick
 * @Description: 通知类
 * @FilePath: /application/common/Notification.php
 */

namespace app\common;

use Ramsey\Uuid\Uuid;

class Notification
{
    // 通知方式
    protected $channel;

    public function __construct()
    {
        $this->channel = config('notification.channel');
    }

    /**
     * 设置通知方式
     *
     * @param string $channel
     * @return void
     */
    public function setChannel(string $channel)
    {
        $this->channel = strtolower($channel);
    }

    /**
     * 根据设置选择执行通知
     *
     * @param string $type
     * @param integer $id
     * @param array|mixed $message
     * @return void
     */
    public function notify($type, $id, $message)
    {
        switch ($this->channel) {
            case 'database':
                $this->notifyViaDatabase($type, $id, $message);
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * 通过数据方式进行通知
     *
     * @param string $type
     * @param integer $id
     * @param array|mixed $message
     * @return void
     */
    private function notifyViaDatabase($type, $id, $message)
    {
        // 准备数据
        $data = [
            'id'              => Uuid::uuid4()->toString(),
            'type'            => get_class($this),
            'notifiable_type' => $type,
            'notifiable_id'   => $id,
            'data'            => serialize($message),
            'read_time'       => null,
        ];

        // 存入数据库
        \think\Db::name('notifications')->insert($data);
    }
}
