<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

if (!function_exists('mix')) {
    /**
     * 获取hash后的资源路径
     * 参考laravel5.5
     *
     * @param string $path
     * @param string $manifestDirectory
     * @return string
     */
    function mix($path, $manifestDirectory = '')
    {
        static $manifests = [];

        if (substr($path, 0, 1) !== '/') {
            $path = "/{$path}";
        }
        if ($manifestDirectory && substr($manifestDirectory, 0 , 1) !== '/') {
            $manifestDirectory = "/{$manifestDirectory}";
        }

        $publicPath = Env::get('root_path') . 'public';
        $manifestPath = $publicPath . $manifestDirectory . '/mix-manifest.json';
        if (!isset($manifests[$manifestPath])) {
            $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
        }

        $manifest = $manifests[$manifestPath];
        return Url::build($manifestDirectory . $manifest[$path], '', false);
    }
}
