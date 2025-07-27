<?php

namespace App\Comments;
use App\Models\Post;
use App\Models\Comment;
// use App\Comments\CommentClass;

class CommentsClass  {
    
    /**
     * @var CommentClass[] 
     */
    protected $comments = [];
    
    
     
    /**
     * @return \App\Comments\CommentsClass
     */
    public static function getCommentsFromSession(){
        $comments = session()->get('comments');
        if (!($comments instanceof CommentsClass)) {            
            $comments = new CommentsClass();            
            session()->put('comments', $comments);
        }        
        return $comments;
    }
    
    
    
    public function add(Comment $comment) // Model/Comment
    {
        //        foreach ($this->comments as $comment) {
        //            
        //            if ($product->id == $item->getPost()->id) {
        //                
        //                $item->increaseCount($count);
        //                
        //                return $this;
        //            }
        //        }     
        
        $newComment = new CommentClass($comment); // , $count);        
        $this->comments[] = $newComment;
        
        return $this;
    }
    
//	
//	public function changeCount(Comment $comment) // , $count)
//    {
//        foreach ($this->items as $item) {//            
//            if ($comment->id == $item->getPost()->id) {//                
//                $item->setCount($count);                
//                return $this;
//            }
//        }//        
//        return $this;
//    }
//    
    /**
     * @param int $productId
     * @return ShoppingCart
     */
//    public function removeComment($commentId)
//    {
////        foreach ($this->items as $key => $item) {
////            
////            if ($item->getPost()->id == $productId) {
////                
////                unset($this->items[$key]);
////                
////                return $this;
////            }
////        }
////        
//        return $this;
//    }
//    
    
    public function count()
    {
        return count($this->comments);
    }
    
     
    
    
    /**
     * @return CommentClass[]
     */
    public function getComments() {
        return $this->comments;
    }
    
    
    
    
    
//    public function getTotal()
//    {
//        $total = 0;
//        
//        foreach ($this->items as $item) {
//            $total += $item->getSubtotal();
//        }
//        
//        return $total;
//    }
//	
//	public function emptyComments()
//	{
//		$this->items = [];
//		
//		return $this;
//	}
}
