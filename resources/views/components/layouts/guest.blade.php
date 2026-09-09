<!DOCTYPE html>
<html lang="en" data-theme="lofi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - OpenMind' : 'OpenMind' }}</title>
    <link rel="preconnect" href="<https://fonts.bunny.net>">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-base-200 font-sans">
    <nav class="navbar bg-base-100">
        <div class="navbar-start">
            <x-app-title/>
        </div>



        <div class="navbar-end gap-2">
            <x-lang.guest-dropdown/>
            <a href="{{ route("login")}}" class="btn btn-ghost btn-sm">{{ __("welcome.sign_in")}}</a>
            <a href="{{ route("register")}}" class="btn btn-primary btn-sm">{{ __("welcome.sign_up")}}</a>
        </div>


    </nav>

    <main class="flex-1 container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <footer class="footer footer-center bg-base-200 text-base-content p-10">
    <nav class="grid grid-flow-col gap-4">
        <a href="{{ route("about")}}" class="link link-hover">{{ __("welcome.about_us")}}</a>
        <a href="{{ route("contact")}}" class="link link-hover">{{ __("welcome.contact")}}</a>
    </nav>

    <aside>
        <p>© {{ date('Y') }} OpenMind. {{ __("welcome.all_rights_reserved")}}</p>
    </aside>
</footer>
</body>

@if (session('success'))
    <div class="toast toast-top toast-center">
        <div class="alert alert-success animate-fade-out">
            <svg xmlns="<http://www.w3.org/2000/svg>" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif
