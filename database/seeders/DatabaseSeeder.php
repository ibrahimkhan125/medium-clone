<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str as STR;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $name = 'Lord Ibrahim';
        User::create([
            'name' => $name,
            'username' => STR::slug($name, '_'),
            'email' => 'ibrahim@example.com',
            'password' => bcrypt('12345678'), // password
            ]);
        $categories = [
            'Technology',
            'Health',
            'Science',
            'Sports',
            'Politics',
            'Entertainment'     
        ];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
        // $this->call([
        //     PostSeeder::class
        // ]);
    }
}
