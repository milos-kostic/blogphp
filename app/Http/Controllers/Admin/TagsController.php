<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tag; //
use Illuminate\Validation\Rule; //

class TagsController extends Controller
{
    //
    public function index(){
        
        // dd('Tags index action');
         
        
        $tags = Tag::all();  
        
        
        return view('admin.tags.index',[
            'tags'=>$tags,
           // 'systemMessage' => $systemMessage, // tu poruku prosledim na view skriptu kao parametar 
        ]);
        
    }
    
    
    
    public function add(Request $request){
        
        // dd('Tags add action');
        return view('admin.tags.add',[
            
        ]);
        
    }
    
      public function insert(Request $request){  
        
       
//        
          $formData = $request->validate([  
              'name'=>['required','string','max:10', 'unique:tags,name'],
          ]);
                 
          
          $newTag = new Tag();
           
          // MASS ASSIGNMENT:
          $newTag->fill($formData); 
          
         //   dd($newTag); 
          $newTag->save(); // UNOSI FIZICKI U BAZU
          
          // 
          session()->flash('system_message', __('New Tag has been added!'));  
          
          return redirect()->route('admin.tags.index');  
    }
    
    
    public function edit(Request $request, Tag $tag){ // PRIKAZUJE, ALI PRIMA PARAMETAR,
                        // route MODEL BINDING, DA LAR AUTOMATSKI UCITA CEO OBJEKAT PO TIPU PARAMETRA, ako nema u bazi - vrati 404 stranu
        
        // dd('Tags insert action');
        return view('admin.tags.edit',[
            'tag'=>$tag,
        ]);
        
    }
    
    public function update(Request $request, Tag $tag){  
                        // route MODEL BINDING, DA LAR AUTOMATSKI UCITA CEO OBJEKAT PO TIPU PARAMETRA, ako nema u bazi - vrati 404 stranu
         
        $formData = $request -> validate([
            'name'=>['required','string','max:10', Rule::unique('tags')->ignore($tag->id),], // tabela: tags, kolona: name
        ]);
        
     //   dd($formData);
        
        $tag->fill($formData);
        
        $tag->save();
        
        session()->flash('system_message', __('Tag has been updated!'));
        
        return redirect()->route('admin.tags.index');
    }
    
    
    
    public function delete(Request $request){
        
        // dd('Tags insert action');
//        return view('admin.tags.delete',[
//            
//        ]);
        $formData = $request->validate([
            'id'=>['required','numeric','exists:tags,id'],  
        ]);
        
        $formData['id']; // ?
        
        $tag = Tag::findOrFail($formData['id']);
        
        $tag->delete(); // 1. nacin. brisanje preko objekta
        
        // BRISEMO REDOVE IZ VEZNE TABELE ZA OBRISANI IZ SIFARNIKA:
        \DB::table('post_tag')
                ->where('tag_id','=',$tag->id)
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
