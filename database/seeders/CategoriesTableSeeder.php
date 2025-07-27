<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \DB::table('categories')->truncate();
        //          
        $faker = \Faker\Factory::create();
        
         
        for ($i=1; $i<=5; $i++){          
            \DB::table('categories')->insert([
                'priority'=>$i,
                'name'=>$faker->city, 
                'description'=>$faker->realText(),
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
        
                   
        // Uncategorized: id=0
        $lowestPriority =  \DB::table('categories')->max('priority');
        \DB::table('categories')->insert([            
                'priority'=>$lowestPriority + 1,
                'name'=>"Uncategorized", 
                // 'description'=>$faker->realText(), // nullable()
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
    }
}
