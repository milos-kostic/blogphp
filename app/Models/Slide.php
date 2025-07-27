<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model {

    use HasFactory;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    // 1. REDEFINISANI ATRIBUTI
    protected $table = 'slides'; // ako ne navedemo, po nazivu klase trazice sam tabelu
    protected $fillable = [
        'user_id', // 'category_id',
        'name',
        // 'priority',
        'button_name',
        'button_url',
        'status',
        'index_page',
    ];

//
//    // 2. RELACIJE
//    // 
//    // Eloquent ORM - Relacije
//    // 2.1 RELACIJA KA KATEGORIJI:
//    public function category(){
//         return $this->belongsTo( //dete - roditelj veza
//                 Category::class,
//                 'category_id',
//                 'id'
//                 );
//    }
    // 2.2 RELACIJA KA KORISNIKU: 1-User > N-Postova
    public function user() {
        return $this->belongsTo(
                        User::class,
                        'user_id', // moze i bez
                        'id'
        );
    }

//    // 2.3 RELACIJA KA KOMENTARIMA: 1-Post > N-Comments:
//    public function comments(){
//        return $this->hasMany(Comment::class, 'post_id'); // 'post_id' - je naziv prenesenog kljuca
//    }
//    
//    // 2.4 RELACIJA KA VEZNOJ MEDJU-TABELI ZA TAGOVE: VISE-NA-VISE:    
//    //  u modelu Post
//    public function tags(){
//          return $this->belongsToMany(                
//                Tag::class,
//                'post_tag', // Naziv vezne tabele
//                  // id kolone mogu da se izostave
//                'post_id',
//                'tag_id'                                
//                );
//    }      
//    
//    
//    
//    //  QUERY SCOPES - makro za uslove koji se ponavljaju, koji se cesto koriste:
//    public function scopeLatestPosts($queryBuider){ // naziv pocinje sa 'scope'
//        $queryBuider                            // upotreba: ...->LatestPosts()...
//                ->where('index_page',1)
//                ->orderBy('created_at','desc')
//                ;
//    }
//    
    // 3. POMOCNE FUNKCIJE       
    //
//    public function isEnabled(){
//        return $this->enabled == 1 ? true : false;
//    }    
//    
//    public function getPhotoUrl(){
//        // return url('/themes/front/img/featured-pic-1.jpeg');
//        return $this->photo;
//    }    
//   

    /**
     * 
     * @return boolean
     */
    public function isOnIndexPage() {
        return $this->index_page == 1 ? true : false;
    }

    //
    public function getPhoto1Url() {
        if (!empty($this->photo)) {
            // return url($this->photo);
            return url('/storage/slides/' . $this->photo);
        }
        // return '/themes/front/img/default-user-image-2.jpg'; // ako korisnik nema sliku u bazi, defaultna slika
        return url('/themes/front/img/default-img/default-slide.jpg'); // ako korisnik nema sliku u bazi, defaultna slika
    }

    public function getPhoto2Url() {
        if (!empty($this->photo2)) {     //  dd('/storage/posts/' . $this->photo2,'/storage/posts/' . $this->photo );      
            // return url($this->photo);
            return url('/storage/posts/' . $this->photo2);
        }
        // return '/themes/front/img/default-user-image-2.jpg'; // ako korisnik nema sliku u bazi, defaultna slika
        return url('/themes/front/img/default-img/default-slide.jpg'); // ako korisnik nema sliku u bazi, defaultna slika
    }

    public function getPhotoUrl($photoFieldName) {
        switch ($photoFieldName) {
            case 'photo':
                return $this->getPhoto1Url();
            case 'photo2':
                return $this->getPhoto2Url();
            default:
        }
        return url('/themes/front/img/default-img/default-image-1.jpg');
    }

    //
    public function getPhoto1ThumbUrl() {
        if (!empty($this->photo)) {
            return url('/storage/slides/thumbs/' . $this->photo);
        }
        return url('/themes/front/img/default-img/default-thumb-120x100.jpg');
    }

//  
//    public function getPhoto2ThumbUrl(){
//        if(!empty($this->photo2)){
//             return  url('/storage/posts/thumbs/' . $this->photo2); 
//        }
//        return  url('/themes/front/img/default-img/tes-1.png'); 
//    }
//    
    public function deletePhoto1() {
        if (!$this->photo) {
            return $this;
        }

        // brisemo osnovnu sliku
        $photoFilePath = public_path('/storage/slides/' . $this->photo);

        if (!is_file($photoFilePath)) { // ne postoji fajl na disku, u bazi postoji naziv fajla
            return $this;
        }
        unlink($photoFilePath); // brise fizicki
        // brisemo i thumb verziju
        $photoThumbPath = public_path('/storage/slides/thumbs/' . $this->photo);
        if (!is_file($photoThumbPath)) { // slika ne postoji na disku
            return $this;
        }
        unlink($photoThumbPath); // ako postoji na disku


        return $this;
    }

//    
//    public function deletePhoto2(){
//        if(!$this->photo2){
//            return $this;
//        }
//        
//        $photoFilePath = public_path('/storage/posts/'.$this->photo2);
//        
//        if(!is_file($photoFilePath)){ // ne postoji fajl na disku, u bazi postoji naziv fajla
//            return $this;
//        }
//        
//        unlink($photoFilePath); // brise fizicki
//        // brisemo i thumb verziju
//        $photoThumbPath = public_path('/storage/posts/thumbs/'.$this->photo2);
//        if(!is_file($photoThumbPath)){ // slika ne postoji na disku
//            return $this;
//        }
//        unlink($photoThumbPath); // ako postoji na disku
//        
//        
//        return $this;
//    }
//    
    public function deletePhotos() {
        $this->deletePhoto1();
        //     $this->deletePhoto2();

        return $this; // da moze dalje da se vezu
    }

    public function deletePhoto($photoFieldName) {
        switch ($photoFieldName) {
            case 'photo':
                $this->deletePhoto1();
                break;
            case 'photo2':
                $this->deletePhoto2();
                break;
        }
        return $this; // da moze dalje da se vezu
    }

//
//    // da nam slajd vrati svoj front-url
//    public function getFrontUrl(){
//        return route('front.slides.single', [
//            'slide'=>$this->id,
//            'seoSlug'=>\Str::slug($this->name),
//        ]);
//    }
//    

    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

}
