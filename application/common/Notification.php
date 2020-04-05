<?php
/*
 * @Author: doderick
 * @Date: 2020-03-13 16:00:26
 * @LastEditTime: 2020-04-05 19:30:41
 * @LastEditors: doderick
 * @Description: 通知类
 * @FilePath: /application/common/Notification.php
 */

namespace app\common;

use think\Queue;
use Ramsey\Uuid\Uuid;
use app\common\facade\Mail;

class Notification
{
    // 通知方式
    protected $channels;

    public function __construct()
    {
        $this->channels = config('notification.channel');
    }

    /**
     * 设置通知方式
     *
     * @param string $channel
     * @return void
     */
    public function setChannel(string $channels)
    {
        $this->channels = strtolower($channels);
    }

    /**
     * 获取通知方式
     *
     * @return void
     */
    public function getChannel()
    {
        return $this->channels;
    }

    /**
     * 根据设置选择执行通知
     *
     * @param string $type
     * @param integer $id
     * @param array $message
     * @return void
     */
    public function notify(string $type, int $id, array $message)
    {

        foreach(explode(',', $this->channels) as $channel) {
            switch ($channel) {
                case 'database':
                    $this->notifyViaDatabase($type, $id, $message['database']);
                    break;
                case 'mail':
                    $this->notifyViaMail($type, $id, $message['mail']);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    /**
     * 通过数据库方式进行通知
     *
     * @param string $type
     * @param integer $id
     * @param array|mixed $message
     * @return void
     */
    private function notifyViaDatabase(string $type, int $id, array $message)
    {
        // 准备数据
        $data = [
            'id'              => Uuid::uuid4()->toString(),
            'type'            => get_class($this),
            'notifiable_type' => $type,
            'notifiable_id'   => $id,
            'data'            => json_encode($message),
            'read_time'       => null,
        ];

        // 存入数据库
        \think\Db::name('notifications')->insert($data);
    }

    /**
     * 通过邮件方式进行通知
     *
     * @param string $type
     * @param integer $id
     * @param array $message
     * @return void
     */
    private function notifyViaMail(string $type, int $id, array $message)
    {

        // 查询邮件发送对象
        $user = $type::find($id);

        $body = $message['body'];

        // 准备邮件
        $mail = [
            'to'      => $user->email,
            'subject' => $message['subject'],
            'body'    => Mail::getMailBody($message['view'], compact('body'))
        ];

        // 推送至发送队列
        Queue::push('index/MailSend', $mail);
    }
}
