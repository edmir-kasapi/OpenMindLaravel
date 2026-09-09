<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mail\ContactMailRequest;
use App\Services\Mail\EmailService;


class ContactEmailController extends Controller
{
    public function __construct(
        protected EmailService $emailService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(ContactMailRequest $request)
    {
        $this -> emailService -> sendContactMail('kasapiedmir1@gmail.com', $request -> validated());
        return redirect()->route('contact')->with('success', 'Contact email sent successfully!');
    }
}
