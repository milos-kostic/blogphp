<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        \DB::table('comments')->truncate();

        // FK:
        // post_id-jevi:
        $postIds = \DB::table('posts')->get()->pluck('id'); // kolekcija->pluck('id');    
        $userIds = \DB::table('users')->get()->pluck('id'); // kolekcija->pluck('id');    
//      iz njih random upis stranog kljuca 

        $faker = \Faker\Factory::create();



        // za ulogovane 
        for ($i = 1; $i <= 300; $i++) {
            \DB::table('comments')->insert([
                'body' => $faker->text(50),
                'post_id' => $postIds->random(),
                
                'user_id' => ($i % 2) ? $userIds->random() : null,  // za ulogovane
                'user_name' => ($i % 2) ? null : $faker->name, // za neulogovane
                'user_email' => ($i % 2) ? null : $faker->email,
                
                'status' => rand(0, 1), //  ima default(1) u migraciji
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

}
