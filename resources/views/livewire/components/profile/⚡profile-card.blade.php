<?php

use Livewire\Component;
use App\Models\User;
use App\Services\User\UserService;
use Livewire\Attributes\On;


new class extends Component {
    protected UserService $userService;
    public User $user;

    public ?string $userToDelete = null;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function prepareDeleteUser(string $id)
    {
        $this->userToDelete = $id;
        $this->dispatch('show-modal', modalId: 'modal-delete-user');
    }

    public function proceedDeletion()
    {
        if (!$this->userToDelete) {
            return;
        }

        $user = User::find($this->userToDelete);

        if (!$user) {
            $this->userToDelete = null;
            $this->dispatch('show-error-message', message: 'Invalid User ID provided. Cannot delete.');
            return;
        }

        $this->userService->deleteUser($user);
        session()->flash('success', 'User deleted successfullly');

        $this->redirectRoute('admin.users');
    }

    public function cancelDeletion()
    {
        $this->userToDelete = null;
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

<section>

    <div class="card-body text-center">
        <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex mx-auto justify-content-center mb-3"
            style="width: 96px; height: 96px; font-size: 2rem" aria-hidden="true">


            <x-user-profile-picture>



                <x-slot:src>
                    {{ $src }}
                </x-slot:src>

                <x-slot:name>
                    {{ $user->name }}
                </x-slot:name>

                <x-slot:width>150</x-slot:width>
                <x-slot:height>150</x-slot:height>

            </x-user-profile-picture>



        </div>
        <h3 class="h5 mb-0">{{ $user->name }}</h3>
        <p class="text-secondary mb-3">{{ $user->email }}</p>
        <ul class="list-group list-group-flush text-start small">
            <li class="list-group-item d-flex justify-content-between px-0">
                <span class="text-secondary">{{ __('user/profile.role') }}</span>
                <span class="fw-semibold">{{ $user->role->getRoleName() }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between px-0">
                <span class="text-secondary">{{ __('user/profile.joined') }}</span>
                <span class="fw-semibold">{{ $user->created_at }}</span>
            </li>
        </ul>
    </div>

    <div class="d-flex justify-content-center mb-3">
        <x-datatable.buttons.action-button-mk2 type="danger"
            icon="trash"
            wire:click="prepareDeleteUser({{ $user->id }})" />
    </div>




    <x-modals.confirm-modal-mk2 id="modal-delete-user" type="danger"
        title="{{ __('modals/delete-modal.delete_user') }}"
        message="{{ __('modals/delete-modal.delete_confirmation') }}"
        submit-text="{{ __('modals/delete-modal.delete_user_button') }}" wire-confirm="proceedDeletion()"
        wire-cancel="cancelDeletion()" />

</section>
