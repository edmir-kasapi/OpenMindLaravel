<x-layouts.guest>

    <x-slot:title>
        {{ __('auth/forgot-password.forgot_password') }}
    </x-slot:title>



    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col">
            <div class="card w-96 bg-base-100">
                <div class="card-body">
                    <h1 class="text 3xl font-bolt text-center">{{ __('auth/forgot-password.forgot_password_message') }}</h1>
                    <h1 class="text 3xl font-bolt text-center mb-6">{{ __('auth/forgot-password.request_password_reset') }}</h1>

                    <form action="{{ route('password.email') }}" method="post">
                        @csrf

                        <label class="floating-label mb-6">
                            <input type="email" name="email" placeholder="{{ __('auth/forgot-password.enter_your_email') }}"
                                value="{{ old('email') }}"
                                class="input input-bordered @error('email') input-error @enderror" required>
                            <span>{{ __('auth/forgot-password.email') }}</span>
                        </label>
                        @error('email')
                            <div class="label mt-1 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="form-control mt-8">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                {{ __('auth/forgot-password.send_request') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layouts.guest>
