<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class IndexController extends Controller {

    public function index(Request $request) {


        $slides = Slide::query()
                ->where('status', 1)
                ->orderBy('priority')
                ->get();

        $firstFiveCategories = Category::query()
                ->orderBy('priority') 
                ->withCount(['posts']) // daje svojstvo: 'posts_count'
                ->limit(5)
                ->get();


        /*
         * POSTS 
         */
        $last12Posts = Post::query()
                ->where('index_page', 1)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                // ->orderBy('created_at', 'desc')
                // ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
                // ->newPosts() // QUERY SCOPE, DEF. U C: Posts
                ->limit(12)
                ->get();

        $lastThreePosts = Post::query()
                ->where('status', 1)
                // ->where('index_page', 1)
                ->orderBy('id', 'desc')
                // ->orderBy('created_at', 'DESC') 
                // ->newPosts() // QUERY SCOPE, DEF. U C: Posts
                ->limit(3)
                ->get();

        $lastThreePostsMostVisitedLastMonth = Post::query() // 3 NAJPOSECENIJA POSTA POSLEDNJEG MESECA
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                ->where('index_page', 1)
                ->where('status', 1)
                ->orderBy('views', 'desc')
                ->orderBy('id', 'desc')
                // ->orderBy('created_at', 'DESC')  
                ->limit(3)
                ->get();
        // dd($lastThreePosts);

        $lastThreeImportantPosts = Post::query()
                        ->where( 'index_page', 1) // important
                        ->where( 'status', 1)
                        ->orderBy( 'id', 'DESC')
                        //->orderBy( 'created_at', 'DESC')                                
                        ->get();
        // dd($lastThreeImportantPosts);
        
        
//        $allPostsByDate = Post::query()
//                // ->where('index_page',1)
//                ->where('status', 1)
//                ->orderBy('created_at', 'DESC')
//                // ->where('created_at','>=',date('Y-m-d',strtotime('-1 month'))) 
//                // ->limit(3) // moze take(10)
//                // ->with(['user'])
//                ->paginate(12);
        // upit na kolekciju?        
        // dd($newTest = $last12Posts->where(['id', 1]));
        // dd($last12Posts->intersect(Post::orderBy('id', 'asc')->limit(5)->get())); // ?
        // \DB::select('SELECT * FROM posts WHERE ...'); // your complex query
        // \DB::select('SELECT * FROM posts WHERE id = ?', [2])




        return view( 'front.index.index', [
            'slides' => $slides,
            'firstFiveCategories' => $firstFiveCategories,
            //
            'last12Posts' => $last12Posts,
            'lastThreePosts' => $lastThreePosts,
            'lastThreeImportantPosts' => $lastThreeImportantPosts,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
        }

}
