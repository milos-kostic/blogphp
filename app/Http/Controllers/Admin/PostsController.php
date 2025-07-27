<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post; //
use Illuminate\Validation\Rule; //
use App\Models\Category;
use App\Models\Tag;

class PostsController extends Controller {

    //
    public function index() {

        $posts = Post::query()
                ->with(['user', 'category', 'tags']) // with() prima NIZ RELACIJA KOJE OPTIMIZUJEM
                ->orderBy('created_at', 'desc')
                ->get();        // WITH ce ucitati postove, pa onda PO JEDAN UPIT ZA SVAKU RELACIJU.


        return view('admin.posts.index', [
            'posts' => $posts,
                //         // 'systemMessage' => $systemMessage, // tu poruku prosledim na view skriptu kao parametar 
        ]);
    }

    // IZVLACIMO postove za punjenje tabele na index.blade - ovde, a index akcija ne - ona prikazuje praznu tabelu
    public function datatable(Request $request) {


        /*         * ******************
         * ovde javlja Ajax error ako je ostavljeno neizabrano polje user ili category
         *  resava se:
         *    na NEIZABRANU VREDNOST postavi: value="", vidi posts\index.blade
         * ****************** */
        $searchFilters = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'user_id' => ['nullable', 'numeric', 'exists:users,id'], // !
            'category_id' => ['nullable', 'numeric'], // , 'exists:categories,id'], // moze Uncategorized
            'index_page' => ['nullable', 'numeric', 'in:0,1'],
            'status' => ['nullable', 'numeric', 'in:0,1'],
            'views' => ['nullable', 'numeric'],
            'tag_ids' => ['nullable', 'array', 'exists:tags,id'],
        ]);



        $query = Post::query()
                ->with(['user', 'category', 'tags']) // samo upit, bez get()
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
                ->select([
            'posts.*',
            // vezne:
            'users.name AS user_name',
            'categories.name AS category_name',
        ]);



        // *************************************************
        //  composer require yajra/laravel-datatables-oracle
        // ************************************************* 
        $dataTable = \DataTables::of($query);



        $dataTable->addColumn('tag', function($post) { // DODAMO KOLONU // function($red_u_tabeli)
                    return optional($post->tags->pluck('name'))->join(', '); // optional() kad radimo sa relacijama
                })                                          // optional do poslednje fje se stavlja
//        ->addColumn('user_name', function($post){
//            return optional($post->user)->name;
//        })
                ->addColumn('category_name', function($post) {
                    if ($post->category) {
                        return optional($post->category)->name;
                    }
                    return 'Uncategorized';
                })
                ->editColumn('id', function($post) { // vezujemo: editColumn() menja postojeci red, 
                    return '#' . $post->id;     // dodamo # pred id
                })
                ->editColumn('photo', function($post) { // vezujemo: editColumn() menja postojeci red, 
                    return view('admin.posts.partials.post_photo', [
                        'post' => $post
                    ]);     // <img src="..." - PRAVIMO PARTIAL
                })
                ->editColumn('name', function($post) {
                    return '<strong>' . e($post->name) . '</strong>';
                })             // e() HELPER, KAO {{}}, escape, KORISTIMO UMESTO htmlspecialchars()
                ->editColumn('status', function($post) { // vezujemo: editColumn() menja postojeci red, 
                    $status = $post->status;
                    if ($status) {
                        return '<font style="color:green">Enabled</font>';
                    } else {
                        return '<font style="color:red">Disabled</font>';
                    }
                })
                ->editColumn('index_page', function($post) { // vezujemo: editColumn() menja postojeci red, 
                    $indexPage = $post->index_page;
                    if ($indexPage) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                })
                ->editColumn('created_at', function($post) { // vezujemo: editColumn() menja postojeci red, 
                    return e($post->created_at);
                })
                ->addColumn('comments', function($post) { // DODAMO KOLONU // function($red_u_tabeli)
                    return optional($post->comments)->count(); // optional() kad radimo sa relacijama
                })
