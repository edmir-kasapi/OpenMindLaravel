<?php

namespace App\Services\Mail;

use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class EmailService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function sendContactMail(string $recipient, array $data)
    {
        Log::info('Contact email queued at: ' . now());
        Mail::to($recipient)->send(new ContactEmail($data));
    }

    public function sendVerificationEmail(User $user)
    {
        $user->sendEmailVerificationNotification();
    }

    public function sendForgotPasswordEmail(array $emailData)
    {
        return \Password::sendResetLink( $emailData );
    }
}
