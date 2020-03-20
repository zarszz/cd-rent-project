<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        $password = app('hash')->make('password');
        $ucokData = [
            'email' => 'ucok@email.com',
            'first_name' => 'ucok',
            'last_name' => 'lorenzo',
            'username' => 'ucok',
            'password' => $password,
            'address' => 'ciendog'
        ];
        \App\User::create($ucokData);
    }
}
