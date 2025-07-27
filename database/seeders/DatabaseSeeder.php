<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // PAZI NA REDOSLED UVODJENJA SEEDER-A: PRVO SIFARNICI
        // 1. Sifarnici:
        $this->call(CategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class); 
        $this->call(UsersTableSeeder::class); 
        $this->call(SlidesTableSeeder::class); 
        
        // 2. Zavisne:
        $this->call(PostsTableSeeder::class); 
        $this->call(CommentsTableSeeder::class); 
        
        // 3. Vezne:
        $this->call(PostTagTableSeeder::class); 


    }
}
