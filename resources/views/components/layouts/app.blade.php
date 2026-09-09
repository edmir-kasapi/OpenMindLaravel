<!DOCTYPE html>
<html lang="en" data-theme="lofi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - OpenMind' : 'OpenMind' }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Apex charts JS left it here so it can load before the chart scripts try to run --}}
    @apexchartsScripts
</head>

<body class="layout-fixed min-h-screen flex flex-col bg-base-200 font-sans">

    @php
        $authUser = auth()->user();
        $isAdmin = $authUser->hasRole(['Admin']);
        $isUser = $authUser->hasRole(['User']);
        $isOperator = $authUser->hasRole(['Store Operator']);
    @endphp

    @if ($authUser->hasRole(['Admin', 'Store Operator']))
        <x-sidebar.sidebar>

            @if ($isAdmin)
                <x-slot:title>
                    {{ __('app.admin_dashboard') }}
                </x-slot:title>

                <x-sidebar.nav-link href="{{ route('admin.dashboard') }}" :active="Request::routeIs('admin.dashboard')">
                    📊{{ __('app.dashboard') }}
                </x-sidebar.nav-link>
                <x-sidebar.nav-link href="{{ route('admin.users') }}" :active="Request::routeIs(['admin.users', 'admin.users.*', 'admin.trashed.users'])">
                    👥 {{ __('app.users') }}
                </x-sidebar.nav-link>
                <x-sidebar.nav-link href="{{ route('admin.products') }}" :active="Request::routeIs(['admin.products', 'admin.products.*', 'admin.trashed.products'])">
                    📦 {{ __('app.inventory') }}
                </x-sidebar.nav-link>
                <x-sidebar.nav-link href="{{ route('admin.orders') }}" :active="Request::routeIs(['admin.orders', 'admin.orders.*', 'admin.trashed.orders'])">
                    📋 {{ __('app.orders') }}
                </x-sidebar.nav-link>
                <x-sidebar.nav-link href="{{ route('admin.stores') }}" :active="Request::routeIs(['admin.stores', 'admin.stores.*', 'admin.trashed.stores'])">
                    🏪{{ __('app.stores') }}
                </x-sidebar.nav-link>
            @endif

            @if ($isOperator)
                <x-slot:title>
                    {{ __('app.operator_dashboard') }}
                </x-slot:title>

                <x-sidebar.nav-link href="{{ route('operator.dashboard') }}" :active="Request::routeIs('operator.dashboard')">
                    📊{{ __('app.dashboard') }}
                </x-sidebar.nav-link>
                <x-sidebar.nav-link href="{{ route('operator.stores') }}" :active="Request::routeIs(['operator.stores', 'operator.stores.*'])">
                    🏪{{ __('app.stores') }}
                </x-sidebar.nav-link>
            @endif

        </x-sidebar.sidebar>

        <div class="flex-1 pl-64 flex flex-col">
        @else
            <div class="flex-1 flex flex-col">

    @endif

    <!-- Top Navbar -->
    <nav class="app-header navbar navbar-expand bg-base-100">
        <x-app-title />

        <livewire:components.sidebar.sidebar-user-profile :user="$authUser" :is-user="$isUser" />

        <x-lang.app-dropdown />

        @if ($isUser)
            <x-navbar.navbar-button href="{{ route('user.products') }}" :active="Request::routeIs('user.products')">
                <i class="bi bi-handbag">{{ __('app.products') }}</i>
            </x-navbar.navbar-button>

            <x-navbar.navbar-button href="{{ route('user.orders') }}" :active="Request::routeIs('user.orders')">
                <i class="bi bi-view-list">{{ __('app.orders') }}</i>
            </x-navbar.navbar-button>
        @endif

    </nav>

    <!-- Dynamic Body Content -->
    <main class="app-main flex-1 container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs">
        <div>
            <!--
            <p>© {{ date('Y') }} Chirper - Built with Laravel and ❤️</p>
            -->
        </div>
    </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>

    @livewireScripts
</body>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast('success', @json(session('success')));
        });
    </script>
    {{ session()->forget('success') }}
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast('error', @json(session('error')));
        });
    </script>
    {{ session()->forget('error') }}
@endif

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    <div id="success-toast" class="toast text-bg-success border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body flex-grow-1">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Success</strong>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>

                <div id="success-toast-text" style="white-space: pre-line;" class="mt-2">
                    {{ session('success') }}
                </div>

            </div>

        </div>
    </div>
</div>



<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">

    <div id="error-toast" class="toast text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">

        <div class="toast-body">

            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong>Error</strong>
                </div>

                <button type="button" class="btn-close btn-close-white ms-3" data-bs-dismiss="toast"
                    aria-label="Close">
                </button>
            </div>

            <div id="error-toast-text" style="white-space: pre-line;" class="mt-2">
                {{ session('error') }}
            </div>

        </div>

    </div>
</div>
