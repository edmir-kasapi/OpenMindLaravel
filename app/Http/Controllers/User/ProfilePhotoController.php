<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ClearProfileRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\ProfilePhoto;
use App\Services\Media\ProfilePhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function update(UpdateProfileRequest $request)
    {
        $this -> profilePhotoService -> updateProfilePicture(Auth::user(), $request);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClearProfileRequest $request)
    {
        if (isset(Auth::user()->profile)) {
           $this -> profilePhotoService -> deleteProfilePicture(Auth::user()->profile);
        }

        return redirect()->route('user.profile')->with('success','Profile updated successfully!');
    }
}
