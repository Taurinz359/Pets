<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Factory::create();
        $data = [];
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'name' => $faker->realText(10),
                'content' => $faker->realText(),
                'posted' => $faker->boolean()
            ];
        }
        $this->table('posts')->insert($data)->saveData();
    }
}