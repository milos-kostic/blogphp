<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('posts')->truncate(); 
        
        // FK:
        // 1. user_id-jevi:
        $userIds = \DB::table('users')->get()->pluck('id'); // kolekcija->pluck('id');    
        // 2. category_id-jevi:
        $categoryIds = \DB::table('categories')->get()->pluck('id');
          
      //  dd($userIds, $categoryIds); 
        
        $faker = \Faker\Factory::create();
        //
        for ($i=1; $i<=250; $i++){          
            \DB::table('posts')->insert([
                
                'name'=> $faker->name . ' ' . $faker->address, // (20), // 'Post ' . $i, 
                'description'=>$faker->realText(255),
                'body'=> $faker->realText(500), // 'Description of post ' . $i, 
                
                'user_id'=> $userIds->random(),  
                'category_id'=> $categoryIds->random(),  // moze bez kategorije, null 
                
           //     'photo'=>'/themes/front/img/featured-pic-' .$i . '.jpeg',
           //     'photo2'=>'/themes/front/img/small-thumbnail-' . $i . '.jpg', // /themes/front/img/thumb1.jpg', // 256x256px
                
                'index_page'=>rand(100,999)%2,  
                // 'status'=>1, // default at migration
                // 'views'=>0, // default(0)
                
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
    }
}
