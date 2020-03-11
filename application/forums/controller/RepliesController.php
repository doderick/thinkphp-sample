<?php
/*
 * @Author: doderick
 * @Date: 2020-03-10 21:36:30
 * @LastEditTime: 2020-03-11 23:28:03
 * @LastEditors: doderick
 * @Description: 回帖控制器
 * @FilePath: /application/forums/controller/RepliesController.php
 */

namespace app\forums\controller;

use think\Request;
use think\Controller;
use think\facade\Validate;
use app\common\facade\Auth;
use app\forums\model\Reply;
use app\forums\validate\ReplySaveValidator;

class RepliesController extends Controller
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
     * 保存新建的回帖
     *
     * @param  \think\Request  $request
     * @param  \app\forums\model\Reply $reply
     * @return \think\Response
     */
    public function save(Request $request, Reply $reply)
    {
        // 验证表单数据
        $validator = new ReplySaveValidator();
        if (!$validator->batch()->check($request->param())) {
            $errors = $validator->getError();
            $forms  = $request->param();
            return redirect()->with([
                'errors' => $errors,
                'forms'  => $forms,
            ])->restore();
        }
        $data = $request->param();

        // 预防 XSS 攻击
        $content = clean($data['content'], 'user_topic_body');
        // 如果过滤后的内容为空，不予保存
        if (empty($content)) {
            return redirect()->with([
                'danger' => '回帖内容无法识别'
            ])->restore();
        }

        $data['user_id']  = Auth::user()->id;
        $data['topic_id'] = $request->topic_id;

        $reply->allowField(true)->save($data);

        // 回帖发布成功后的跳转
        return redirect($reply->topic->link(), '', 301)->with(['success'=>'回帖成功']);
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
     * 删除指定回帖
     *
     * @param  \think\Request  $request
     * @param  \app\forums\model\Reply $reply
     * @return \think\Response
     */
    public function delete(Request $request, Reply $reply)
    {
        // 验证令牌
        $validator = Validate::make([
            'id' => 'token'
        ]);
        if (false == $validator->batch()->check($request->param())) {
            return redirect()->restore();
        }

        // 验证权限
        if (false == Auth::authorize('delete', $reply, 'Reply')) {
            $info = 'danger';
            $msg  = '抱歉,您没有权限!';
            return redirect()->with([$info=>$msg])->restore();
        }
        $reply->delete();
        $info = 'success';
        $msg  = '回帖已删除！';
        return redirect($reply->topic->link())->with([$info => $msg]);
    }
}
