<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//
use App\Models\Category;


class CategoriesController extends Controller
{
    
    //
    public function index(Request $request){  
        
        $categories = Category::query()
                    ->orderBy('priority')
                    ->get()
                    ;
        
        return view('admin.categories.index',[
            'categories' => $categories,
        ]);
    }
    
    public function add(Request $request){  
        return view('admin.categories.add',[
            
        ]);
    }    
    public function insert(Request $request){  
        
        $formData=$request->validate([
            'name'=>['required','string','min:2','unique:categories,name'],  
            'description'=>['nullable','string','min:10','max:255'], // nije required - nullable. max 255 je u bazi
        ]);
        
       // dd($formData);
        
        // insert novog reda u bazu:
        $newCategory = new Category();
            // prvo u klasu Category model i oznacis ova polja da su: fillable
        $newCategory->fill($formData);
        
        // da kad se doda novi red u formi za dodavanje, prvo nadje koja je kateg sa najnizim prioritetom (najveci broj) pa doda +1
        //  dohvati po prioritetu, opadajuce, pa prvog sa liste:
        $categoryWithLowestPriority = Category::query()
                    ->orderBy('priority','desc')
                    ->first();
        
        if($categoryWithLowestPriority){
              $newCategory->priority=$categoryWithLowestPriority->priority+1;
        }else{
            // za slucaj da nema ni jednog:
            $newCategory->priority = 1; // mozemo od 1 da pocnemo
        }
      
        $newCategory->save();
        
        session()->flash('system_message',__('Category has been added.'));
        
        return redirect()->route('admin.categories.index');
        
    }
    
    public function edit(Request $request, Category $category){ // u URL ce biti id kategorije pa radimo RMB, 
                                                    // DA LAR PO ID IZVUCE CEO OBJEKAT category. ako ne nadje vraca 404 not found
        return view('admin.categories.edit',[
            'category'=>$category,
        ]);
    }
    
    public function update(Request $request, Category $category){
        
        $formData = $request->validate([
           // 'email' => ['required', 'email', 'max:255', Rule::unique('users')->where('email')->ignore( $category->id)],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],           
        ]);

         $category->fill($formData);

         $category->save();
 

        session()->flash('system_message', __('Category has been updated!'));

        return redirect()->route('admin.categories.index');
    }
    
    
    public function delete(Request $request){
        
        $formData = $request->validate([
           'id' => ['required','numeric','exists:categories,id'],
        ]);        
        $category = Category::findOrFail($formData['id']);             
        $category->delete();        
        // da po brisanju reda ispomera prioritete onih redova koji su sa vecim brojem prioriteta, 1,2, 4,5 -> 1,2,3,4
        Category::query()
                    ->where('priority','>',$category->priority)
                    ->decrement('priority')
//                   ->update([
//                       'priority' => \DB::raw('priority-1') // Lar zahteva \DB fasadu jer je 'priority-1' - izraz
//                   ])
                    ;
        
        // Vezane redove uz posts da promeni category_id u NULL, RUCNO
        foreach($category->posts() AS $post){
            $post->deleteCategoryId();
        }
        
        
        session()->flash('system_message',__('Category has been deleted!'));
        
        return redirect()->route('admin.categories.index');
        
    }
    
    
    // za obradu male forme na: categories/index.blade
    public function changePriorities(Request $request){
        $formData = $request->validate([
            'priorities' => ['required','string'],
        ]);
        
        // string iz parametra pretvori  u niz tipa: [7,3,4,2] - ovo su id-jevi, 
        $priorities = explode(',',$formData['priorities']);
        //      za njih sada treba da dodelim prioritete po ovom redu: 1,2,3,4
        foreach($priorities as $key=>$id){ // $key=0,$id=7; $key=1,$id=3; ...
            $category = Category::findOrFail($id);
            $category->priority = $key+1; // o index
            $category->save();
        }
        session()->flash('system_message',__('Categories have been reordered!'));
        return redirect()->route('admin.categories.index');
    }
}
