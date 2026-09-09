<x-layouts.guest>

    <x-slot:title>
        {{ __('auth/login.login') }}
    </x-slot:title>

    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col">
            <div class="card w-96 bg-base-100">
                <div class="card-body">
                    <h1 class="text 3xl font-bolt text-center mb-6">{{ __('auth/login.welcome_back') }}</h1>

                    <form action="{{ route('process-login') }}" method="post">
                        @csrf

                        <label class="floating-label mb-6">
                            <input type="email" name="email" placeholder="{{ __('auth/login.enter_your_email') }}"
                                value="{{ old('email') }}"
                                class="input input-bordered @error('email') input-error @enderror" required>
                            <span>{{ __('auth/login.email') }}</span>
                        </label>
                        @error('email')
                            <div class="label mt-1 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <label class="floating-label mb-6">
                            <input type="password" name="password" placeholder="{{ __('auth/login.enter_your_password') }}"
                                class="input input-bordered @error('email') input-error @enderror" required>
                            <span>{{ __('auth/login.password') }}</span>
                        </label>
                        @error('password')
                            <div class="label mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <div clas="form-control">
                            <label class="label cursor-pointer justify-start">
                                <input type="checkbox"
                                       name="remember"
                                       class="checkbox">
                                <span class="lable-text mt-2">{{ __('auth/login.remember_me') }}</span>
                            </label>
                        </div>

                        <div calss="form-control mt-8">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                               {{ __('auth/login.log_in') }}
                            </button>
                        </div>

                    </form>

                    <div class="divider"></div>
                    <p class="text-center text -sm">
                        {{ __('auth/login.forgot_password') }}
                        <a href="{{ route('password.request') }}">
                           <u> {{ __('auth/login.click_here') }} </u>
                        </a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
