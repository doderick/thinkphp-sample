<?php
/*
 * @Author: doderick
 * @Date: 2020-03-09 22:27:38
 * @LastEditTime: 2020-03-09 22:41:38
 * @LastEditors: doderick
 * @Description: 自定义异常处理
 * @FilePath: /application/exception/ExceptionHandle.php
 */

namespace app\exception;

use think\facade\Response;
use think\exception\Handle;
use think\exception\HttpResponseException;

class ExceptionHandle extends Handle
{
    public function render(\Exception $e)
    {
        if (config('app_debug')) {
            // 如果是 HttpResponseException 异常则原样输出
            if ($e instanceof HttpResponseException) {
                return $e->getResponse();
            }

            // Whoops 接管请求异常
            $whoops = new \Whoops\Run();
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
            return Response::create(
                $whoops->handleException($e),
                'html',
                500
            );
        }

        // 其它错误交给系统处理
        return parent::render($e);
    }
}
