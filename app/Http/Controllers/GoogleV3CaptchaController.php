<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\ContactUs;
use Validator;
use Session;

class GoogleV3CaptchaController extends Controller {

    public function index() {

        return view('google-v3-recaptcha');
    }

    public function validateGCaptch(Request $request) {

        $input = $request->all();


        $validator = Validator::make($input, [
                    'name' => 'required',
                    'email' => 'required',
                    'subject' => 'required',
                    'message' => 'required',
                    'g-recaptcha-response' => 'required',
        ]);


        if ($validator->passes()) {

            ContactUs::create($input);

            return redirect('google-v3-recaptcha')->with('status', 'Google V3 Recaptcha has been validated form');
        }


        return redirect()->back()->withErrors($validator)->withInput();
    }

}
