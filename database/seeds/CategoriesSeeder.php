<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 16:59:56
 * @LastEditTime : 2020-02-09 17:54:18
 * @LastEditors  : doderick
 * @Description: 帖子分类填充文件
 * @FilePath: /tp5/database/seeds/CategoriesSeeder.php
 */

use think\migration\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name'        => '分享',
                'description' => '分享创造，分享发现',
            ],
            [
                'name'        => '教程',
                'description' => '开发技巧，推荐扩展包等',
            ],
            [
                'name'        => '问答',
                'description' => '请保持友善，互帮互助',
            ],
            [
                'name'        => '公告',
                'description' => '站点公告',
            ],
        ];

        $categories = $this->table('categories');
        $categories->insert($data)->saveData();
    }
}
