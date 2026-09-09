<?php

use Livewire\Component;
use App\Models\User;
use App\Http\Requests\Admin\Users\AdminCreateUserRequest;
use Illuminate\Validation\ValidationException;
use App\Services\Auth\RegistrationService;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?int $role = null;

    protected function rules(): array
    {
        return (new AdminCreateUserRequest())->rules();
    }

    public function store(RegistrationService $registrationService)
    {
        $validated = $this->validate();

        $registrationService->register($validated);

        $this->dispatch('reload-users-table');
            $this->dispatch(
            'show-success-message',
            message: 'User created successfully');

        $this->reset();
        $this->dispatch('close-modal');
    }

    public function exception($e, $stopPropagation)
    {
        if($e instanceof ValidationException)
        {
            $stopPropagation();
        }
    }
};
?>

<!--begin::Add User Modal-->
<div wire:ignore.self class="modal fade" id="modal-add-user" tabindex="-1" aria-labelledby="modal-add-user-label" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit="store">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-user-label">{{ __('modals/user-modal.add_user') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('common.close') }}"></button>
                </div>
                <div class="modal-body">
                    <section>



                        <div class="form-group">
                            <label class="form-label @error('name') text-danger @enderror ">{{ __('modals/user-modal.username') }}</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="{{ __('modals/user-modal.username_placeholder') }}" required
                                >
                        </div>
                        @error('name')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                        @enderror



                        <div class="form-group mt-3">
                            <label class="form-label @error('email') text-danger @enderror">{{ __('modals/user-modal.email') }}</label>
                            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ __('modals/user-modal.email_placeholder') }}" required
                                >
                        </div>
                        @error('email')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                        @enderror



                        <div class="form-group mt-3">
                            <label class="form-label @error('password') text-danger @enderror">{{ __('modals/user-modal.password') }}</label>
                            <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" required>
                        </div>
                        @error('password')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="form-group mt-3">
                            <label class="form-label">{{ __('modals/user-modal.confirm_password') }}</label>
                            <input type="password" wire:model="password_confirmation" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label @error('role') text-danger @enderror">{{ __('modals/user-modal.role') }}</label>
                            <select class="form-select @error('role') is-invalid @enderror" wire:model="role" required>
                                <option selected disabled value="">{{ __('modals/user-modal.choose') }}</option>
                                <option value="1">{{ __('modals/user-modal.admin') }}</option>
                                <option value="2">{{ __('modals/user-modal.user') }}</option>
                                <option value="3">{{ __('modals/user-modal.store_operator') }}</option>
                            </select>
                        </div>
                        @error('role')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                        @enderror

                    </section>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('modals/user-modal.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-primary" >
                        {{ __('modals/user-modal.create_user') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<!--end::Add User Modal-->


