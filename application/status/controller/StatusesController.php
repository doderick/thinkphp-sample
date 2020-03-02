<?php

namespace app\status\controller;

use think\Request;
use think\Controller;
use think\facade\Validate;
use app\common\facade\Auth;
use app\status\model\Status;

class StatusesController extends Controller
{
    // 使用中间件过滤请求
    protected $middleware = [
        'Auth',
    ];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
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
        $validate = new \app\status\validate\StatusSaveValidator();
        if (!$validate->batch()->check($request->param())) {
            $errors = $validate->getError();
            $forms  = $request->param();
            return redirect()->with([
                'errors' => $errors,
                'forms'  => $forms
                ])->restore();
        }

        Auth::user()->statuses()->save([
            'content' => $request->param('content')
        ]);
        $message = '发布成功！';
        return redirect()->with([
            'success' => $message
        ])->restore();
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
     * 删除微博
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function delete(Request $request)
    {
        // 验证令牌
        $validate = Validate::make([
            'id' => 'token',
        ]);

        if (!$validate->batch()->check($request->param())) {
            return redirect()->restore();
        }

        $id = $request->param('id');

        // 确定资源是否存在
        $status = Status::find($id);
        if (null == $status) {
            $info = 'warning';
            $msg  = '微博不存在或已被删除！';
            return redirect()->with([$info=>$msg])->restore();
        }

        // 没有权限
        if (false == Auth::authorize('delete', $status, 'Status')) {
            $info = 'danger';
            $msg  = '抱歉，您没有权限！';
            return redirect()->with([$info=>$msg])->restore();
        }

        // 有权限，执行删除
        Status::destroy($id);
        $info = 'success';
        $msg  = '微博已成功删除！';
        return redirect()->with([$info=>$msg])->restore();
    }
}
