<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;

class PostsController extends Controller {

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

    // By AUTHOR
    public function user(Request $request, User $user, $seoSlug = null) {
        //        dd($seoSlug);
        if ($seoSlug != \Str::slug($user->name)) {
            //          return redirect()->away($tag->getFrontUrl());
        }

        $tags = Tag::query()
                ->withCount(['posts'])
                ->orderBy('posts_count', 'desc')
                ->get();

        $firstFiveCategories = Category::query()
                ->orderBy('priority')
                ->withCount(['posts'])
                ->limit(5)
                ->get();

        /*
         * POSTS
         */
        $lastThreePosts = Post::query()
                ->where('status', 1)
                ->orderBy('id', 'desc')
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



        $relatedPosts = $user->posts()
                //  ->where('id','=',$post->user_id)  
                ->latest()
                ->paginate(12);




        return view('front.posts.author', [
            'tags' => $tags,
            'user' => $user,
            'firstFiveCategories' => $firstFiveCategories,
            //
            'relatedPosts' => $relatedPosts,
            'lastThreePosts' => $lastThreePosts,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
    }

    public function search(Request $request) {

        $formData = $request->validate([
            'search' => ['required', 'string'],
        ]);

        // Get the search value from the request
        $search = $request->input('search');
//      dd($search); // radi
        // Search in the title and body columns from the posts table
        $posts = Post::query()
                ->where('status', 1)
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('body', 'LIKE', "%{$search}%")
                // ->get();
                ->paginate(12);
 

        /*
         * POSTS
         */
        $lastThreePosts = Post::query()
                ->where('status', 1) 
                ->orderBy('id', 'desc') 
                ->limit(3)  
                ->get();

        $lastThreePostsMostVisitedLastMonth = Post::query()  
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                ->orderBy('views', 'DESC')
                ->orderBy('id','desc')
                // ->orderBy('created_at', 'DESC') 
                ->limit(3) 
                ->get();



        //
        $firstFiveCategories = Category::query() 
                ->orderBy('priority') 
                ->withCount(['posts'])  
                ->limit(5)
                ->get();
 
        $tags = Tag::query()
                ->withCount(['posts'])
                ->orderBy('posts_count', 'desc')
                ->get();

        $users = User::query()
                ->orderBy('name')
                ->withCount(['posts'])
                ->get();

 
 
        return view('front.posts.search', [
            'tags' => $tags,
            'search' => $search,
            //
            'posts' => $posts,
            //     'user' => $user,
            //     'relatedPosts' => $relatedPosts,
            'lastThreePosts' => $lastThreePosts,
            'firstFiveCategories' => $firstFiveCategories,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
    }

     
}
