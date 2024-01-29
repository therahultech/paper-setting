<?php

namespace App\Http\Controllers;
use App\Mail\MyMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class MailController extends Controller
{
    //
    public function index()
    {
        // Your index logic here
        // return view('mail.index'); // Assuming you have a view file in resources/views/mail/index.blade.php
        echo "Hello World";

        $details = [
            'title' => 'Mail from Laravel',
            'body' => 'This is a test email from Laravel using Google SMTP.',
        ];
    
        return Mail::to('rahul.singh@gjust.org')->send(new MyMail($details));
    }
}
