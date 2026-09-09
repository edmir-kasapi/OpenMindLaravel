<?php

use Livewire\Component;
use App\Models\User;
use App\Http\Requests\Auth\UpdateAccountRequest;
use App\Services\User\UserService;
use Illuminate\Validation\Rule;

new class extends Component {

    public User $user;

    public string $name = '';
    public string $email = '';

    public function mount(User $user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
    }

    protected function rules(): array
    {
        return [
            "name" => ['required','string','max:255'],
            "email" => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)], //,
        ];
    }

    public function update(UserService $userService): void
    {
        $validated = $this->validate();
        $userService->updateUserInfo($this->user, $validated);

        $this->dispatch('account-updated');
        $this->dispatch('show-success-message',
            message: 'Account info updated successfully!'
            );
    }
};
?>

<form wire:submit="update" class="row g-3">
    @csrf

    <div class="col-md-6">
        <label class="form-label @error('name') text-danger @enderror" for="profile-first">
            {{ __('user/profile.username') }} </label>
        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"
            placeholder="{{ __('user/profile.enter_username_here') }}" required value="{{ auth()->user()->name }}">
        @error('name')
            <div class="label mt-1 mb-2">
                <span class="label-text-alt text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label @error('email') text-danger @enderror"
            for="profile-last">{{ __('user/profile.email') }} </label>
        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror"
            placeholder="{{ __('user/profile.enter_email_here') }}" required value={{ auth()->user()->email }}>
        @error('email')
            <div class="label mt-1 mb-2">
                <span class="label-text-alt text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">{{ __('user/profile.save_changes') }}</button>
        <button type="reset" class="btn btn-outline-secondary ms-1">
            {{ __('user/profile.cancel') }}
        </button>
    </div>

</form>
