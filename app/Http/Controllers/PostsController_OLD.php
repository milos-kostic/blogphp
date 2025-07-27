<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;

class PostsController_OLD extends Controller {

    //
    public function post() {
        return view('front.posts.blog');
    }

    public function index(Request $request) {

        $formData = $request->validate([// === $searchFilters, $formData obicno za Crud
            'category_id' => ['nullable', 'array', 'exists:categories,id'], // da postoji u: OVOJ TABELI, OVOJ KOLONI           
            'user_id' => ['nullable', 'array', 'exists:users,id'],
                //          'search-term' => ['nullable'],
//            'sort_by'=>[
//                'nullable','string','in:G,W,X,Q'
//            ],
        ]);



        // RELACIJA: 1.kat-N.posts      
        $firstFiveCategories = Category::query()
                ->orderBy('priority') // USER DEFINED PRIORITY
                ->withCount(['posts']) // daje svojstvo: 'posts_count' 
                ->limit(5)
                ->get();


        // RELACIJA: 1.user-N.posts
        $users = User::query()
                ->orderBy('name')
                ->withCount(['posts'])
                ->get();


        // RELACIJA: N.posts-N.tags 
        // svi tagovi za widget:
        $tags = Tag::query()
                ->withCount(['posts'])
                ->orderBy('posts_count', 'desc')
                ->get();



        /*
         * POSTS 
         */
        $allPostsByDate = Post::query()
                ->where('status', 1)
                ->orderBy('id', 'desc')
                // ->orderBy('created_at', 'desc')  
                ->paginate(12);

        $lastThreePosts = Post::query()
                ->where('status', 1)
                ->orderBy('id', 'desc')
                // ->orderBy('created_at', 'DESC')  
                ->limit(3)
                ->get();

        $lastThreePostsMostVisitedLastMonth = Post::query() // 3 NAJPOSECENIJA POSTA POSLEDNJIH 1 MESEC
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                ->where('status', 1)
                ->orderBy('views', 'DESC')
                //  ->orderBy('id','desc')
                // ->orderBy('created_at', 'DESC')
                //    ->where('index_page','=',1) 
                ->limit(3)
                ->get();
        //     dd($allPostsByDate); 

        return view('front.posts.index', [
            'firstFiveCategories' => $firstFiveCategories,
            'users' => $users,
            'tags' => $tags,
            //
            'allPostsByDate' => $allPostsByDate,
            'lastThreePosts' => $lastThreePosts,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
                //   'formData'=>$formData,
        ]);
    }

