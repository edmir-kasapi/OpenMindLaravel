<x-layouts.app>

    <x-slot:title>
        {{ __('user/profile.title_profile_user') }}
    </x-slot:title>

    @php
        $user = auth()->user();
    @endphp

    <main class="app-main" id="main" tabindex="-1">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="mb-0 fs-3">{{ __('user/profile.your_profile') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content mt-2">
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Profile sidebar -->
                    <div class="col-md-3">
                        <!-- About card -->
                        <div class="card">

                            <livewire:components.profile.profile-card :user="$user" />

                        </div>

                        <a href="{{ route('user.home') }}">
                            <button class="btn btn-dark mt-3 w-100 text-center"> {{ __('user/profile.back') }}</button>
                        </a>

                    </div>

                    <!-- Tabbed content -->
                    <div class="col-md-6 mx-4">
                        <div class="card">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="profile-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="activity-tab" data-bs-toggle="tab"
                                            data-bs-target="#activity" type="button" role="tab"
                                            aria-selected="true">
                                            {{ __('user/profile.primary_credentials') }}
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="timeline-tab" data-bs-toggle="tab"
                                            data-bs-target="#timeline" type="button" role="tab"
                                            aria-selected="false" tabindex="-1">
                                            {{ __('user/profile.profile_picture') }}
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                            data-bs-target="#settings" type="button" role="tab"
                                            aria-selected="false" tabindex="-1">
                                            {{ __('user/profile.reset_password') }}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- Activity tab -->
                                    <div class="tab-pane fade show active" id="activity" role="tabpanel"
                                        aria-labelledby="activity-tab">

                                        <livewire:forms.edit.user-name-email :user="$user" />

                                    </div>

                                    <!-- Timeline tab -->
                                    <div class="tab-pane fade" id="timeline" role="tabpanel"
                                        aria-labelledby="timeline-tab">

                                        <livewire:forms.edit.user-profile-picture :user="$user" />

                                        <h5 class="text-center mt-2"> {{ __('user/profile.profile_picture_hint') }} </h5>

                                    </div>

                                    <!-- Settings tab -->
                                    <div class="tab-pane fade" id="settings" role="tabpanel"
                                        aria-labelledby="settings-tab">

                                        <livewire:forms.edit.user-password-reset :user="$user" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-layouts.app>
