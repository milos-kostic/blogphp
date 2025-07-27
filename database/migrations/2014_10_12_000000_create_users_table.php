<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
             
            $table->tinyInteger('status')->default(1); // ->after('id');
            $table->string('photo')->nullable(); // ->after('status');
            $table->string('name'); // ogranici
            $table->string('phone')->nullable(); // ->after('name');
            $table->string('email'); //->unique(); 
            $table->timestamp('email_verified_at')->nullable();
            
            $table->string('website')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
