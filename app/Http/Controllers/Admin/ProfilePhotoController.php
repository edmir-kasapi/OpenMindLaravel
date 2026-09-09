<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\AdminClearProfileRequest;
use App\Http\Requests\Admin\Media\AdminUpdateProfileRequest;
use App\Models\ProfilePhoto;
use App\Models\User;
use App\Services\Media\ProfilePhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function __construct(
        protected ProfilePhotoService $profilePhotoService
    )
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, AdminUpdateProfileRequest $request)
    {
        $this -> profilePhotoService -> updateProfilePicture($user, $request);

        return redirect() -> route('admin.users.inspect', $user->id)->with('success','User edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, AdminClearProfileRequest $request)
    {
        if (isset($user->profile)) {
            $this -> profilePhotoService -> deleteProfilePicture($user->profile);
        }

        return redirect() -> route('admin.users.inspect', $user->id)->with('success','User edited successfully!');
    }
}
