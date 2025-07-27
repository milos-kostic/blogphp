<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            
            $table->string('description',500)->nullable(); //500            
            $table->longText('body')->comment('Post main content'); // limit ~500 words?
             
            $table->bigInteger('category_id')->nullable(); // default(-1); // moze bez kategorije            
            $table->bigInteger('user_id')->nullable(); // ?
            
            $table->string('photo',255)->nullable(); // ~ 800x600
            $table->string('photo2',255)->nullable(); // ~ 800x600
            $table->boolean('index_page')->default(1)->comment('Important post can be on Index Page');
            $table->boolean('status')->default(1)->comment('Can not show anywhere');
            
            $table->bigInteger('views')->default(0); // views
            
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
        Schema::dropIfExists('posts');
    }
}
