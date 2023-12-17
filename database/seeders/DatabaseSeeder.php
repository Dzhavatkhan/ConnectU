<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Friend;
use App\Models\Like;
use App\Models\Posts;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Role::factory()->create([
            'name' => 'user',
        ]);
        \App\Models\User::factory(10)->create();
        \App\Models\Like::factory(10)->create();
        \App\Models\Friend::factory(10)->create();
        \App\Models\Posts::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\User_category::factory(10)->create();
        \App\Models\Chat::factory(10)->create();
        \App\Models\Message::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
