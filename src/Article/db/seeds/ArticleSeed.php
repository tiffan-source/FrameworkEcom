<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class ArticleSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $faker = Factory::create();
        $datas = [];

        for ($i=0; $i < 25; $i++) { 
            $datas[] = [
                'name' => $faker->name(),
                'description' => $faker->text(),
                'quantity' => $faker->randomDigit(),
                'categorie_id' => rand(1, 5)
            ];
        }
        $this->table('articles')
        ->insert($datas)
        ->save();
    }
}
