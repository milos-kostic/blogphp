<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    use HasFactory;

    //
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    //
    protected $table = 'comments';
    protected $fillable = [
        'post_id',
        'user_id', // ulogovan
        'user_name', // 
        'user_email',
        'body',
        'status',
            //
            // $table->string('sender_name');  // ?
    ];

    // Relacije
    // 1. u Models\Post.php
    // 2:
    public function user() {   
        return $this->belongsTo(User::class, 'user_id');  
    }
    public function post() {
        return $this->belongsTo(Post::class, 'post_id');  
    }
    public function getUserName() { // moze biti ulogovan, u tabeli users, i neulogovan da nije u bazi         
        if($this->user_name) { // komentar neulogovanog
            return $this->user_name; 
        }
        return $this->user->name; // ulogovan, u bazi 
    }
    public function getUserPhoto() { // moze biti ulogovan, u tabeli users, i neulogovan da nije u bazi         
        if($this->user_name) { // komentar neulogovanog
            return url('/themes/admin/dist/img/default-user.png');
        }
        return $this->user->getPhotoUrl(); // ulogovan, u bazi 
    }

    // da nam tag vrati svoj front-url
    public function getFrontUrl() {
        return route('front.posts.single', [
            'post' => $this->post->id,
            'seoSlug' => \Str::slug($this->body),
        ]);
    }

    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

}