    // single post:
    public function single(Request $request, Post $post, $seoSlug = null) {

        if ($post->status == 0) {
            return abort(404);
        }

        //        dd($seoSlug);
        if ($seoSlug != \Str::slug($post->name)) {
            return redirect()->away($post->getFrontUrl());
        }

        $prevPost = Post::where('id', '<', $post->id)->max('id');
        $nextPost = Post::where('id', '>', $post->id)->min('id');


        //  dd($post->category, $post->category->name, $post); // RELACIJA, METODA KOJA SE POZIVA KAO PROPERTY

        $tags = Tag::query()
                ->withCount(['posts'])
                // ->orderBy('name', 'ASC')
                ->orderBy('posts_count', 'desc')
                ->get();

        $firstFiveCategories = Category::query()
                // ->orderBy('name') // samo po abecednom
                ->orderBy('priority') // 
                ->withCount(['posts']) // daje svojstvo: 'posts_count' 
                ->limit(5)
                ->get();



        /*
         * POSTS
         */
        $allPostsByDate = Post::query()
                ->where('status', 1)
                ->orderBy('id', 'desc')
                // ->orderBy('created_at', 'DESC')   
                ->paginate(12);

        $relatedPosts = Post::query() // related on category
                ->where('status', 1)
                ->where('category_id', $post->category_id)
                ->where('id', '!=', $post->id) // da ne prikaze ovaj proizvod
                ->take(3)
                ->latest() // SKRACENO ID orderBy('created_at','DESC')
                ->get();


        $lastThreePosts = Post::query()
                ->where('status', 1)
                //   ->where('index_page',1) // important
                //     ->orderBy('created_at', 'DESC')
                ->orderBy('id', 'desc')
//                ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->get();


        $lastThreePostsMostVisitedLastMonth = Post::query()
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                ->where('status', 1)
                //  ->orderBy('id','desc')
                ->orderBy('views', 'DESC')
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->get();


        $updatedTimeBeforeIncrementViews = $post->updated_at; // after $post->save() it will be changed
        $post->views += 1;
        $post->save();


        //   dd($post->tags);

        return view('front.posts.single', [
            'tags' => $tags,
            'firstFiveCategories' => $firstFiveCategories,
            //
            'allPostsByDate' => $allPostsByDate,
            'post' => $post,
            'prevPost' => $prevPost,
            'nextPost' => $nextPost,
            'relatedPosts' => $relatedPosts,
            'lastThreePosts' => $lastThreePosts,
            'updatedTimeBeforeIncrementViews' => $updatedTimeBeforeIncrementViews,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
    }

    public function category(Request $request, Category $category, $seoSlug = null) {

        //     dd($category);
        if ($seoSlug != \Str::slug($category->name)) {
            return redirect()->away($category->getFrontUrl());
        }

        $tags = Tag::query()
                ->withCount(['posts'])
                // ->orderBy('name', 'ASC')
                ->orderBy('posts_count', 'desc')
                ->get();

        // KATEGORIJE:
        $categories = Category::query()
                ->orderBy('name') // samo po abecednom
                ->withCount(['posts'])
                ->get();

        $firstFiveCategories = Category::query()
                // ->orderBy('name') // samo po abecednom
                ->orderBy('priority') // 
                ->withCount(['posts']) // daje svojstvo: 'posts_count' 
                ->limit(5)
                ->get();


        /*
         * POSTS
         */
        $relatedPosts = $category->posts()
                ->where('status', 1)
                ->latest()
                ->paginate(12);

        $lastThreePosts = Post::query()
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

        $lastThreePostsMostVisitedLastMonth = Post::query() // 3 NAJPOSECENIJA POSTA POSLEDNJEG MESECA
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                ->where('status', 1)
                ->orderBy('views', 'desc')
                //  ->orderBy('id','desc')
                // ->orderBy('created_at', 'DESC') 
                ->limit(3)
                ->get();



        return view('front.posts.category', [
            'tags' => $tags,
            'category' => $category,
            'categories' => $categories,
            'firstFiveCategories' => $firstFiveCategories,
            //  'post'=>$post,          // 
            'relatedPosts' => $relatedPosts,
            'lastThreePosts' => $lastThreePosts,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
    }

    public function tag(Request $request, Tag $tag, $seoSlug = null) {

        //        dd($seoSlug);
        if ($seoSlug != \Str::slug($tag->name)) {
            //          return redirect()->away($tag->getFrontUrl());
        }

        /*
         * POSTS
         */

        $lastThreePosts = Post::query()
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                // ->orderBy('created_at', 'DESC') 
                ->limit(3)
                ->get();

        $lastThreePostsMostVisitedLastMonth = Post::query()
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                ->where('status', 1)
                ->orderBy('views', 'DESC')
                //  ->orderBy('id','desc')
                // ->orderBy('created_at', 'DESC') 
                ->limit(3)
                ->get();


        $firstFiveCategories = Category::query()
                ->orderBy('priority')
                ->withCount(['posts'])
                ->take(5)
                ->get();

        $tags = Tag::query()
                ->withCount(['posts'])
                ->orderBy('posts_count', 'desc')
                ->get();


        // vezani POSTOVI OVOG TAGA: VEZA n:n
        //   dd($tag->posts);     
        //                
        $relatedPosts = $tag->posts()
                ->where('status', 1)
                ->latest()
                ->paginate(12);



        return view('front.posts.tag', [
            'tag' => $tag,
            'tags' => $tags,
            'firstFiveCategories' => $firstFiveCategories,
            //
            'relatedPosts' => $relatedPosts,
            'lastThreePosts' => $lastThreePosts,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
    }

    // IZVLACIMO postove za punjenje tabele na index.blade - ovde, a index akcija ne - ona prikazuje praznu tabelu
//    public function commentsAjax(Request $request) {
//
//        $searchFilters = $request->validate([
//            'body' => ['nullable', 'string', 'max:255'],
////            'user_id' => ['nullable', 'numeric', 'exists:users,id'], // !
////            'category_id' => ['nullable', 'numeric'], // , 'exists:categories,id'], // moze Uncategorized
////            'index_page' => ['nullable', 'numeric', 'in:0,1'],
////            'status' => ['nullable', 'numeric', 'in:0,1'],
////            'views' => ['nullable', 'numeric'],
////            'tag_ids' => ['nullable', 'array', 'exists:tags,id'],
//        ]);
//
//
//        $query = Post::query()
//                ->with(['user', 'comments'])
//                ->join('users', 'posts.user_id', '=', 'users.id')
//                ->join('comments', 'posts.id', '=', 'comments.post_id')
//                //  ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
//                ->select([
//            // 'posts.*',
//            'comments.*',
//                // vezne:
////                        'users.name AS user_name',
//                //  'categories.name AS category_name',
//        ]);
//
//
//
//
//        // *************************************************
//        //  composer require yajra/laravel-datatables-oracle
//        // *************************************************
//        //  pa koristimo fasadu:
//        $dataTable = \DataTables::of($query);
//
//        $dataTable
////                ->addColumn('tag', function($post) { // DODAMO KOLONU // function($red_u_tabeli)
////                    return optional($post->tags->pluck('name'))->join(', '); // optional() kad radimo sa relacijama
////                })                                          // optional do poslednje fje se stavlja
////        ->addColumn('user_name', function($post){
////            return optional($post->user)->name;
////        })
////        ->addColumn('category_name', function($post) {
////            if ($post->category) {
////                return optional($post->category)->name;
////            }
////            return 'Uncategorized';
////        })
////                ->editColumn('id', function($post) { 
////                    return '#' . $post->id;     
////                })
//                ->editColumn('body', function($comment) {
//                    return '<strong>' . e($post->name) . '</strong>';
//                })
////                ->editColumn('status', function($comment) {  
////                    $status = $comment->status;
////                    if ($status) {
////                        return '<font style="color:green">Enabled</font>';
////                    } else {
////                        return '<font style="color:red">Disabled</font>';
////                    }
////                })
////                ->editColumn('created_at', function($comment) {  
////                    return e($comment->created_at);
////                })               
////                ->addColumn('comments', function($post) {  
////                    return optional($post->comments)->count();  
////                })  
////                ->editColumn('views', function($post) {  
////                    return optional($post->views); // optional() kad radimo sa relacijama
////                })  
////                ->addColumn('actions', function($post) {
////                    return view('admin.posts.partials.actions', ['post' => $post]);
////                })
//        ;
//
//
//        $dataTable->rawColumns(['body']); //, 'photo', 'actions', 'status']);
//
//
//        /* filter fja za search        * ************** */
//        // pretraga (search polje)
//        $dataTable->filter(function ($query) use ($request, $searchFilters) {
//            if (
//                    $request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])
//            ) {
//
//                $searchTerm = $request->get('search')['value'];  
//                $query->where(function($query) use($searchTerm) {   
//                    $query
//                            ->orWhere('comments.post_id', '=', $searchTerm) 
////                            ->orWhere('posts.name', 'LIKE', '%' . $searchTerm . '%') 
////                            ->orWhere('posts.description', 'LIKE', '%' . $searchTerm . '%')
////                            ->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%')
////                            ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%')
////                            ->orWhere('posts.id', '=', $searchTerm)  
//                    ;
//                });
//            }
//        }); 
//        return $dataTable->make(true);  
//    }

//    public function comments(Comment $comments) {
// 
//
//        $comments = Comment::query()
//                ->get();
//
//  
//        return view('front.posts.comment', [
//            'comments' => $comments,
//            'relatedPosts' => $relatedPosts,
//            'allPostsByDate' => $allPostsByDate,
//            'lastThreePosts' => $lastThreePosts,
//            'firstFiveCategories' => $firstFiveCategories,
//            'tags' => $tags,
//        ]);
//    }

    // By AUTHOR
    public function user(Request $request, User $user, $seoSlug = null) {
        //        dd($seoSlug);
        if ($seoSlug != \Str::slug($user->name)) {
            //          return redirect()->away($tag->getFrontUrl());
        }

        $allPostsByDate = Post::query()
                ->where('status', 1)
//                    ->where('index_page',1)
                ->orderBy('created_at', 'DESC')
//                ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->paginate(12);


        $lastThreePosts = Post::query()
                ->where('status', 1)
                //   ->where('index_page',1) // important
                ->orderBy('created_at', 'DESC')
//                ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->get();

        $lastThreePostsMostVisitedLastMonth = Post::query() // 3 NAJPOSECENIJA POSTA POSLEDNJIH 1 MESEC
//                    ->where('index_page',1)
                ->where('status', 1)
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                //  ->orderBy('id','desc')
                ->orderBy('views', 'DESC')
                // ->orderBy('created_at', 'DESC')
                //    ->where('index_page','=',1)
                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->get();



        $firstFiveCategories = Category::query()
                // ->orderBy('name') // samo po abecednom
                ->orderBy('priority') // 
                ->withCount(['posts']) // daje svojstvo: 'posts_count' 
                ->limit(5)
                ->get();



        //   $relatedPosts = User::query()
        $relatedPosts = $user->posts()
                //  ->where('id','=',$post->user_id) 
                // ->take(3)
                ->latest() // SKRACENO ID orderBy('created_at','DESC')
                //  ->get()
                ->paginate(12);


        $tags = Tag::query()
                ->withCount(['posts'])
                // ->orderBy('name', 'ASC')
                ->orderBy('posts_count', 'desc')
                ->get();



        return view('front.posts.author', [
            'user' => $user,
            'relatedPosts' => $relatedPosts,
            'allPostsByDate' => $allPostsByDate,
            'lastThreePosts' => $lastThreePosts,
            'firstFiveCategories' => $firstFiveCategories,
            'tags' => $tags,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
    }

    public function search(Request $request) {

        $formData = $request->validate([// === $searchFilters, $formData obicno za Crud
            'search' => ['required', 'string'],
        ]);

        // Get the search value from the request
        $search = $request->input('search');
// dd($search); // radi
        // Search in the title and body columns from the posts table
        $posts = Post::query()
                ->where('status', 1)
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('body', 'LIKE', "%{$search}%")
                // ->get();
                ->paginate(12);


        //     $posts->append($formData); // gubi search parametar kad promeni stranu paginacije
// 


        $allPostsByDate = Post::query()
//                    ->where('index_page',1)
                ->orderBy('created_at', 'DESC')
//                ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->paginate(12);


        $lastThreePosts = Post::query()
                ->where('status', 1)
                //   ->where('index_page',1) // important
                ->orderBy('created_at', 'DESC')
//                ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->get();

        $lastThreePostsMostVisitedLastMonth = Post::query() // 3 NAJPOSECENIJA POSTA POSLEDNJIH 1 MESEC
//                    ->where('index_page',1)
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                //  ->orderBy('id','desc')
                ->orderBy('views', 'DESC')
                // ->orderBy('created_at', 'DESC')
                //    ->where('index_page','=',1)
                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
                ->limit(3) // moze take(10)
                // ->with(['brand'])
                ->get();



        $firstFiveCategories = Category::query()
                // ->orderBy('name') // samo po abecednom
                ->orderBy('priority') // 
                ->withCount(['posts']) // daje svojstvo: 'posts_count' 
                ->limit(5)
                ->get();




        $tags = Tag::query()
                ->withCount(['posts'])
                // ->orderBy('name', 'ASC')
                ->orderBy('posts_count', 'desc')
                ->get();

        $users = User::query()
                ->orderBy('name', 'ASC')
                ->withCount(['posts']) // KAD DOHVATAS korisnike - ZA SVAKI IZBROJ KOLIKO postova IMA U TOM REDU
                ->get();


        // Return the search view with the resluts compacted
        return view('front.posts.search', [
            'posts' => $posts,
            'search' => $search,
            //     'user' => $user,
            //     'relatedPosts' => $relatedPosts,
            'allPostsByDate' => $allPostsByDate,
            'lastThreePosts' => $lastThreePosts,
            'firstFiveCategories' => $firstFiveCategories,
            'tags' => $tags,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
    }

//    
//    // AKCIJA SEARCH(): 
//    public function blogSearch(String $searchTerm = null) {
//
//
//        // VADIMO KATEGORIJE:
//        $categories = Category::query()
//                ->orderBy('name') // samo po abecednom
//                ->withCount(['posts'])
//                ->get();
//
//
//        $firstFiveCategories = Category::query()
//                // ->orderBy('name') // samo po abecednom
//                ->orderBy('priority') // 
//                ->withCount(['posts']) // daje svojstvo: 'posts_count' 
//                ->limit(5)
//                ->get();
//
//
//        $last12Posts = Post::query()
////                    ->where('index_page',1)
//                ->orderBy('created_at', 'DESC')
////                ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
//                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
//                ->limit(12) // moze take(10)
//                // ->with(['brand'])
//                ->get();
//
//        $allPostsByDate = Post::query()
////                    ->where('index_page',1)
//                ->orderBy('created_at', 'DESC')
////                ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
//                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
//                ->limit(3) // moze take(10)
//                // ->with(['brand'])
//                ->paginate(12);
//
//        $lastThreePosts = Post::query()
//                ->where('status', 1)
//                //   ->where('index_page',1) // important
//                ->orderBy('created_at', 'DESC')
////                ->where('created_at','>=',date('Y-m-d',strtotime('-1 month')))
//                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
//                ->limit(3) // moze take(10)
//                // ->with(['brand'])
//                ->get();
//
//        $lastThreePostsMostVisitedLastMonth = Post::query() // 3 NAJPOSECENIJA POSTA POSLEDNJIH 1 MESEC
////                    ->where('index_page',1)
//                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
//                //  ->orderBy('id','desc')
//                ->orderBy('views', 'DESC')
//                // ->orderBy('created_at', 'DESC')
//                //    ->where('index_page','=',1)
//                // ->newArrivals() // QUERY SCOPE, DEF. U C: Product
//                ->limit(3) // moze take(10)
//                // ->with(['brand'])
//                ->get();
//
//
//
//        //
//        $relatedPosts = Post::query()
//                //  ->where('id','=',$post->user_id) 
//                // ->take(3)
//                ->latest() // SKRACENO ID orderBy('created_at','DESC')
//                //  ->get()
//                ->paginate(12);
//
//
//        $tags = Tag::query()
//                ->withCount(['posts'])
//                // ->orderBy('name', 'ASC')
//                ->orderBy('posts_count', 'desc')
//                ->get();
//
//
//
//        return view('front.posts.blog_search', [
//            //  'post'=>$post,          // ?      
//            'posts' => $relatedPosts,
//            'categories' => $categories, // ?
//            'last12Posts' => $last12Posts,
//            'firstFiveCategories' => $firstFiveCategories,
//            'allPostsByDate' => $allPostsByDate,
//            'lastThreePosts' => $lastThreePosts,
//            'tags' => $tags,
//            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
//        ]);
//    }

}
