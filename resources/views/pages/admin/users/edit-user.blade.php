<x-layouts.app>

    <x-slot:title>
        {{ __('admin/edit-user.page_title') }}
    </x-slot:title>

    <main class="app-main" id="main" tabindex="-1">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="mb-0 fs-3">{{ __('admin/edit-user.inspecting_user') }} #{{ $user->id }}</h1>
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

                        <a href="{{ route('admin.users') }}">
                            <button class="btn btn-dark mt-3 w-100 text-center"> {{ __('user/profile.back') }}
                            </button>
                        </a>

                        <div id="users-config" data-delete-url="{{ url('admin/user/delete') }}">
                        </div>

                        <!-- About details -->
                        <!--
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">About</h3>
                            </div>
                            <div class="card-body small">
                                <p class="fw-semibold mb-1">
                                    <i class="bi bi-mortarboard me-1 text-secondary" aria-hidden="true"></i>
                                    Education
                                </p>
                                <p class="text-secondary mb-3">
                                    BS in Computer Science from the University of Tennessee at Knoxville
                                </p>
                                <p class="fw-semibold mb-1">
                                    <i class="bi bi-geo-alt me-1 text-secondary" aria-hidden="true"></i>
                                    Location
                                </p>
                                <p class="text-secondary mb-3">Malibu, California</p>
                                <p class="fw-semibold mb-1">
                                    <i class="bi bi-tags me-1 text-secondary" aria-hidden="true"></i>
                                    Skills
                                </p>
                                <p class="mb-3">
                                    <span class="badge text-bg-secondary me-1">UI/UX</span>
                                    <span class="badge text-bg-secondary me-1">Figma</span>
                                    <span class="badge text-bg-secondary me-1">Design Systems</span>
                                    <span class="badge text-bg-secondary">Research</span>
                                </p>
                                <p class="fw-semibold mb-1">
                                    <i class="bi bi-pencil-square me-1 text-secondary" aria-hidden="true"></i>
                                    Notes
                                </p>
                                <p class="text-secondary mb-0">
                                    Lorem ipsum represents a long-held tradition for designers, typographers and
                                    the like.
                                </p>
                            </div>
                        </div>
                        -->
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

                                        <h5 class="text-center mt-2"> {{ __('user/profile.profile_picture_hint') }}
                                        </h5>

                                    </div>

                                    <!-- Settings tab -->
                                    <div class="tab-pane fade" id="settings" role="tabpanel"
                                        aria-labelledby="settings-tab">

                                        <livewire:forms.edit.user-password-reset :user="$user" />

                                        <!--
                                        <form class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-first"> First name </label>
                                                <input type="text" class="form-control" id="profile-first" value="Jane">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-last"> Last name </label>
                                                <input type="text" class="form-control" id="profile-last" value="Doe">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-email"> Email </label>
                                                <input type="email" class="form-control" id="profile-email" value="jane@example.com">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-role"> Role </label>
                                                <input type="text" class="form-control" id="profile-role" value="Product Designer">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="profile-bio">Bio</label>
                                                <textarea class="form-control" id="profile-bio" rows="4">Designer with a soft spot for design tokens and accessibility.</textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                <button type="reset" class="btn btn-outline-secondary ms-1">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                        -->

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
