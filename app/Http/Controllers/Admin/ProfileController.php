<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller {

    public function edit(Request $request) {

        $user = \Auth::user();

        return view('admin.profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request) {

        $user = \Auth::user();

        $formData = $request->validate([
            //    'email' => ['required', 'email', 'max:255', Rule::unique('users')->where('email')->ignore($user->id)],
            // ne menjamo email

            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'file', 'image'],
        ]);

        $user->fill($formData);

        $user->save();

        $this->handlePhotoUpload($request, $user);

        session()->flash('system_message', __('Your profile has been saved!'));

        return redirect()->route('admin.profile.edit');
    }

    public function deletePhoto(Request $request) {

        $user = \Auth::user();

        $user->deletePhoto();

        //reset kolone photo1 ili photo2 na null
        //da izbrisemo podatak u bazi o povezanoj fotografiji
        $user->photo = null;
        $user->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted'),
                    'photo_url' => $user->getPhotoUrl(),
        ]);
    }

    // akcija za CHANGE-PASSWORD
    public function changePassword(Request $request) {
        return view('admin.profile.change_password', [
        ]);
    }

    public function changePasswordConfirm(Request $request) {
        $user = \Auth::user(); // ulogovani korisnik. $user->password - je hash-ovan

        $formData = $request->validate([
            'old_password' => [
                'required',
                // 'custom validator' iz dokumentacije: https://laravel.com/docs/8.x/validation#using-closures
                function ($attribute, $value, $fail) use ($user) { // use ($user) - jer u anonimnoj f koristimo promenljivu iz vani
                    if (!\Hash::check($value,$user->password)) { // poredim hesovanu vrednost unete lozinke jer je $user->password - hesovan
                        $fail('Your old password is not correct');
                    }
                },
                //
            ],
            'new_password' => ['required', 'string', 'min:8'],
            'new_password_confirm' => ['required', 'same:new_password'],
        ]);
                
        // ako je sve validirano, menjam lozinku:
        $user->password = \Hash::make($formData['new_password']);
        $user->save();
        
        session()->flash('system_message', __('Your password has been changed'));
        return redirect()->route('admin.profile.edit');
    }

    protected function handlePhotoUpload(Request $request, User $user) {
        if ($request->hasFile('photo')) {


            $user->deletePhoto();

            $photoFile = $request->file('photo');

            $newPhotoFileName = $user->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/users/'), $newPhotoFileName
            );

            $user->photo = $newPhotoFileName;

            $user->save();

            //originalna slika
            \Image::make(public_path('/storage/users/' . $user->photo))
                    ->fit(300, 300)
                    ->save();
        }
    }

}
