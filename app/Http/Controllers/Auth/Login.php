<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function __construct(
        protected AuthenticationService $authenticationService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request -> boolean('remember');

        if ($this -> authenticationService -> logIn($credentials, 'web', $remember )) {

            $user = Auth::user();

            switch($user->role->role)
            {
                case 'Admin':
                    return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back!');
                    break;
                case 'User':
                    return redirect()->intended(route('user.home'))->with('success', 'Welcome back!');
                    break;
                case 'Store Operator':
                    return redirect()->intended(route('operator.dashboard'))->with('success', 'Welcome back!');
                    break;
            }
        }

        return back()
            ->withErrors(['email' => 'The provided credentials do not match our records'])
            ->onlyInput('email');
    }
}
