<?php
/*
 * @Author: doderick
 * @Date: 2020-01-05 20:29:01
 * @LastEditTime : 2020-02-10 23:09:01
 * @LastEditors  : doderick
 * @Description: 用户数据填充文件
 * @FilePath: /database/seeds/UsersSeeder.php
 */

use Carbon\Carbon;
use Faker\Factory;
use app\common\Str;
use app\index\model\User;
use think\migration\Seeder;

class UsersSeeder extends Seeder
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
        $faker = Factory::create();
        $data = [];

        // 头像列表
        for ($i = 1; $i <= 5; $i++) {
            $avatars[] = config('app.app_host') . "/images/avatar_{$i}.png";
        }

        // 使用固定密码
        $password = password_hash('111111', PASSWORD_BCRYPT);

        for ($i=0; $i < 20; $i++) {
            // 创建faker时间
            $updated_at = $faker->dateTimeBetween('-5years');
            $created_at = $faker->dateTimeBetween('-5years', $updated_at);
            $updated_at = (array)$updated_at;
            $created_at = (array)$created_at;

            $data[] = [
                'name'              => $faker->name,
                'email'             => $faker->unique()->safeEmail,
                'password'          => $password,
                'rememberToken'     => Str::random(10),
                'email_verified_at' => Carbon::now(),
                'avatar'            => $faker->randomElement($avatars),
                'introduction'      => $faker->sentence(),
                'create_time'       => $created_at['date'],
                'update_time'       => $updated_at['date'],
                'is_activated'      => true,
                'is_admin'          => 0,
            ];
        }

        $user_insert = new User;
        $user_insert->saveAll($data);

        // 手动指定1号用户
        $user = User::get(1);
        $user->name         = 'doderick';
        $user->email        = 'doderick@outlook.com';
        $user->introduction = '一心想当工程师';
        $user->avatar       = config('app.app_host') .'/images/avatars/doderick-github.png';
        $user->create_time  = Carbon::now();
        $user->update_time  = Carbon::now();
        $user->is_admin     = true;
        $user->is_activated = true;
        $user->save();
    }
}