//                ->editColumn('views', function($post) { // DODAMO KOLONU // function($red_u_tabeli)
//                    return optional($post->views); // optional() kad radimo sa relacijama
//                })  
                ->addColumn('actions', function($post) {
                    return view('admin.posts.partials.actions', ['post' => $post]);
                });


        $dataTable->rawColumns(['name', 'photo', 'actions', 'status']);


        /* filter fja za search        * ************** */
        // pretraga (search polje)
        $dataTable->filter(function ($query) use ($request, $searchFilters) {
            if (
                    $request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])
            ) {

                $searchTerm = $request->get('search')['value'];

                $query->where(function($query) use($searchTerm) {
                    // PA U ZAGRADI OR - USLOVI 
                    $query->orWhere('posts.name', 'LIKE', '%' . $searchTerm . '%') // sa where() bi bilo AND, sa orWhere() je OR
                            ->orWhere('posts.description', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('posts.id', '=', $searchTerm) // po id // moze i LIKE
                    ;
                });
            }


            // ovde, da bude sve na jednom mestu
            if (isset($searchFilters['name'])) {
                $query->where('posts.name', 'LIKE', '%' . $searchFilters['name'] . '%');
            }
            if (isset($searchFilters['user_id'])) {
                $query->where('posts.user_id', 'LIKE', '%' . $searchFilters['user_id'] . '%');
            }
            if (isset($searchFilters['category_id'])) {
                $query->where('posts.category_id', 'LIKE', '%' . $searchFilters['category_id'] . '%');
            }
            if (isset($searchFilters['index_page'])) {
                $query->where('posts.index_page', 'LIKE', '%' . $searchFilters['index_page'] . '%');
            }
            if (isset($searchFilters['status'])) {
                $query->where('posts.status', 'LIKE', '%' . $searchFilters['status'] . '%');
            }
            // niz, vezna tab:
            if (isset($searchFilters['tag_ids'])) {
                $query->whereHas('tags', function ($subQuery) use ($searchFilters) {
                    $subQuery->whereIn('tag_id', $searchFilters['tag_ids']);
                    // PostsMoldel ima relaciju tags, to je prvi argument
                    // $subQuery je podupit: 
                    //   select ... where posts IN (SELECT post_id FROM post_tag WHERE tag_id IN (3,4))
                });
            }
//            if (isset($searchFilters['comments'])) { 
//            }
//            if (isset($searchFilters['views'])) { 
//            }
        });

        return $dataTable->make(true); // make() pravi json po specifikaciji Datatables plugina
    }

    //
    public function add(Request $request) {

        // dd('Posts add action');

        $categories = Category::query()
                ->orderBy('priority')
                ->get();

        $tags = Tag::all();


        return view('admin.posts.add', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function insert(Request $request) {
//        
        $formData = $request->validate([
            'user_id' => ['required', 'numeric', 'exists:users,id'], // numeric ili int // exists: da li to sto je prosledjeno - zaista postoji u tabeli: users, kol id
            'category_id' => ['nullable', 'numeric', 'exists:categories,id'], // numeric ili int // exists: da li to sto je prosledjeno - zaista postoji u tabeli: users, kol id
            'name' => ['required', 'string', 'min:20', 'max:255', 'unique:posts,name'],
            'description' => ['nullable', 'string', 'min:10', 'max:500'], // tip je 'text'
            'body' => ['nullable', 'string', 'min:25', 'max:4000'], //  nullable,
            'index_page' => ['required', 'numeric', 'in:0,1'],
            'status' => ['required', 'numeric', 'in:0,1'],
            // NIZ IZ VEZNE TABELE, ZA MULTIPLE SELECT POLJE
            'tag_id' => ['required', 'array', 'exists:tags,id', 'min:2'], // ,'max:7'
            // validiramo slike
            'photo' => ['nullable', 'file', 'image'],
                // 'photo2' => ['nullable', 'file', 'image'],
        ]);

        //  dd($formData);

        if (!isset($formData['category_id'])) { 
            $formData['category_id'] = Category::getUncategorizedId();
        }


        $newPost = new Post();

        // $newPost->name = $formData['name'];
        // MASS ASSIGNMENT:
        $newPost->fill($formData); // vidi u Modelu: Size, fillable postavlja koja su to polja koja dozvoljavamo jer Lar podrazumevano zabranjuje ovo
        //  dd($newPost); 

        $newPost->save(); // UNOSI FIZICKI U BAZU
        // tek nakon smestanja u bazu dohvatamo id pa taj id u veznu tabelu. fja sinc()
        $newPost->tags()->sync($formData['tag_id']);
        // sync() metoda prima id-jeve izabranih velicina
        // obrada slike:
        $this->handlePhotoUpload('photo', $newPost, $request); // nasa fja def na dnu
        //$this->handlePhotoUpload('photo2', $newPost, $request); // nasa fja def na dnu
        // 
        session()->flash('system_message', __('New Post has been added!')); // postavimo sist poruku za kratkotraaj upis

        return redirect()->route('admin.posts.index'); // ruta za pregled svih redova
    }

    //
    public function edit(Request $request, Post $post) { // PRIKAZUJE, ALI PRIMA PARAMETAR,
        // route MODEL BINDING, DA LAR AUTOMATSKI UCITA CEO OBJEKAT PO TIPU PARAMETRA, ako nema u bazi - vrati 404 stranu
        // za listu kategorija i tagova treba:         
        $categories = Category::query()
                ->orderBy('priority')
                ->get();
        $tags = Tag::all();


        // dd('Posts insert action');
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request, Post $post) { // PRIKAZUJE, ALI PRIMA PARAMETAR,
//        
        $formData = $request->validate([
            'user_id' => ['required', 'numeric', 'exists:users,id'], // numeric ili int // exists: da li to sto je prosledjeno - zaista postoji u tabeli: users, kol id
            'category_id' => ['nullable', 'numeric', 'exists:categories,id'], // numeric ili int // exists: da li to sto je prosledjeno - zaista postoji u tabeli: users, kol id
            'name' => ['required', 'string', 'min:20', 'max:255', Rule::unique('posts')->ignore($post->id)],
            // proveri da li je naziv jedinstven, ali iskljuci iz provere post sa ovim id-jem
            // 'description' => ['nullable', 'string', 'min:50', 'max:500'], // tip je 'text'
            'description' => ['nullable', 'string', 'min:10', 'max:500'], // tip je 'text'
            'body' => ['required', 'string', 'min:25', 'max:4000'], //  
            'index_page' => ['required', 'numeric', 'in:0,1'],
            'status' => ['required', 'numeric', 'in:0,1'],
            // NIZ IZ VEZNE TABELE, ZA MULTIPLE SELECT POLJE
            'tag_id' => ['required', 'array', 'exists:tags,id', 'min:2'], // ,'max:7'
            // validiramo slike
            'photo' => ['nullable', 'file', 'image'],
                //  'photo2' => ['nullable', 'file', 'image'],
        ]);

        //   dd($formData);


        if (!$formData['category_id']) {
            $formData['category_id'] = 0; // Uncategorized has id=0
        }

        $post->fill($formData);

        $post->save();

        $post->tags()->sync($formData['tag_id']);

        // obrada slike:
        $this->handlePhotoUpload('photo', $post, $request); // nasa fja def na dnu
        //$this->handlePhotoUpload('photo2', $post, $request); // nasa fja def na dnu



        session()->flash('system_message', __('Post has been updated!'));

        return redirect()->route('admin.posts.index');
    }

    /* DELETE */

    public function delete(Request $request) {

        // dd('Posts insert action');
//        return view('admin.posts.delete',[
//            
//        ]);
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        //      $formData['id'];  
        $post = Post::findOrFail($formData['id']);
        //  dd($post)     ;
        $post->delete(); // 1. nacin. brisanje preko objekta
        // BRISEMO REDOVE IZ VEZNE TABELE ZA OBRISANI IZ SIFARNIKA, RUCNO
        \DB::table('post_tag')
                ->where('post_id', '=', $post->id)
                ->delete();
        // 2. NACIN:
        // $post->tags()->delete(); // 2. nacin
        // $post->tags()->sync([]); // 3. nacin. RADE JEDNAKO SVA TRI NACINA
        // delete related comments
        $post->comments()->delete();

        //
        // Post::query()->where('id','=',$formData['id'])->delete(); // 2. nacin. preko QB-ra. moze vise redova odjednom, pisemo upit
        // Post::query()->where('created_at','<',date('Y-m-d H:i:s', strtotime('-1 year')))->delete(); //  npr: koji su stariji od 1 godine     
        // brisanje svih vezanih fajlova - slika: photo i photo2
        $post->deletePhotos(); // pravimo helper



        return response()->json([
                    'system_message' => __('Post has been deleted!')
        ]);
    }

    //
    public function deletePhoto(Request $request, Post $post) {
        $formData = $request->validate([
            'photo' => ['required', 'string', 'in:photo,photo2']
        ]);

        $photoFieldName = $formData['photo'];

        $post->deletePhoto($photoFieldName); // fizicki brise fajl

        $post->$photoFieldName = null;
        $post->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted!'),
                    'photo_url' => $post->getPhotoUrl($photoFieldName),
        ]);
    }

    // user fja za rukovanje slikama:
    protected function handlePhotoUpload(string $photoFieldName, Post $post, Request $request) {


        if ($request->hasFile($photoFieldName)) {

            $photoFieldName == 'photo' ? ($post->deletePhoto1()) : ($post->deletePhoto2());

            $file = $request->file($photoFieldName);

            $photoNameTag = ($photoFieldName == 'photo' ? 'photo' : 'photo2');
            $fileName = $post->id . '_' . $photoNameTag . '_' . $file->getClientOriginalName();

            $file->move(
                    public_path('/storage/posts/'),
                    $fileName
            );

            //
            $post->$photoFieldName = $fileName;
            $post->save();

            // $xDimensionToFit = ($photoFieldName == 'photo'?  800: 300); // 180);
            // $yDimensionToFit = ($photoFieldName == 'photo'?  600: 300); // 180);
            // original za post 800x600
            \Image::make(public_path('/storage/posts/' . $post->$photoFieldName))
                    // ->fit($xDimensionToFit,$yDimensionToFit)
                    ->fit(800, 600)
                    ->save();

            // thumb crop 300x300
            \Image::make(public_path('/storage/posts/' . $post->$photoFieldName))
                    ->fit(256, 256)
                    ->save(public_path('/storage/posts/thumbs/' . $post->$photoFieldName));

            //   dd($photoFieldName, $file);
        }
        //   dd('sss',$photoFieldName,$request->$photoFieldName);
    }

    public function enable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:posts,id'],
        ]);

        $formData['id'];

        $post = Post::findOrFail($formData['id']);

        $post->status = Post::STATUS_ENABLED;
        $post->save();

        return response()->json([
                    'system_message' => __('Post has been enabled')
        ]);
    }

    public function disable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:posts,id'],
        ]);

        $formData['id'];

        $post = Post::findOrFail($formData['id']);

        $post->status = Post::STATUS_DISABLED;
        $post->save();

        return response()->json([
                    'system_message' => __('Post has been disabled')
        ]);
    }

    public function important(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:posts,id'],
        ]);

        $formData['id'];

        $post = Post::findOrFail($formData['id']);

        $post->index_page = Post::IMPORTANT;
        $post->save();

        return response()->json([
                    'system_message' => __('Post has been marked as important')
        ]);
    }

    public function unimportant(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:posts,id'],
        ]);

        $formData['id'];

        $post = Post::findOrFail($formData['id']);

        $post->index_page = Post::UNIMPORTANT;
        $post->save();

        return response()->json([
                    'system_message' => __('Post has been marked as unimportant')
        ]);
    }

}
