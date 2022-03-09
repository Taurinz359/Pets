<?php

use App\Models\Post;
use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'UserSeeder',
        ];
    }

    public function run()
    {
        $faker = Factory::create();
        $statuses = [Post::STATUS_DRAFT, Post::STATUS_PUBLISHED];

        $users = $this->getAdapter()->fetchAll('SELECT * FROM users');

        $data = [];
        foreach ($users as $user) {
            $status = $statuses[array_rand($statuses)];

            $data[] = [
                'user_id' => $user['id'],
                'name' => $faker->realText(10),
                'content' => $faker->realText(4000),
                'status' => $status
            ];
        }
        $data[] = [
            'user_id' => 6,
            'name' => $faker->realText(10),
            'content' => $faker->realText(4000),
            'status' => 2
        ];

        $this->table('posts')->insert($data)->save();
    }
}