<?php
/*
 * @Author: doderick
 * @Date: 2020-04-05 13:12:14
 * @LastEditTime: 2020-04-05 19:15:41
 * @LastEditors: doderick
 * @Description: 邮件发送队列任务
 * @FilePath: /application/index/job/MailSend.php
 */

namespace app\index\job;

use think\queue\Job;
use app\common\facade\Mail;

class MailSend
{
    public function fire(Job $job, $mail)
    {
        Mail::send($mail['to'], $mail['subject'], $mail['body']);

        if ($job->attempts() > 3) {

        }

        $job->delete();
    }
}
