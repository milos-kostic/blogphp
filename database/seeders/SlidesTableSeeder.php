<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('slides')->truncate();
       
        // FK:
        // 1. user_id-jevi:
        $userIds = \DB::table('users')->get()->pluck('id'); // kolekcija->pluck('id');  
        //  
        //
        $faker = \Faker\Factory::create();
        
        /************************************************
        // php artisan db:seed --class=SlidesTableSeeder
         * 
         */
        
        for ($i=1; $i<=9; $i++){          
            \DB::table('slides')->insert([
                'user_id'=> $userIds->random(),  
                'priority'=>$i,
                'name'=> \Str::limit($faker->name .' ' .$faker->address.' '.$faker->company,50), // 'Slide ' . $i . ' '. $faker->text(20),  
            //    'photo'=>'featured-pic-' . $i . '.jpeg',  // 
                'button_name'=> $faker->realText(25), // . ' ' . $faker->city(),  
                'button_url'=>'http://cubes.edu.rs',  
            //    'status'=>1, // default(1), // rand(100,999)%2,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
    }
}
