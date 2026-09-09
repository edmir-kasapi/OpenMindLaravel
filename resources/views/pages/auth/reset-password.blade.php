<x-layouts.guest>

    <x-slot:title>
        Reset Password
    </x-slot:title>

    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col">
            <div class="card w-96 bg-base-100">
                <div class="card-body">
                    <h1 class="text 3xl font-bolt text-center">You can now Reset your password.</h1>
                    <h1 class="text 3xl font-bolt text-center mb-6">Fill the fields below.</h1>

                    <form action="/reset-password" method="post">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <label class="floating-label mb-6">
                            <input type="email" name="email" palceholder="Enter your email..."
                                value="{{ old('email') }}"
                                class="input input-bordered @error('email') input-error @enderror" required>
                            <span>Email</span>
                        </label>
                        @error('email')
                            <div class="label mt-1 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <label class="floating-label mb-6">
                            <input type="password" name="password" palceholder="Enter your password..."
                                class="input input-bordered @error('email') input-error @enderror" required>
                            <span>Password</span>
                        </label>
                        @error('password')
                            <div class="label mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <label class="floating-label mb-6">
                            <input type="password" name="password confirmation" palceholder="Confirm your password..."
                                class="input input-bordered @error('email') input-error @enderror" required>
                            <span>Confirm Password</span>
                        </label>

                        <div class="form-control mt-8">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                Reset Password
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layouts.guest>
