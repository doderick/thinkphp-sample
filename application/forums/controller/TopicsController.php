<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 23:37:40
 * @LastEditTime: 2020-03-02 23:44:52
 * @LastEditors: doderick
 * @Description: 帖子控制器
 * @FilePath: /application/forums/controller/TopicsController.php
 */

namespace app\forums\controller;

use think\Request;
use think\Validate;
use think\Controller;
use app\common\facade\Auth;
use app\forums\model\Topic;
use app\forums\model\Category;
use app\common\handlers\ImageUploadHandler;
use app\forums\validate\TopicCreateValidator;

class TopicsController extends Controller
{
    // 使用中间件过滤请求
    protected $middleware = [
        'Auth' => ['except' => ['index', 'read']]
    ];

    /**
     * 显示资源列表
     *
     * @param \think\Request
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $topics = Topic::withOrder($request->order)
                        ->paginate(20, false);
        $categories = Category::all();
        return view('topics/index', compact('topics', 'categories'));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('topics/create_and_edit', compact('categories'));
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @param  \app\forums\model\Topic $topic
     * @return \think\Response
     */
    public function save(Request $request, Topic $topic)
    {
        $validate = new TopicCreateValidator();
        if (!$validate->batch()->check($request->param())) {
            $errors = $validate->getError();
            $forms  = $request->param();
            return redirect()->with([
                'errors' => $errors,
                'forms'  => $forms,
                ])->restore();
        }
        $data = $request->param();

        // 预防 XSS 攻击
        $body = clean($data['body'], 'user_topic_body');
        // 如果过滤后的内容为空。不予保存到数据库
        if (empty($body)) {
            return redirect()->with([
                'danger' => '帖子内容无法识别！'
                ])->restore();
        }

        $data['user_id'] = Auth::user()->id;
        $topic->allowField(true)->save($data);

        // 帖子发布成功后的跳转
        return redirect('topics.read')->params(['id'=>$topic->id])
                                        ->with(['success'=>'帖子发布成功！']);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $topic = Topic::get($id);
        return view('topics/read', compact('topic'));
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  \app\forums\model\Topic  $topic
     * @return \think\Response
     */
    public function edit(Topic $topic)
    {
        if (false == Auth::authorize('update', $topic, 'Topic')) {
            $info = 'danger';
            $msg  = '抱歉,您没有权限!';
            return redirect()->with([$info=>$msg])->restore();
        }
        $categories = Category::all();
        return view('topics/create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  app\forums\model\Topic  $topic
     * @return \think\Response
     */
    public function update(Request $request, Topic $topic)
    {
        // 验证权限
        if (false == Auth::authorize('update', $topic, 'Topic')) {
            $info = 'danger';
            $msg  = '抱歉,您没有权限!';
            return redirect()->with([$info=>$msg])->restore();
        }

        // 内容验证
        $validate = new TopicCreateValidator();
        if (!$validate->batch()->check($request->param())) {
            $errors = $validate->getError();
            $forms  = $request->param();
            return redirect()->with([
                'errors' => $errors,
                'forms'  => $forms,
                ])->restore();
        }
        $data = $request->param();

        // 预防 XSS 攻击
        $body = clean($data['body'], 'user_topic_body');
        // 如果过滤后的内容为空。不予保存到数据库
        if (empty($body)) {
            return redirect()->with([
                'danger' => '帖子内容无法识别！'
                ])->restore();
        }

        $topic->update($data);

        // 帖子更新成功后的跳转
        return redirect('topics.read')->params(['id' => $topic->id])
                                        ->with(['success' => '帖子更新成功！']);
    }

    /**
     * 删除指定资源
     *
     * @param  \think\Request  $request
     * @param  \app\forums\model\Topic  $topic
     * @return \think\Response
     */
    public function delete(Request $request, Topic $topic)
    {
        // 验证令牌
        $validate = Validate::make([
            'id' => 'token',
        ]);
        if (false == $validate->batch()->check($request->param())) {
            return redirect()->restore();
        }

        if (false == Auth::authorize('delete', $topic, 'Topic')) {
            $info = 'danger';
            $msg  = '抱歉,您没有权限!';
            return redirect()->with([$info=>$msg])->restore();
        }
        $topic->delete();
        $info = 'success';
        $msg  = '帖子删除成功！';
        return redirect('topics.index')->with([$info => $msg]);
    }

    /**
     * 上传图片
     *
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return json
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认失败
        $return = [
            'success'   => false,
            'msg'       => '上传失败！',
            'file_path' => '',
        ];
        // 获取上传文件
        if ($file = $request->file()['upload_file']) {
            // 保存图片
            $result = $uploader->save($file, 'topics', Auth::user()->id, 1024);
            if ($result) {
                $return = [
                    'success'   => true,
                    'msg'       => '上传成功！',
                    'file_path' => $result['image_path'],
                ];
            }
        }
        return $return;
    }
}
