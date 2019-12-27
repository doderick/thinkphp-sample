<?php

use app\index\model\User;
use think\migration\Seeder;

class FollowersSeeder extends Seeder
{
    public function getDependencies()
    {
        return [
            'UsersSeeder',
        ];
    }

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
        $users   = User::all();
        $user    = $users[0];
        $user_id = $user->id;

        // 取出除第一个用户的以外的所有用户的id
        $followers = $users->filter(function ($data) use ($user_id) {
            return $user_id != $data['id'];
        });
        $follower_ids = array_column($followers->toArray(), 'id');

        // 第一个用户关注除自己之外的所有用户
        $user->follow($follower_ids);

        // 除了第一个用户之外所有用户都关注第一个用户
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}