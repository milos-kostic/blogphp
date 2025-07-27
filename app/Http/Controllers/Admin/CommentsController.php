<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment; //
use Illuminate\Validation\Rule; //

class CommentsController extends Controller {

    //
    public function index() {
 

        $comments = Comment::query()
                ->orderBy('created_at', 'desc')
                ->get(); // dohvati sve komentare iz tabele


        return view('admin.comments.index', [
            'comments' => $comments,
                // 'systemMessage' => $systemMessage, // tu poruku prosledim na view skriptu kao parametar 
        ]);
    }

    public function add(Request $request) {

        // dd('Comments add action');
        return view('admin.comments.add', [
        ]);
    }

    public function insert(Request $request) {  
        
        $formData = $request->validate([ 
            'name' => ['required', 'string', 'max:10', 'unique:tags,name'],
        ]);


        $newTag = new Tag();
 
        // MASS ASSIGNMENT:
        $newTag->fill($formData); 
        //   dd($newTag); 
        $newTag->save();  
        // 
        session()->flash('system_message', __('New Tag has been added!'));  

        return redirect()->route('admin.tags.index');  
    }

    public function edit(Request $request, Tag $tag) {  
        // route MODEL BINDING, DA LAR AUTOMATSKI UCITA CEO OBJEKAT PO TIPU PARAMETRA, ako nema u bazi - vrati 404 stranu
        // dd('Tags insert action');
        return view('admin.tags.edit', [
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, Tag $tag) {  
        
        $formData = $request->validate([
            'name' => ['required', 'string', 'max:10', Rule::unique('tags')->ignore($tag->id),],  
        ]);

        //   dd($formData);

        $tag->fill($formData);

        $tag->save();

        session()->flash('system_message', __('Tag has been updated!'));

        return redirect()->route('admin.tags.index');
    }

    // IZVLACIMO komentare - redove za punjenje tabele na index.blade - ovde, 
    // a index akcija prikazuje praznu tabelu
    public function datatable(Request $request) {

        /*         * ******************
         * ovde javlja Ajax error ako je ostavljeno neizabrano polje user ili category
         *  resava se:
         *    na NEIZABRANU VREDNOST postavi: value="", vidi posts\index.blade
         * ****************** */
        $searchFilters = $request->validate([
            'body' => ['nullable', 'string', 'max:255'],
            'post_id' => ['nullable', 'numeric', 'exists:posts,id'],
            'status' => ['nullable', 'numeric', 'in:0,1'],
//            'views' => ['nullable', 'numeric'],
//            'tag_ids' => ['nullable', 'array', 'exists:tags,id'],
        ]);
 


        $query = Comment::query()  
                ->with(['post',]) // relacije 
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->select([
                    'comments.*',
                    // vezne:
                    'posts.name AS post_name',
                ]);


       
        // *************************************************
        //  composer require yajra/laravel-datatables-oracle
        // *************************************************
        //  pa koristimo fasadu:
        $dataTable = \DataTables::of($query);


        //// pravi tabelu za popunjavanje, upit
        ////  \Yajra\DataTables\Facades\DataTables::of($query); 
//                         // moze i bez putanje jer je fasada.
        //    dd($dataTable);
        //    dd($dataTable->make(true));


        $dataTable
//                ->addColumn('tag', function($post) { // DODAMO KOLONU // function($red_u_tabeli)
//                    return optional($post->tags->pluck('name'))->join(', '); // optional() kad radimo sa relacijama
//                })                                          // optional do poslednje fje se stavlja
                ->addColumn('post_name', function($comment) {
                    return '<strong>' . optional($comment->post)->name . '</strong>';
                })
                ->editColumn('id', function($comment) {  
                    return '#' . $comment->id;    
                })
                ->editColumn('body', function($comment) { // vezujemo: editColumn() menja postojeci red, 
                    return '<strong>' . e($comment->body) . '</strong>';     // da name bude podebljano
                })             // e() HELPER, KAO {{}}, escape, KORISTIMO UMESTO htmlspecialchars()
                ->editColumn('status', function($comment) { // vezujemo: editColumn() menja postojeci red, 
                    $status = $comment->status;
                    if ($status) {
                        return '<font style="color:green">Enabled</font>';
                    } else {
                        return '<font style="color:red">Disabled</font>';
                    }
                })
                ->editColumn('created_at', function($comment) { // vezujemo: editColumn() menja postojeci red, 
                    return e($comment->created_at);
                })
//                ->addColumn('comments', function($post) { // DODAMO KOLONU // function($red_u_tabeli)
//                    return optional($post->comments)->count(); // optional() kad radimo sa relacijama
//                })  
//                ->editColumn('views', function($post) { // DODAMO KOLONU // function($red_u_tabeli)
//                    return optional($post->views); // optional() kad radimo sa relacijama
//                })  
                ->addColumn('actions', function($comment) {
                    return view('admin.comments.partials.actions', ['comment' => $comment]);
                });


        $dataTable->rawColumns(['body', 'actions', 'status', 'post_name']); // disable escape


        /* filter fja za search        * ************** */ 
        // pretraga (search polje)
        $dataTable->filter(function ($query) use ($request, $searchFilters) {  
            if (
                    $request->has('search') && is_array($request->get('search'))                      
                    && isset($request->get('search')['value'])   
            ) {

                $searchTerm = $request->get('search')['value'];

                // da dobijemo npr: $searchTerm = 'aaa';       
                $query->where(function($query) use($searchTerm) { 
                    // PA U ZAGRADI OR - USLOVI 
   
                    $query->where('post_id', '=', $searchTerm) // po id // moze i LIKE
//                            ->orWhere('coments.name', 'LIKE', '%' . $searchTerm . '%') // sa where() bi bilo AND, sa orWhere() je OR
//                            ->orWhere('posts.description', 'LIKE', '%' . $searchTerm . '%')
//                            ->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%')
//                            ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%')
                            //->orWhere('posts.id', '=', $searchTerm) // po id // moze i LIKE
                    ;
                });
            }
 

            // ovde, da bude sve na jednom mestu
//            if (isset($searchFilters['body'])) {
//                $query->where('coments.body', 'LIKE', '%' . $searchFilters['body'] . '%');
//            }
            if (isset($searchFilters['post_id'])) {
                $query->where('comments.post_id', '=', $searchFilters['post_id']);
            }
//            if (isset($searchFilters['post_id'])) {
//                $query->where('comments.post_id', 'LIKE', '%' . $searchFilters['post_id'] . '%');
//            }
//            if (isset($searchFilters['category_id'])) {
//                $query->where('posts.category_id', 'LIKE', '%' . $searchFilters['category_id'] . '%');
//            }
//            if (isset($searchFilters['index_page'])) {
//                $query->where('posts.index_page', 'LIKE', '%' . $searchFilters['index_page'] . '%');
//            }
//            if (isset($searchFilters['status'])) {
//                $query->where('posts.status', 'LIKE', '%' . $searchFilters['status'] . '%');
//            } 
            // niz, vezna tab:
//            if (isset($searchFilters['tag_ids'])) {
//                $query->whereHas('tags', function ($subQuery) use ($searchFilters) {
//                    $subQuery->whereIn('tag_id', $searchFilters['tag_ids']);
//                    // PostsMoldel ima relaciju tags, to je prvi argument
//                    // $subQuery je podupit: 
//                    //   select ... where posts IN (SELECT post_id FROM post_tag WHERE tag_id IN (3,4))
//                });
//            }
//            if (isset($searchFilters['comments'])) { 
//            }
//            if (isset($searchFilters['views'])) { 
//            }
        });
 
        return $dataTable->make(true); // make() pravi json po specifikaciji Datatables plugina
    }

    public function enable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:comments,id'],
        ]);

