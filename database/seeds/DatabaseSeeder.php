<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CompactDiscTableSeeder::class);
        $this->call(UserRentCompactDiscSeeder::class);
        $this->call(UserPayRentSeeder::class);
    }
}
