<?php

namespace app\doderick;

use PHPMailer\PHPMailer;
use PHPMailer\Exception;

class mail
{
    public function send($view = '', $data = '', $to = '', $subject = '')
    {
        $mailSender = new PHPMailer\PHPMailer();

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
        $mailSender->Body    = view($view, $data)->getContent();

        $mailSender->send();
    }
}