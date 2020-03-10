<?php
/*
 * @Author: doderick
 * @Date: 2020-03-10 14:33:53
 * @LastEditTime: 2020-03-10 21:38:36
 * @LastEditors: doderick
 * @Description: 回帖数据填充文件
 * @FilePath: /database/seeds/RepliesSeeder.php
 */

use Faker\Factory;
use app\index\model\User;
use app\forums\model\Topic;
use think\migration\Seeder;

class RepliesSeeder extends Seeder
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

        // 取出所有的用户ID
        $user_ids = User::all()->column('id');

        // 取出所有帖子ID
        $topic_ids = Topic::all()->column('id');

        // 取出最新发布的帖子
        $last_topic = Topic::order('create_time', 'desc')->limit(1)->find();
        $faker_time_start = $last_topic->create_time ?? 'now';

        // 创建 1000 个回帖
        for ($i = 0; $i < 1000; $i++) {
            // 创建 faker 时间
            $created_at = $faker->dateTimeBetween($faker_time_start, '+7days');
            $updated_at = $faker->dateTimeBetween($created_at, '+7days');
            $created_at = (array)$created_at;
            $updated_at = (array)$updated_at;

            // 创建回帖内容
            $data[] = [
                'topic_id' => $faker->randomElement($topic_ids),
                'user_id'  => $faker->randomElement($user_ids),
                'content'  => $faker->sentence(),
                'create_time' => $created_at['date'],
                'update_time' => $updated_at['date'],
            ];
        }

        // 填入数据库
        $this->table('replies')->insert($data)->save();
    }
}