        $formData['id'];

        $comment = Comment::findOrFail($formData['id']);

        $comment->status = Comment::STATUS_ENABLED;
        $comment->save();

        return response()->json([
                    'system_message' => __('Comment has been enabled')
        ]);
    }

    public function disable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:comments,id'],
        ]);

        $formData['id'];

        $comment = Comment::findOrFail($formData['id']);

        $comment->status = Comment::STATUS_DISABLED;
        $comment->save();

        return response()->json([
                    'system_message' => __('Comment has been disabled')
        ]);
    }

    public function delete(Request $request) {

        // dd('Tags insert action');
//        return view('admin.tags.delete',[
//            
//        ]);
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:tags,id'],  
        ]);

        $formData['id']; // ?

        $tag = Tag::findOrFail($formData['id']);

        $tag->delete(); // 1. nacin. brisanje preko objekta
        // BRISEMO REDOVE IZ VEZNE TABELE ZA OBRISANI IZ SIFARNIKA:
        \DB::table('post_tag')
                ->where('tag_id', '=', $tag->id)
                ->delete()
        ;


        //
        //
        // Tag::query()->where('id','=',$formData['id'])->delete(); // 2. nacin. preko QB-ra. moze vise redova odjednom, pisemo upit
        // Tag::query()->where('created_at','<',date('Y-m-d H:i:s', strtotime('-1 year')))->delete(); //  npr: koji su stariji od 1 godine     

        session()->flash('system_message', __('Tag has been deleted!'));

        return redirect()->route('admin.tags.index');
    }

}
