<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    //
    protected $contactMessage;
    protected $contactName;
    protected $contactEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactEmail, $contactName, $contactMessage)
    {
       // dd($contactEmail,$contactName,$message); // provera
        // 
        $this->setMessage($contactMessage);
        $this->setContactEmail($contactEmail);
        $this->setContactName($contactName);
        
    }
    
    
    
    function getMessage() {
        return $this->contactMessage;
    }
    function getContactName() {
        return $this->contactName;
    }
    function getContactEmail() {
        return $this->contactEmail;
    }

    
    function setMessage($message) {
        $this->contactMessage = $message;
        return $this;
    }
    function setContactName($contactName) {
        $this->contactName = $contactName;
        return $this;
    }
    function setContactEmail($contactEmail) {
        $this->contactEmail = $contactEmail;
        return $this;
    }

    
    
    
    
        /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->message); // provera
        
        //from
        //to
        //replyTo
        //cc
        //bcc
        //subject
        //body
        //
        $this->from(config('mail.username'),  // vidi .env fajl
                //$this->contactEmail, // $this->contactEmail, $this); // za from polje treba email a moze i labela, tj naziv
                $this->contactName             
                ) 
                ->replyTo($this->contactEmail)
                ->subject('New message from contact form on blog')
                ;
        
        return $this->view('front.emails.contact_form') // na ovu skriptu prosledimo: PORUKU I IME:
                ->with([        // ZA PROSLEDJIVANJE VEZUJEMO with() METODU:
                    'contactName'=> $this->contactName,
                        // pod ovim ljucevima saljemo promenlijve u view skripte:
                        // ne dozvoljava se 'message'
                    'contactMessage'=> $this->contactMessage,
                ]);
    }
}
