<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use app\doderick\facade\Auth;

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
        $validate = new \app\index\validate\Status;
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
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
