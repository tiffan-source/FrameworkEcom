<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class CategorieData extends AbstractSeed
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

        for ($i=0; $i < 5; $i++) { 
            $datas[] = [
                'name' => $faker->name(),
            ];
        }
        $this->table('categories')
        ->insert($datas)
        ->save();
    }
}
