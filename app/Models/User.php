<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
// use Laravel\Jetstream\;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use Notifiable;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'phone'
    ];
    
    
    
    // 2. relacije
    // Eloquent ORM - Relacije:
    public function posts() {
        return $this->hasMany(
                        Post::class,
                        'user_id', //fk, kako se zove u tabeli: posts
                        'id'  // local, kljuc u tabeli categories
        );
    }
    
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }
    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

    public function getPhotoUrl() {
        if ($this->photo) {
            return url('/storage/users/' . $this->photo);
        }
        // return url('/themes/admin/dist/img/default-150x150.png');
        // return url('/themes/admin/dist/img/default-thumb-100x100.jpg');
        return url('/themes/admin/dist/img/default-user.png');
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this;
        }

        $photoPath = public_path('/storage/users/' . $this->photo);

        if (is_file($photoPath)) {
            unlink($photoPath);
        }

        return $this;
    }

    
    // da nam User vrati svoj front-url
    public function getFrontUrl(){   
        return route('front.posts.author', [
            'user'=>$this->id,
            'seoSlug'=>\Str::slug($this->name),
        ]);
    }
 
    

}
