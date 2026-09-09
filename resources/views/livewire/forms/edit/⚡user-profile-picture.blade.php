<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Models\User;
use App\Models\ProfilePhoto;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Services\Media\ProfilePhotoService;

new class extends Component {
    use WithFileUploads;

    public User $user;
    public $profile = '';

    public function update(ProfilePhotoService $profilePhotoService)
    {
        $validated = $this->validate([
            'profile' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp'],
        ]);

        $profilePhotoService->updateprofilePictureLivewire($this->user, $this->profile);

        $this->reset('profile');
        $this->dispatch('account-updated');
        $this->dispatch('show-success-message', message: 'Profile Picture updated successfully.');
    }

    public function destroy(ProfilePhotoService $profilePhotoService)
    {
        if ($this->user->profile) {
            $profilePhotoService->deleteProfilePicture($this->user->profile);
            $this->dispatch('account-updated');
            $this->dispatch('show-success-message', message: 'Profile Picture removed successfully.');

            return;
        }

        $this->dispatch('show-error-message', message: 'No profile picture to remove.');
    }

    #[On('account-updated')]
    public function refresh()
    {
        $this->user->refresh();
        $this->user->load('profile');
    }
};
?>

@php
    $src = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF';

    if (isset($user->profile)) {
        $src = asset('storage/profiles/' . $user->profile->getSrc());
    }
@endphp

<div>
    <form wire:submit="update" enctype="multipart/form-data" row g-3>
        @csrf



        <div class="col-md-6">
            <img src="{{ $src }}" class="img-thumbnail" width="250" height="250">
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label
                    class="form-label mt-2  @error('profile') text-danger @enderror">{{ __('user/profile.profile') }}</label>
                <input class="form-control @error('profile') is-invalid @enderror" type="file" wire:model="profile"
                    required>
                @error('profile')
                    <div class="label mt-1 mb-2">
                        <span class="label-text-alt text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <input type="submit" value="{{ __('user/profile.edit') }}" wire:loading.attr="disabled" wire:target="profile,update" class="btn btn-info text-white mt-3">

                <div wire:loading wire:target="profile,update" class="ms-2">
                   <span> Uploading image... </span>
                </div>

            </div>
        </div>
    </form>

    <form wire:submit="destroy">
        @csrf
        @method('DELETE')

        <input type="submit" name="removeProfileReq" value="{{ __('user/profile.clear_picture') }}"
            class="btn btn-danger text-white mt-2">
    </form>
</div>
