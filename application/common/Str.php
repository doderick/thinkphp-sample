<?php
/*
 * @Author: doderick
 * @Date: 2020-01-05 20:29:01
 * @LastEditTime: 2020-03-02 10:07:08
 * @LastEditors: doderick
 * @Description: 封装字符串操作类
 * @FilePath: /application/common/Str.php
 */


namespace app\common;

class Str
{

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     */
    public static function random($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * 限制文本的字符数
     * 超过限定字符数后，多余字符会被删去，并在结尾用指定字符代替
     *
     * @param string $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }
}
