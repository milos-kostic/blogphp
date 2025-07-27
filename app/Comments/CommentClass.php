<?php

namespace App\Comments;

use App\Models\Post;
use App\Models\Comment;

class CommentClass {
    
    /**
     *
     * @var \App\Models\Comment 
     */
    // protected $post;
    protected $comment;
    
    /**
     * @var int 
     */
//    protected $count= 1;
    
    
    public function __construct(Comment $comment){ // Model/Comment // , Post $post) {        
//        $this->setPost($post);        
//        $this->setCount($count);
        $this->setComment($comment); // Model 
    }

        
    /**
     * @return \App\Models\Comment
     */
    public function getComment() {
       return $this->comment;
    }
    
    /**
     * @return \App\Models\Product
     */
    public function getPost() {
       // return $this->post;
    }

//    public function getCount() {
//        return $this->count;
//    }

    public function setPost(Post $post) {
      //  $this->post = $post;
        return $this;
    }
    
    public function setComment(Comment $comment) {
        $this->comment = $comment;
        return $this;
    }

//    public function setCount($count) {
//        if ($count < 1) {
//            throw new \InvalidArgumentException('Count must be >= 1');
//        }
//        $this->count = $count;
//        return $this;
//    }
    
//    public function increaseCount($count)
//    {
//        $this->count += $count;
//    }
    
//    public function getSubtotal()
//    {
//        return $this->getQuantity() * $this->getProduct()->price;
//    }
    
}
