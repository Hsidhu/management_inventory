<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Seeder\ProductSeeder;

//php artisan db:seed --class=DatabaseSeeder
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userOne = User::create([
            'name' => 'Test user', 
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);

        $userTwo = User::create([
            'name' => 'Harry', 
            'email' => 'firstwish13@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $userThree = User::create([
            'name' => 'Preet', 
            'email' => 'drpreetkaur87@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $this->call(ProductSeeder::class);
    }
}
