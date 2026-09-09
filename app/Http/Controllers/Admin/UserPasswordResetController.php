<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminEditPasswordRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserPasswordResetController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, AdminEditPasswordRequest $request)
    {
        $this -> userService ->updateUserInfo($user,$request->validated());

        return redirect() -> route('admin.users.inspect', $user->id)->with('success','User edited successfully!');
    }
}
