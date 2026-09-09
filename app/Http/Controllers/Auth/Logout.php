<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogoutRequest;
use App\Services\Auth\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{
    public function __construct(
        protected AuthenticationService $authenticationService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(LogoutRequest $request)
    {
        $locale = $request->session()->get('lang');
        $this -> authenticationService -> logOut(Auth::user(), 'web');
        $request -> session() -> put('lang', $locale);

        return redirect() -> route('index') -> with('success','Logout successful.');
    }
}
