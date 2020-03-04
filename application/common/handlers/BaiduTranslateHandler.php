<?php
/*
 * @Author: doderick
 * @Date: 2020-03-03 11:11:38
 * @LastEditTime: 2020-03-03 21:56:35
 * @LastEditors: doderick
 * @Description: 翻译工具 Baidu API
 * @FilePath: /application/common/handlers/BaiduTranslateHandler.php
 */

namespace app\common\handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class BaiduTranslateHandler
{
    // Api URL
    private $api;

    // App id
    private $appid;

    // App key
    private $appkey;

    // 初始化
    public function __construct()
    {
        $this->api    = config('services.baidu_translate.api');
        $this->appid  = config('services.baidu_translate.appid');
        $this->appkey = config('services.baidu_translate.appkey');
    }

    /**
     * 将文本翻译为目标语言
     *
     * @param String $text 需要翻译的文本
     * @param String $from 源语言
     * @param String $to   目标语言
     * @return String
     */
    public function translate(String $text, String $from = 'auto', String $to = 'en') : string
    {
        // 判断是否配置了baidu翻译api及参数，如果没有，则使用pinyin方案
        if (empty($this->api) || empty($this->appid) || empty($this->appkey)) {
            return app(Pinyin::class)->sentence($text);
        }

        // 初始化http客户端
        $httpClient = new Client();

        // 获取api结果
        $response = $httpClient->request('POST', $this->api, $this->getRequestParams($text, $from, $to));

        // 处理结果
        $result = json_decode($response->getBody(), true);
        if (isset($result['trans_result'][0]['dst'])) {
            return $result['trans_result'][0]['dst'];
        } else {
            return app(Pinyin::class)->sentence($text);
        }
    }

    /**
     * 获取api请求参数数组
     *
     * @param String $text 需要翻译的文本
     * @param String $from 源语言
     * @param String $to   目标语言
     * @return array
     */
    private function getRequestParams(String $text, String $from, String $to) : array
    {
        // 以时间戳作为随机数
        $salt = time();

        // 计算签名
        $sign = md5($this->appid . $text . $salt . $this->appkey);

        // 组合参数数组
        $params['form_params'] = [
            'q'     => $text,
            'from'  => $from,
            'to'    => $to,
            'appid' => $this->appid,
            'salt'  => $salt,
            'sign'  => $sign,
        ];

        return $params;
    }
}
