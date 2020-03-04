<?php
/*
 * @Author: doderick
 * @Date: 2020-01-05 20:29:01
 * @LastEditTime: 2020-03-03 22:50:30
 * @LastEditors: doderick
 * @Description: 封装字符串操作类
 * @FilePath: /application/common/Str.php
 */


namespace app\common;

class Str
{

    /**
     * 生成随机字符串
     *
     * @param  int  $length
     * @return string
     */
    public static function random($length = 16) : string
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
    public static function limit($value, $limit = 100, $end = '...') : string
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }

    /**
     * 生成slug
     * from laravel
     *
     * @param string $text
     * @param string $separator
     * @return string
     */
    public static function slug(string $text, string $separator = '-') : string
    {
        // Convert all dashes/underscores into separator
        $flip = $separator == '-' ? '_' : '-';

        $text = preg_replace('!['.preg_quote($flip).']+!u', $separator, $text);

        // Replace @ with the word 'at'
        $text = str_replace('@', $separator.'at'.$separator, $text);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $text = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($text));

        // Replace all separator characters and whitespace by a single separator
        $text = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $text);

        return trim($text, $separator);
    }
}
