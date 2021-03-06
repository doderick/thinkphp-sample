<?php
/*
 * @Author: doderick
 * @Date: 2020-02-13 22:16:40
 * @LastEditTime: 2020-03-07 01:13:47
 * @LastEditors: doderick
 * @Description: 分类控制器
 * @FilePath: /application/forums/controller/CategoriesController.php
 */

namespace app\forums\controller;

use think\Request;
use think\Controller;
use app\forums\model\Topic;
use app\forums\model\Category;

class CategoriesController extends Controller
{
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
        //
    }

    /**
     * 显示指定的分类下的帖子
     *
     * @param \think\Request
     * @param  int  $id
     * @return \think\Response
     */
    public function read(Request $request, int $id)
    {
        $categories = Category::all();
        foreach ($categories as $value) {
            if ($id == $value->id) $category = $value;
        }
        // 读取分类 id 关联的帖子，按规则分页
        $topics = $category->topics()
                            ->withOrder($request->order)
                            ->paginate(20);

        return view('topics/index', compact('topics', 'category', 'categories'));
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
