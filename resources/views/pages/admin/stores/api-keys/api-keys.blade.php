<x-layouts.app>

    <x-slot:title>
       {{ __('stores\api-keys.api_keys') }} - {{ $store->name }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('stores\api-keys.api_keys_of_store') }} {{ $store->name }}</h1>

    <section class="w-75 mx-auto">

        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <!--begin::Card-->
                        <div class="card mb-4">
                            <!--begin::Card Header-->
                            <div class="card-header">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md-4">
                                        <h3 class="card-title">{{ __('stores\api-keys.api_keys_list') }}</h3>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-3">

                                            <a href="{{ route('admin.stores.revoked-api-keys', $store->id) }}">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal" data-bs-target="">
                                                    <i class="bi bi-key-fill me-1" aria-hidden="true"> </i>
                                                    {{ __('stores\api-keys.revoked_keys') }}
                                                </button>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card Header-->
                            <!--begin::Card Body-->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle m-0" id="admin-keys-table" role="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('stores\api-keys.name') }}</th>
                                                <th scope="col">{{ __('stores\api-keys.read_product') }}</th>
                                                <th scope="col">{{ __('stores\api-keys.read_collections') }}</th>
                                                <th scope="col">{{ __('stores\api-keys.date_created') }}</th>
                                                <th scope="col">{{ __('stores\api-keys.expiration_date') }}</th>
                                                <th scope="col">{{ __('stores\api-keys.last_used') }}</th>
                                                <th class="text-end" scope="col">{{ __('stores\api-keys.actions') }}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th class="text-end" scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!--end::Card Body-->
                            <!--begin::Card Footer-->

                        </div>
                        <!--end::Card Footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->

        </div>
        <!--end::Container-->
        </div>

    </section>


    <x-modals.danger-modal
        id="modal-revoke-token"
        title="{{ __('stores\api-keys.revoke_token') }}"
        message="{{ __('stores\api-keys.revoke_token_confirmation') }}"
        form-id="admin-revoke-token-form"
        submit-text="{{ __('stores\api-keys.revoke') }}"
        method='DELETE'
    />


    <div id="admin-keys-config"
        data-keys-url="{{ route('admin.stores.api-keys', $store->id) }}"
        data-revoke-url="{{ url('admin/stores/api-keys/revoke') }}"
        >
    </div>

</x-layouts.app>
