<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateAccountRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAccount extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateAccountRequest $request)
    {
         $this -> userService -> updateUserInfo(Auth::user(), $request->validated());

        return redirect()->route('user.profile')->with('success', 'Account updates successfully');
    }
}
