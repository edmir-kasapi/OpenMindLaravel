<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\User;
use App\Services\User\UserService;
use App\Http\Requests\Auth\EditPasswordRequest;


new class extends Component
{
    public User $user;

    public string $password;
    public string $password_confirmation;

    protected function rules()
    {
        return (new EditPasswordRequest())->rules();
    }

    public function update(UserService $userService)
    {
        $validated = $this->validate();
        $userService->updateUserInfo($this->user, $validated);

        $this->reset();
        $this->dispatch('account-updated');
        $this->dispatch(
            'show-success-message',
            message: 'Password updated successfully!'
            );
    }
};
?>

<div>
    <form wire:submit="update" method="post" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <div class="form-group">
                <label
                    class="form-label @error('password') text-danger @enderror">{{ __('user/profile.password') }}</label>
                <input type="password" wire:model="password" required
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="label mt-1 mb-2">
                        <span class="label-text-alt text-danger">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label
                    class="form-label mt-2 @error('password') text-danger @enderror">{{ __('user/profile.confirm') }}</label>
                <input type="password" wire:model="password_confirmation" required
                    class="form-control @error('password') is-invalid @enderror">
            </div>
        </div>


        <div class="col-12">
            <button type="submit" class="btn btn-primary">{{ __('user/profile.save_changes') }}</button>
            <button type="reset" class="btn btn-outline-secondary ms-1">
                {{ __('user/profile.cancel') }}
            </button>
        </div>

    </form>
</div>
