<?php

use Faker\Factory;
use app\doderick\Str;
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
        $faker = Factory::create(config('app.faker_locale'));
        $data = [];

        // 使用固定密码
        $password = password_hash('111111', PASSWORD_BCRYPT);

        for ($i=0; $i < 50; $i++) {
            // 创建faker时间
            $updated_at = $faker->dateTimeBetween('-5years');
            $created_at = $faker->dateTimeBetween('-5years', $updated_at);
            $updated_at = (array)$updated_at;
            $created_at = (array)$created_at;

            $data[] = [
                'name'           => $faker->name,
                'email'          => $faker->unique()->safeEmail,
                'password'       => $password,
                'rememberToken' => Str::random(10),
                'create_time'    => $created_at['date'],
                'update_time'    => $updated_at['date'],
            ];
        }

        $this->table('users')->insert($data)->save();
    }
}