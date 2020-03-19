<?php

use Illuminate\Database\Seeder;

class UserRentCompactDiscSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // App\UserRentCompactDisc::delete();
        (new Faker\Generator)->seed(100);
        factory(App\UserRentCompactDisc::class, 30)->create();
    }
}
