<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail; //
use App\Models\Category;
use App\Models\Post;
use Session;

class ContactController extends Controller {

    public function index(Request $request) {


        $systemMessage = session()->pull('system_message');

        $firstFiveCategories = Category::query()
                ->orderBy('priority')
                ->withCount(['posts'])
                ->limit(5)
                ->get();


        $lastThreePosts = Post::query()
                ->where('status', 1)
                ->orderBy('id', 'desc')
                //     ->orderBy('created_at', 'DESC') 
                ->limit(3)
                ->get();


        $lastThreePostsMostVisitedLastMonth = Post::query()
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                ->orderBy('views', 'DESC')
                ->orderBy('id', 'desc')
                // ->orderBy('created_at', 'DESC') 
                ->limit(3)
                ->get();


        return view('front.contact.index', [
            'systemMessage' => $systemMessage,
            'firstFiveCategories' => $firstFiveCategories,
            //
            'lastThreePosts' => $lastThreePosts,
            'lastThreePostsMostVisitedLastMonth' => $lastThreePostsMostVisitedLastMonth,
        ]);
    }

    // POSEBNA RUTA ZA OBRADU FORME: 
    public function sendMessage(Request $request) {


        $formData = $request->validate([
            'your_name' => 'required|string|min:2',
            'your_email' => ['required', 'email'],
            'your_message' => ['required', 'string', 'min:10', 'max:255'], // 'required|string|min:50|max:255',  
            //
            'g-recaptcha-response' => function ($attribute, $value, $fail) {
               $secretKey = config('services.recaptcha.secret'); // '6LcCMeodAAAAABNlKiQzjRnIxuz77TOlz1ffubgx'; //  <<
               $response = $value;
               
               $userIp = $_SERVER['REMOTE_ADDR'];
               $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIp";
               $response = \file_get_contents($url);
               $response = json_decode($response); // odgovor Google-a
                     
               if(!$response->success){
//                   $session->flash('g-recaptcha-response', 'check recaptcha');
//                   $session->flash('alert-class', 'alert-danger');
                   Session::flash('g-recaptcha-response', 'check recaptcha');
                   Session::flash('alert-class', 'alert-danger');
                   $fail($attribute.' google recaptcha failed');
               }
               //dd($response);
            },
        ]);

    //     dd($request->input());
    //     dd('sending mail');

        \Mail::to('miloskostic@inbox.ru')
                ->send(new ContactFormMail(
                                $formData['your_email'],
                                $formData['your_name'],
                                $formData['your_message'],
        ));

        session()->flash(
                'system_message',
                'We have received your message, we will contact you soon.'
        );

        return redirect()->back();
    }

}
