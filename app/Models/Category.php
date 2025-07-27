<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    use HasFactory;

    protected $table = 'categories'; // ako ne navedemo, po nazivu klase trazice sam tabelu
    protected $fillable = [
        'name',
        'description',
        'priority'
    ];

    
    public static function getUncategorizedId() {
        $lowestPriority = Category::query()
                ->max('priority');
        $uncategorizedId = Category::query()
                ->where('priority',$lowestPriority)
                ->pluck('id')
                ->first();
        
        return $uncategorizedId;
    }

    // 2. relacije
    // Eloquent ORM - Relacije:
    public function posts() {
        return $this->hasMany(
                        Post::class,
                        'category_id', //fk, kako se zove u tabeli: posts
                        'id'  // local, kljuc u tabeli categories
        );
    }

    // 3. POMOCNE FUNKCIJE
//    //
//    public function isOnIndexPage(){
//        return $this->important == 1 ? true : false;
//    }
//    
//    
//    //
//    public function getPhotoUrl(){
//       // return url('/themes/front/img/product-img/onsale-1.png');
//    }
//    
//    public function getPhoto2Url(){
//      //  return url('/themes/front/img/product-img/best-1.png');
//    }
//    
    // da nam kategorija vrati svoj front-url
    public function getFrontUrl() {
        return route('front.posts.category', [
            'category' => $this->id,
            'seoSlug' => \Str::slug($this->name),
        ]);
    }

}
