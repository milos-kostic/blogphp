<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Comments\Comment;
// use App\Comments\Comments;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Comments\CommentsClass;

// use App\Comments\CommentClass;


class CommentsController extends Controller {

    public function index(Request $request) {
 
        
        $firstFiveCategories = Category::query() 
                ->orderBy('priority') 
                ->withCount(['posts'])  
                ->limit(5)
                ->get();
        
        $lastThreePosts = Post::query()
                ->where('status', 1) 
                ->orderBy('id', 'desc') 
                ->limit(3) 
                ->get();
    
        $allPostsByDate = Post::query()
                ->where('status', 1)
                ->where('index_page', 1)
                ->orderBy('created_at', 'DESC') 
                ->paginate(12);

        return view('front.comments.index', [
     
            'firstFiveCategories' => $firstFiveCategories,
            //
            'lastThreePosts' => $lastThreePosts,
         //   'allPostsByDate' => $allPostsByDate,
        ]);
    }

    // partial za tabelarni prikaz - NE BI TREBALO
//    public function table(Request $request) {
//        $comments = Comments::getCommentsFromSession();
//        return view('front.comments.partials.table', [
//            'comments' => $comments,
//        ]);
//    }
 
//    public function commentsByPost(Request $request) {
//        //  $comments = Comments::getCommentsFromSession();
//        return view('front.comments.commentsByPost', [
//                // 'comments' => $comments,
//        ]);
//    }

    // VRACA SAMO PARTIAL KOJI SMO IZVUKLI - comments.blade
    public function content(Request $request) { 
        // DOHVATA SPISAK KOMENTARA I CEO SPISAK PRIKAZUJE NA STRANICI posts/single.blade AJAX-om
        $formData = $request->validate([// poslati ajaxom
            'post_id' => ['required', 'numeric', 'exists:posts,id'], // 'required'
        ]);
        
        $comments = Comment::query()
                ->where('status', 1)
                ->where('post_id', $formData['post_id'])
                ->orderBy('created_at', 'desc')
                ->get();

        //  dd($comments); // radi 
        return view('front.comments.content', [
            'comments' => $comments, 
                //  'post' => $post, // moze samo post - performanse? broj upita?  
        ]);
    }

    public function add(Request $request) { // AJAX RUTA TREBA DA DODA KOMENTAR U BAZU I DA OSTANE STR
        $formData = $request->validate([ // poslati ajaxom 
            'post_id' => ['required', 'numeric', 'exists:posts,id'], // 'required'            
            'body' => ['required', 'string'], // max... // required 
//            // nullable:
//            'user_id' => ['nullable', 'numeric'], // ulogovan
            'user_name' => ['nullable', 'string', 'max:255'], // 
            'user_email' => ['nullable', 'email', 'max:255'], //            
                //  'status' => ['nullable','numeric','in:0,1'], //             
        ]);

        //  dd($formData); // radi
        
        if (!$formData['user_name'] || !$formData['user_email'] || !$formData['body']) {
            return response()->json([ // vracamo objekat koji moze da procita js - json JS OBJECT NOTATION, js- objekat koji moze gotov da se koristi
                        'system_message' => 'Enter valid name, e-mail and comment',
            ]);
        }

 

        $comment = new Comment();
//        $comment->post_id = 1; // $formData->post_id;
//        $comment->body = "AJAX AJAX AJAX AJAX AJAX AJAX AJAX AJAX AJAX AJAX AJAX ";
//        $comment->status=1;
        $comment->fill($formData);
        //     dd($comment);  // radi
        $comment->save();

        return response()->json([// vracamo objekat koji moze da procita js - json JS OBJECT NOTATION, js- objekat koji moze gotov da se koristi
                    'system_message' => 'Comment has been added',
        ]);
    }
 


//    public function comments(Comment $comments) {
// 
//        return view('front.posts.comments', [
////            'comments' => $comments,
////            'relatedPosts' => $relatedPosts,
////            'allPostsByDate' => $allPostsByDate,
////            'lastThreePosts' => $lastThreePosts,
////            'firstFiveCategories' => $firstFiveCategories,
////            'tags' => $tags,
//        ]);
//    }

    public function details(Request $request) {
 
        $firstFiveCategories = Category::query()
                // ->orderBy('name') // samo po abecednom
                ->orderBy('priority') // 
                ->withCount(['posts']) // daje svojstvo: 'posts_count' 
                ->limit(5)
                ->get();
        
        $lastThreePosts = Post::query()
                ->where('status', 1)
                // ->where('index_page',1) // important
                ->orderBy('created_at', 'DESC') 
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->get();
//        
        $allPostsByDate = Post::query()
                ->where('status', 1)
                ->where('index_page', 1)
                ->orderBy('created_at', 'DESC') 
                ->paginate(12);


        return view('front.comments.details', [
            'firstFiveCategories' => $firstFiveCategories,
            'lastThreePosts' => $lastThreePosts,
            'allPostsByDate' => $allPostsByDate,
        ]);
    }

}
