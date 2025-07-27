<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//
use App\Models\Slide;


class SlidesController extends Controller
{
    
    //
    public function index(Request $request){  
        
        $slides = Slide::query()
                    ->orderBy('priority')
                    ->get();
        
        return view('admin.slides.index',[
            'slides' => $slides,
        ]);
    }
    
    
    public function add(Request $request){  
       
        return view('admin.slides.add',[
            
        ]);
    }    
    
    
    
    public function insert(Request $request){  
   
        $formData=$request->validate([
            'name'=>['required','string','min:2','unique:slides,name'],  
            'button_name'=>['nullable','string','min:2','unique:slides,button_name'],  
            'button_url'=>['nullable','string','min:2'],  
            
            'status'=>['nullable','numeric'], // "in:1,0"
          
            'photo' => ['nullable', 'file', 'image'],
        ]);
        
         
        $newSlide = new Slide();
            
        $formData['user_id'] = auth()->user()->id; // trenutno ulogovan korisnik
        
        $newSlide->fill($formData);
        
        // da kad se doda novi red u formi za dodavanje, prvo nadje koja je kateg sa najnizim prioritetom (najveci broj) pa doda +1
        //  dohvati po prioritetu, opadajuce, pa prvog sa liste:
        $slideWithLowestPriority = Slide::query()
                    ->orderBy('priority','DESC')
                    ->first();
        
        if($slideWithLowestPriority){
              $newSlide->priority=$slideWithLowestPriority->priority+1;
        }else{
            // za slucaj da nema ni jednog:
            $newSlide->priority = 1; // mozemo od 1 da pocnemo
        }
      
        $newSlide->save();
        
   // dd($newSlide);
        $this->handlePhotoUpload($request, $newSlide);
          
          
        session()->flash('system_message',__('Slide has been added.'));
        
        return redirect()->route('admin.slides.index');
        
    }
    
    public function edit(Request $request, Slide $slide){ 
                                                   
        return view('admin.slides.edit',[
            'slide'=>$slide,
        ]);
    }
    
    
    public function update(Request $request, Slide $slide) {
  
        $formData = $request->validate([
           // 'email' => ['required', 'email', 'max:255', Rule::unique('users')->where('email')->ignore($user->id)],
            'name' => ['required', 'string', 'max:255'],
            'button_name' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'numeric'], // "in:0,1"
            'photo' => ['nullable', 'file', 'image'],
        ]);

        $slide->fill($formData);

        $slide->save();

        $this->handlePhotoUpload($request, $slide);

        session()->flash('system_message', __('Slide has been updated!'));

        return redirect()->route('admin.slides.index');
    }

    
    public function delete(Request $request){
        
        $formData = $request->validate([
           'id' => ['required','numeric','exists:slides,id'],
        ]);
        
        $slide = Slide::findOrFail($formData['id']);
        
        $slide->delete();
        
        // da po brisanju reda ispomera prioritete onih redova koji su sa vecim brojem prioriteta, 1,2, 4,5 -> 1,2,3,4
        Slide::query()
                    ->where('priority','>',$slide->priority)
                    ->decrement('priority')
//                   ->update([
//                       'priority' => \DB::raw('priority-1') // Lar zahteva \DB fasadu jer je 'priority-1' - izraz
//                   ])
                    ;
        
        $slide->deletePhotos(); // pravimo helper
         
        session()->flash('system_message',__('Slide has been deleted!'));
        
        return redirect()->route('admin.slides.index');
        
    }
    
    
    // za obradu male forme na: slides/index.blade
    public function changePriorities(Request $request){
        $formData = $request->validate([
            'priorities' => ['required','string'],
        ]);
        
        // string iz parametra pretvori  u niz tipa: [7,3,4,2] - ovo su id-jevi, 
        $priorities = explode(',',$formData['priorities']);
       
        foreach($priorities as $key=>$id){ // $key=0,$id=7; $key=1,$id=3; ...
            $slide = Slide::findOrFail($id);
            $slide->priority = $key+1; // o index
            $slide->save();
        }
        session()->flash('system_message',__('Slides have been reordered!'));
        return redirect()->route('admin.slides.index');
    }
    
    
    
    /*****************************************************
     * ***************************************************
     * 
     */
     public function disable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slides,id'],
        ]);

        $formData['id'];

        $slide = Slide::findOrFail($formData['id']);
 
       
        
        $slide->status = 0; // User::STATUS_DISABLED; 
    //    dd($slide);
        $slide->save();

        return response()->json([
                    'system_message' => __('Slide has been disabled')
        ]);
    }
    public function enable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slides,id'],
        ]);

        $formData['id'];

        $slide = Slide::findOrFail($formData['id']);
         
        
        $slide->status = 1; // User::STATUS_ENABLED;
        $slide->save();

        return response()->json([
                    'system_message' => __('Slide has been enabled')
        ]);
    }
    public function deletePhoto(Request $request, Slide $slide) {
        $slide->deletePhoto('photo');
 
        //reset kolone photo1 ili photo2 na null
        //da izbrisemo podatak u bazi o povezanoj fotografiji
        $slide->photo = null;
        $slide->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted'),
                    'photo_url' => $slide->getPhotoUrl('photo'),
        ]);
    }
    protected function handlePhotoUpload(Request $request, Slide $slide) {
 //   dd($request->file('photo'));  
        if ($request->hasFile('photo')) { 
            
            $slide->deletePhoto('photo');

            $photoFile = $request->file('photo');

            $newPhotoFileName = $slide->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/slides/'), $newPhotoFileName
            );
            
//dd($photoFile);
            
            $slide->photo = $newPhotoFileName;
 
            $slide->save();

            //originalna slika
            \Image::make(public_path('/storage/slides/' . $slide->photo))
                    ->fit(1280, 1024)
                    ->save();
            
            
            // thumb umanjena 300x300
            \Image::make(public_path('/storage/slides/' . $slide->photo))
                    ->fit(120, 120)
                    ->save(public_path('/storage/slides/thumbs/' . $slide->photo));

        }
    }
    
    
}
