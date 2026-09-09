<x-layouts.guest>

    <x-slot:title>
        {{ __('auth/register.register') }}
    </x-slot:title>

    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col">
            <div class="card w-96 bg-base-100">
                <div class="card-body">
                    <h1 class="text 3xl font-bold text-center mb-6">{{ __('auth/register.create_account') }}</h1>

                    <form action="{{ route('register') }}" method="post">
                        @csrf

                        <label class="floating-label mb-6">
                                <input type="text"
                                       name="name"
                                       placeholder="{{ __('auth/register.enter_your_name') }}"
                                       value="{{ old('name') }}"
                                       class="input input-bordered @error('name') input-error @enderror"
                                       required>
                                <span>{{ __('auth/register.name') }}</span>
                        </label>
                        @error('name')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror


                        <label class="floating-label mb-6">
                                <input type="email"
                                       name="email"
                                       placeholder="{{ __('auth/register.enter_your_email') }}"
                                       value="{{ old('email') }}"
                                       class="input input-bordered @error('email') input-error @enderror"
                                       required>
                                <span>{{ __('auth/register.email') }}</span>
                        </label>
                        @error('email')
                            <div class="label mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <label class="floating-label mb-6">
                                <input type="password"
                                       name="password"
                                       placeholder="{{ __('auth/register.enter_your_password') }}"
                                       class="input input-bordered @error('email') input-error @enderror"
                                       required>
                                <span>{{ __('auth/register.password') }}</span>
                        </label>
                        @error('password')
                            <div class="label mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <label class="floating-label mb-6">
                                <input type="password"
                                       name="password confirmation"
                                       placeholder="{{ __('auth/register.confirm_your_password') }}"
                                       class="input input-bordered @error('email') input-error @enderror"
                                       required>
                                <span>{{ __('auth/register.confirm_password') }}</span>
                        </label>


                        <div calss="form-control mt-8">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                Register
                            </button>
                        </div>

                    </form>

                    <div class="divider">{{ __('auth/register.or') }}</div>
                    <p class="text-center text -sm">
                        {{ __('auth/register.already_have_account') }}
                        <a href="{{ route('login') }}">
                           <u> {{ __('auth/register.sign_in') }} </u>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>



</x-layouts.guest>
