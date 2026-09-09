<x-layouts.app>

    <x-slot:title>
        {{ __('stores\api-keys.access_token_created') }}
    </x-slot:title>

    @php
        $operator = auth()->user();
    @endphp

    <main class="app-main" id="main" tabindex="-1">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="mb-0 fs-3">{{ __('stores\api-keys.access_token') }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content mt-3">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <div class="card border-success">

                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-check-circle me-2"></i>
                                    {{ __('stores\api-keys.access_token_created') }}
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="alert alert-warning d-flex align-items-start">
                                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>

                                    <div>
                                        <strong>{{ __('stores\api-keys.save_token_now') }}</strong>
                                        <p class="mb-0 mt-1">
                                            {{ __('stores\api-keys.token_displayed_once') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ __('stores\api-keys.store_operator') }}
                                    </label>

                                    <div class="form-control bg-light">
                                        {{ $operator->name }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ __('stores\api-keys.access_token') }}
                                    </label>

                                    <div class="input-group">
                                        <input
                                            type="text"
                                            id="access-token"
                                            class="form-control font-monospace"
                                            value="{{ $token }}"
                                            readonly
                                        >

                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            id="copy-token"

                                        >
                                            <i class="bi bi-clipboard me-1"></i>
                                            {{ __('stores\api-keys.copy') }}
                                        </button>
                                    </div>
                                </div>

                                <div id="copy-success" class="alert alert-success d-none">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{ __('stores\api-keys.token_copied') }}
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">
                                    <a
                                        href="{{ route('operator.stores.api-keys', $store->id) }}"
                                        class="btn btn-outline-secondary"
                                    >
                                        <i class="bi bi-arrow-left me-1"></i>
                                        {{ __('stores\api-keys.back') }}
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

</x-layouts.app>


