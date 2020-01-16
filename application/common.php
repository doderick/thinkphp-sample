<?php
/*
 * @Author: doderick
 * @Date: 2019-12-15 18:50:52
 * @LastEditTime : 2020-01-15 23:35:07
 * @LastEditors  : doderick
 * @Description: 自定义公共函数
 * @FilePath: /tp5/application/common.php
 */

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
            $manifests[$manifestPath] = json_decode(@file_get_contents($manifestPath), true);
        }

        $manifest = $manifests[$manifestPath];
        if (!$manifest[$path]) {
            $manifest[$path] = $path;
        }
        return Url::build($manifestDirectory . $manifest[$path], '', false);
    }
}

if (!function_exists('currentRouteName')) {
    /**
     * 获取当前路由标识
     *
     * @return string
     */
    function currentRouteName() {
        $route = Route::getRule(Request::routeInfo()['rule']);
        return $route['get']->getName();
    }
}

if (!function_exists('route_class')) {
    /**
     * 将当前路由标识转换为CSS类名
     *
     * @return string
     */
    function route_class()
    {
        return str_replace('.', '-', currentRouteName());
    }
}

if (!function_exists('old')) {
    /**
     * 返回就表单数据
     *
     * @param String $name
     * @return String|null
     */
    function old(String $name)
    {
        return Session::get('forms.'.$name) ?: '';
    }
}
