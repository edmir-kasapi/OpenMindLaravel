<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\User;

new class extends Component
{
    public User $user;
    public bool $isUser;

    #[On('account-updated')]
    public function refresh()
    {
        $this->user->refresh();
        $this->user->load('profile');
    }
};
?>

<div>
    <x-user-options-dropdown :auth-user="$user" :is-user="$isUser" />
</div>
