<!--begin::Add User Modal-->
<div class="modal fade" id="modal-add-user" tabindex="-1" aria-labelledby="modal-add-user-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.user.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-user-label">{{ __('modals/user-modal.add_user') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('common.close') }}"></button>
                </div>
                <div class="modal-body">
                    <section>

                        @error('name')
                            <div class="label mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="form-group">
                            <label class="form-label">{{ __('modals/user-modal.username') }}</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="{{ __('modals/user-modal.username_placeholder') }}"
                                required
                                value="{{ old('name') }}">
                        </div>

                        @error('email')
                            <div class="label mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="form-group mt-3">
                            <label class="form-label">{{ __('modals/user-modal.email') }}</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="{{ __('modals/user-modal.email_placeholder') }}"
                                required
                                value="{{ old('email') }}">
                        </div>

                        @error('password')
                            <div class="label mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="form-group mt-3">
                            <label class="form-label">{{ __('modals/user-modal.password') }}</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label">{{ __('modals/user-modal.confirm_password') }}</label>
                            <input type="password" name="password confirmation" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label">{{ __('modals/user-modal.role') }}</label>
                            <select class="form-select" name="role" required>
                                <option selected disabled value="">{{ __('modals/user-modal.choose') }}</option>
                                <option value="1">{{ __('modals/user-modal.admin') }}</option>
                                <option value="2">{{ __('modals/user-modal.user') }}</option>
                                <option value="3">{{ __('modals/user-modal.store_operator') }}</option>
                            </select>
                        </div>

                    </section>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('modals/user-modal.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-primary">
                        {{ __('modals/user-modal.create_user') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Add User Modal-->
