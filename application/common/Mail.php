<?php
/*
 * @Author: doderick
 * @Date: 2020-03-02 14:09:12
 * @LastEditTime: 2020-04-05 18:39:54
 * @LastEditors: doderick
 * @Description: 邮件类
 * @FilePath: /application/common/Mail.php
 */

namespace app\common;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mail
{
    /**
     * 发送邮件
     *
     * @param string $to 收件人邮箱地址
     * @param string $subject 邮件主题
     * @param string $body 邮件正文
     * @return void
     */
    public function send(string $to = '', string $subject = '', string $body = '')
    {
        $mailSender = new PHPMailer();

        // Debug mode
        $mailSender->SMTPDebug  = config('mail.debug');

        // Server settings
        $mailSender->isSMTP();
        $mailSender->CharSet    = config('mail.charset');
        $mailSender->Host       = config('mail.host');
        $mailSender->Port       = config('mail.port');
        $mailSender->SMTPAuth   = config('mail.smtp.auth');
        $mailSender->SMTPSecure = config('mail.smtp.secure');
        $mailSender->Username   = config('mail.username');
        $mailSender->Password   = config('mail.password');

        // Recipients
        $mailSender->setFrom(config('mail.from.address'), config('mail.from.name'));
        $mailSender->addAddress($to);

        // Content
        $mailSender->isHTML(true);
        $mailSender->Subject = $subject;
        $mailSender->Body    = $body;

        try {
            $mailSender->send();
        } catch (Exception $e) {
            throw $mailSender->ErrorInfo;
        }
    }

    /**
     * 获取邮件内容
     *
     * @param string $view 邮件正文模板
     * @param array $data 邮件正文填充数据
     * @return string
     */
    public function getMailBody(string $view, array $data) : string
    {
        return view($view, $data)->getContent();
    }
}
