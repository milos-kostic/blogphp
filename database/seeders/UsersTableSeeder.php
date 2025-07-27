<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('users')->truncate();
        
        $faker = \Faker\Factory::create();
        
        //
        \DB::table('users')->insert([
            'name'=>'Milos Kostic',
            'email'=>'milos-kostic@mail.ru',
            'password'=> \Hash::make('cubesphp'), //  bcrypt('cubesphp'), 
          //  'photo'=> '/themes/front/img/default-user-image-1.jpg', 
            'website'=>'www.cubes.rs',
            'phone'=>'063010122',
        //    'status'=>0, // if can login as admin
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),            
        ]);
        
        \DB::table('users')->insert([
            'name'=>$faker->name,  
            'email'=>$faker->email, 
            'password'=>\Hash::make('cubesphp'),  
         //   'status'=>0,
            'website'=>'www.cubes.rs',
            'phone'=>$faker->phoneNumber,   
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),            
        ]);
        
        \DB::table('users')->insert([
            'name'=>$faker->name, 
            'email'=>$faker->email,  
            'password'=>\Hash::make('cubesphp'),  
         //   'photo'=>'/themes/front/img/avatar-2.jpg/',
            'website'=>'www.cubes.rs',
            'phone'=>$faker->phoneNumber,  
        //    'status'=>0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),            
        ]);
        
        \DB::table('users')->insert([
            'name'=>$faker->name,  
            'email'=>$faker->email,  
            'password'=>\Hash::make('cubesphp'),  
         //   'photo'=>'/themes/front/img/avatar-2.jpg/',
            'website'=>'www.cubes.rs',
            'phone'=>$faker->phoneNumber, 
        //    'status'=>0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),            
        ]);
        
        \DB::table('users')->insert([
            'name'=>$faker->name, 
            'email'=>$faker->email,  
            'password'=>\Hash::make('cubesphp'),  
         //   'photo'=>'/themes/front/img/avatar-2.jpg/',
            'website'=>'www.cubes.rs',
            'phone'=>$faker->phoneNumber,  
        //    'status'=>0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),            
        ]);
    }
}
