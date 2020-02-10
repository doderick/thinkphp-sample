<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 23:50:59
 * @LastEditTime : 2020-02-10 23:18:52
 * @LastEditors  : doderick
 * @Description: 帖子数据填充文件
 * @FilePath: /tp5/database/seeds/TopicsSeeder.php
 */

use Faker\Factory;
use app\index\model\User;
use think\migration\Seeder;
use app\forums\model\Category;

class TopicsSeeder extends Seeder
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
        $faker = Factory::create(config('app.faker_locale'));
        $data = [];

        // 取出所有的用户id
        $user_ids = User::all()->column('id');

        // 取出所用的分类id
        $category_ids = Category::all()->column('id');

        // 创建100个帖子的数据
        for ($i = 0; $i < 200; $i++) {
            // 创建faker时间
            $updated_at = $faker->dateTimeBetween('-30days');
            $created_at = $faker->dateTimeBetween('-30days', $updated_at);
            $updated_at = (array)$updated_at;
            $created_at = (array)$created_at;

            // 创建帖子内容
            $data[] = [
                'title'       => $faker->sentence(),
                'body'        => $faker->text(),
                'excerpt'     => $faker->sentence(),
                'create_time' => $created_at['date'],
                'update_time' => $updated_at['date'],
                'user_id'     => $faker->randomElement($user_ids),
                'category_id' => $faker->randomElement($category_ids),
            ];
        }

        // 填入数据库
        $this->table('topics')->insert($data)->save();
    }
}
