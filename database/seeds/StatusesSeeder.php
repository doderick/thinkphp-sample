<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 23:50:59
 * @LastEditTime : 2020-02-10 23:18:52
 * @LastEditors  : doderick
 * @Description: 帖子数据填充文件
 * @FilePath: /database/seeds/StatusesSeeder.php
 */

use Faker\Factory;
use think\migration\Seeder;

class StatusesSeeder extends Seeder
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

        $user_ids = ['1','2','3'];

        for ($i=0; $i < 100; $i++) {
            // 创建faker时间
            $updated_at = $faker->dateTimeBetween('-3years');
            $created_at = $faker->dateTimeBetween('-3years', $updated_at);
            $updated_at = (array)$updated_at;
            $created_at = (array)$created_at;

            $data[] = [
                'content'     => $faker->text(),
                'user_id'     => $faker->randomElement($user_ids),
                'create_time' => $created_at['date'],
                'update_time' => $updated_at['date'],
            ];
        }

        $this->table('statuses')->insert($data)->save();
    }
}
