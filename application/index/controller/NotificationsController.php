<?php
/*
 * @Author: doderick
 * @Date: 2020-03-24 15:42:37
 * @LastEditTime: 2020-03-26 09:42:21
 * @LastEditors: doderick
 * @Description: 通知控制器
 * @FilePath: /application/index/controller/NotificationsController.php
 */

namespace app\index\controller;

use think\Request;
use think\Controller;
use app\common\facade\Auth;

class NotificationsController extends Controller
{
    // 使用中间件过滤请求
    protected $middleware = [
        'Auth'
    ];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $notifications = Auth::user()->unreadNotifications()->paginate(20);
        Auth::user()->markAsRead();
        return view('notifications/index', compact('notifications'));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
