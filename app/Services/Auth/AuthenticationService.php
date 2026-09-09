<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function logIn(array $credentials, String $guard = 'web', bool $remember = false) : bool
    {
        if(!Auth::guard($guard) -> attempt($credentials, $remember))
        {
            return false;
        }

        request()->session()->regenerate();
        return true;
    }

    public function logout(User $user, String $guard = 'web')
    {
        Auth::guard($guard)->logout($user);

        request()->session()->invalidate();
        request()->session()->regenerateToken();

    }
}
