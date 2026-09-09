<?php

namespace App\Services\Media;

use App\Http\Requests\Admin\AdminUpdateProfileRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\ProfilePhoto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function updateProfilePicture(User $user, Request $request)
    {
        $validated = $request->validated();

        if(isset($user->profile))
        {
            Storage::disk('public')->delete(['profiles/'.$user->profile->getSrc()]); //original file is deleted
        }

        Storage::disk('public')->put('profiles', $request->file('profile')); //new file is uploaded

        $validated['profile'] = $request->file('profile');

        ProfilePhoto::updateOrCreate(
            [
                'user_id' => $user->id //the method checks if there is any user with this id, if zes, it updates, if no, it inserts
            ],
            [
                'hashed_name' => $validated['profile']->hashName(),
                'original_name' => $validated['profile']->getClientoriginalName(),
                'extension' => $validated['profile']->extension(),
                'size' => $validated['profile']->getSize(),
                'user_id' => $user->id
            ]
        );
    }

    public function updateprofilePictureLivewire(User $user, mixed $file)
    {
        if($user->profile)
        {
            Storage::disk('public')->delete('profiles/' . $user->profile->getSrc());
        }

        $profileData = [
        'hashed_name'   => $file->hashName(),
        'original_name' => $file->getClientOriginalName(),
        'extension'     => $file->extension(),
        'size'          => $file->getSize(),
        'user_id'       => $user->id,
        ];

        $file->store('profiles','public');

        ProfilePhoto::updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );
    }

    public function deleteProfilePicture(ProfilePhoto $photo)
    {
       Storage::disk('public')->delete(['profiles/' . $photo->getSrc()]); //original file is deleted

       $photo -> delete();

    }
}
