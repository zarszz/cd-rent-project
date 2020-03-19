<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\User::delete();
        (new Faker\Generator)->seed(100);
        factory(App\User::class, 30)->create();
    }
}
