<x-layouts.app>

    <x-slot:title>
        {{ __('auth/verify-email.title') }}
    </x-slot:title>

    <h1 class="text-center">
        {{ __('auth/verify-email.email_sent') }}
    </h1>

    <h3 class="text-center">
        {{ __('auth/verify-email.check_inbox') }}
    </h3>

    <h4 class="text-center mt-5">
        {{ __('auth/verify-email.missing_email') }}

        <form action="{{ route('verification.sent') }}" method="POST">
            @csrf
            <input type="submit" class="text-primary" value="{{ __('auth/verify-email.resend') }}">
        </form>
    </h4>



</x-layouts.app>
