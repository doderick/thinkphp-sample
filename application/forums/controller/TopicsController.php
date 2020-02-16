<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 23:37:40
 * @LastEditTime : 2020-02-16 23:38:19
 * @LastEditors  : doderick
 * @Description: 帖子控制器
 * @FilePath: /tp5/application/forums/controller/TopicsController.php
 */

namespace app\forums\controller;

use think\Request;
use think\Controller;
use app\forums\model\Topic;
use app\forums\model\Category;

class TopicsController extends Controller
{
    /**
     * 显示资源列表
     *
     * @param \think\Request
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $topics = Topic::withOrder($request->order)->paginate(20, false);
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
