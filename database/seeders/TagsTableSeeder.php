<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        \DB::table('tags')->truncate();
        
        $tagNames = ['BUSINESS','TECHNOLOGY','FASHION','SPORTS','ECONOMY'];
               
        foreach($tagNames as $tagName){
              \DB::table('tags')->insert([
                    'name'=> $tagName, 
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
         
    }
}
