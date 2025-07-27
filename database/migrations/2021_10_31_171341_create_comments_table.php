<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('body',500); // max
            $table->bigInteger('post_id'); 
            
            $table->bigInteger('user_id')->nullable(); // moze i neulogovani korisnik, tada popunjavamo:            
            $table->string('user_name')->nullable(); // i:
            $table->string('user_email')->nullable(); // 
            
            $table->boolean('status')->default(1)->comment('1-Enabled, 0-Disabled');  // Enabled se prikazuju na Front delu
  
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
        Schema::dropIfExists('comments');
    }
}
