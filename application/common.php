<?php
/*
 * @Author: doderick
 * @Date: 2019-12-15 18:50:52
 * @LastEditTime: 2020-03-02 10:06:52
 * @LastEditors: doderick
 * @Description: 自定义公共函数
 * @FilePath: /application/common.php
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

if (!function_exists('currentRouteVars')) {
    /**
     * 获取当前路由的参数
     *
     * @param string $param 需要获取的参数名
     * @return mixed
     */
    function currentRouteVars($param)
    {
        $route = Route::getRule(Request::routeInfo()['rule']);
        $routeVars = $route['get']->getVars();
        return $routeVars[$param] ?? false;
    }
}

if (!function_exists('category_nav_active')) {
    /**
     * 判断分类标签是否激活
     *
     * @param integer $category_id 分类id
     * @return boolean
     */
    function category_nav_active($category_id)
    {
        return 'categories.read' == currentRouteName() && $category_id == currentRouteVars('id');
    }
}

if (!function_exists('query_active')) {
    /**
     * 判断排序按钮是否激活
     *
     * @param string $query 排序key
     * @param string $order 排序value
     * @return void
     */
    function query_active($query, $order)
    {
        $queryArr = explode('&', Request::query());
        foreach ($queryArr as $key => $value) {
            if ("{$query}={$order}" == $value) return true;
        }
        return false;
    }
}

if (!function_exists('old')) {
    /**
     * 返回旧表单数据
     *
     * @param String $name
     * @return String|null
     */
    function old(String $name)
    {
        return Session::get('forms.'.$name) ?: '';
    }
}

if (!function_exists('make_excerpt')) {
    /**
     * 创建摘录
     *
     * @param string $value 需要创建摘录的文本
     * @param int $length 摘录的长度
     * @return string
     */
    function make_excerpt($value, $length = 200)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return app\common\Str::limit($excerpt, $length);
    }
}
