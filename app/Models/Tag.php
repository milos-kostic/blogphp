<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Tag extends Model
{
    use HasFactory;
    
    protected $table='tags';
    
    // 
    protected  $fillable = [ // navedi sve kolone koje zelis da popunis 
        'name',                 // ne navodis polja koja se automatski popunjavaju, id i sl
    ];
    


    // 1. RELACIJA N.posts - N.tags
    //          belongsToMany()
    public function posts(){  // KORISTI SE KAO SVOJSTVO: $tag->posts
        return $this->belongsToMany(
                Post::class,
                'post_tag', // Naziv VEZNE TABELE. OBAVEZNO NAVESTI
                //
                   // AKO I NE NAVEDES NAZIVE KOLONA KLJUCEVA LAR CE POHVATATI VEROVATNO. PISEMO ZA SVAKI SLUCAJ
                'tag_id', // naziv Stranog pivot kljuca, kako se zove id Taga u veznoj tabeli
                'post_id', // Vezni pivot kljuc, kako se zove id Posta u vezonj tabeli
                );
    }
    
    
     // da nam tag vrati svoj front-url
    public function getFrontUrl(){   
        return route('front.posts.tag', [
            'tag'=>$this->id,
            'seoSlug'=>\Str::slug($this->name),
        ]);
    }
 
    
    
}
