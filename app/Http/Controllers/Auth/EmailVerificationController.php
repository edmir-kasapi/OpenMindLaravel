<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use App\Services\Mail\EmailService;

class EmailVerificationController extends Controller
{
    public function __construct(
        protected EmailService $emailService
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.auth.verify-email');
    }


    public function store(Request $request)
    {
        $this -> emailService -> sendVerificationEmail($request->user());

        return back()->with('message', 'Verification link sent!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmailVerificationRequest $request)
    {
        $request->fulfill();

        event(new Verified($request->user()));

        return redirect()->route('user.home');
    }

}
