<?php
/*
 * @Author: doderick
 * @Date: 2020-03-03 11:26:09
 * @LastEditTime: 2020-03-03 11:31:42
 * @LastEditors: doderick
 * @Description: 第三方服务授权认证信息
 * @FilePath: /config/services.php
 */


return [
    'baidu_translate' => [
        'api'    => env('services.baidu_translate_api'),
        'appid'  => env('services.baidu_translate_appid'),
        'appkey' => env('services.baidu_translate_appkey')
    ],
];
