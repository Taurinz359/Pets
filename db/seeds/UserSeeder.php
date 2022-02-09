<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 5; $i++) {
            $data[]=[
                'email'=> $faker->email,
                'password'=> sha1($faker->password)
            ];
        }
        $data [] = [
            'email' => 'admin@area.ru',
            'password' => '$2y$10$Xyt7o0Yj5l5bVUZGAG9dFOxTysAkWj'
        ];
        $this->table('users')->insert($data)->saveData();
    }
}
