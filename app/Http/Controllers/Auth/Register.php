<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Auth\RegistrationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Register extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = $this -> registrationService -> register( $request->validated());

        Auth::login($user);

        event(new Registered($user));

        return redirect() -> route('user.home')->with('success','You are now logged in.');
    }
}
