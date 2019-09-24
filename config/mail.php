<?php

return [

    'debug'    => Env::get('mail.mail_debug', 0),

    'host'     => Env::get('mail.mail_host'),

    'port'     => Env::get('mail.mail_port', 587),

    'charset'  => Env::get('mail.mail_charset', 'utf8'),

    'username' => Env::get('mail.mail_username'),

    'password' => Env::get('mail.mail_password'),

    'smtp'     => [

        'secure' => Env::get('mail.mail_smtp_secure', 'ssl'),

        'auth'   => Env::get('mail.mail_smtp_auth', true),
    ],

    'from'     => [

        'address'  => Env::get('mail.mail_from_address'),

        'fromname' => Env::get('mail.mail_from_name'),
    ],
];