<?php

use Illuminate\Database\Seeder;

class CompactDiscTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //App\CompactDisc::delete();
        (new Faker\Generator)->seed(100);
        factory(App\CompactDisc::class, 30)->create();
    }
}
