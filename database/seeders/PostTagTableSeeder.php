<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('post_tag')->truncate();
        
        // Fk: 
        // VADI SIFRE IZ OBA SIFARNIKA:
        $postIds = \DB::table('posts')->get()->pluck('id');
        $tagIds = \DB::table('tags')->get()->pluck('id');
        
        foreach($postIds as $postId){
            
                    $randomTagIds =  $tagIds->random(3); 
            foreach($randomTagIds as $tagId){
                \DB::table('post_tag')->insert([
                    'post_id'=>$postId,
                    'tag_id'=>$tagId,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                ]);
            }
        }
         
    }
}
