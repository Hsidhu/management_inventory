<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Harry', 
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);
    }
}
