<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminCreateUserRequest;
use App\Http\Requests\Admin\Users\AdminDeleteUserRequest;
use App\Http\Requests\Admin\Users\AdminUpdateAccountRequest;
use App\Models\User;
use App\Services\Auth\RegistrationService;
use App\Services\Media\ProfilePhotoService;
use App\Services\User\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService,
        protected UserService $userService,
        protected ProfilePhotoService $profilePhotoService
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return view("pages.admin.users.users",);
    }

    public function trashIndex(Request $request)
    {
        return view('pages.admin.users.user-trash');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCreateUserRequest $request)
    {
        $user = $user = $this->registrationService->register($request->validated());

        event(new Registered($user));

        return redirect()->route('admin.users')->with('success', 'User registered successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //dd($user);

        return view('pages.admin.users.edit-user', ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, AdminUpdateAccountRequest $request)
    {
        $this->userService->updateUserInfo($user, $request->validated());

        return redirect()->route('admin.users.inspect', $user->id)->with('success', 'User edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, AdminDeleteUserRequest $request)
    {
        //dd($request->all());

        $this->userService->deleteUser($user);

        if ($request->boolean('redirect')) {
            session(['success' => "User Deleted Successfully!"]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Deleted Successfully!',
                'redirect' => route('admin.users')
            ]);
        }

        //return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
        return response()->json(['status' => 'success', 'message' => 'User Deleted Successfully!']);
    }

    /**
     * Restore the specified resource in storage.
     */
    public function restore(string $id)
    {
        if (!$this->userService->restoreUser(User::onlyTrashed()->findOrFail($id))) {

            return response()->json(['status' => 'error', 'message' => 'User Could not be restored. Email Already in Use!']);
        }

        return response()->json(['status' => 'success', 'message' => 'User restored Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDelete(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (isset($user->profile)) {
            $this->profilePhotoService->deleteProfilePicture($user->profile);
        }

        $this -> userService -> forceDeleteUser($user);

        return response()->json(['status' => 'success', 'message' => 'User Pemanently Deleted Successfully!']);
    }

    public function import()
    {

    }
}
