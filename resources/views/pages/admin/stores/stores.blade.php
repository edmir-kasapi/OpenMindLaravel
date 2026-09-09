<x-layouts.app>

    <x-slot:title>
        {{ __('stores\stores.stores_admin') }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('stores\stores.manage_stores') }}</h1>

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
                                        <h3 class="card-title">{{ __('stores\stores.stores_list') }}</h3>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-3">

                                            <a href="{{ route('admin.trashed.stores') }}">
                                                <button type="button" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-shop-window me-1" aria-hidden="true"> </i>
                                                    {{ __('stores\stores.disabled_stores') }}
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
                                    <table class="table table-hover align-middle m-0" id="admin-stores-table" role="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('stores\stores.name') }}</th>
                                                <th scope="col">{{ __('stores\stores.operator') }}r</th>
                                                <th scope="col">{{ __('stores\stores.country') }}</th>
                                                <th scope="col">{{ __('stores\stores.address') }}</th>
                                                <th scope="col">{{ __('stores\stores.phone') }}</th>
                                                <th scope="col">{{ __('stores\stores.website') }}</th>
                                                <th scope="col">{{ __('stores\stores.date_registered') }}</th>
                                                <th scope="col">{{ __('stores\stores.approval_status') }}</th>
                                                <th class="text-end" scope="col">{{ __('stores\stores.actions') }}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col">
                                                    <select id="country-filter" name="country"
                                                        class="form-select tomselected ts-hidden-accessible"
                                                        required>
                                                        <option value=""> All </option>
                                                        <option value="Albania">
                                                            Albania </option>
                                                        <option value="United States">
                                                            United States </option>
                                                        <option value="United Kingdom">
                                                            United Kingdom </option>
                                                        <option value="Germany">
                                                            Germany </option>
                                                        <option value="France">
                                                            France </option>
                                                        <option value="Italy">
                                                            Italy </option>
                                                        <option value="Spain">
                                                            Spain </option>
                                                        <option value="Canada">
                                                            Canada </option>
                                                        <option value="Australia">
                                                            Australia </option>
                                                        <option value="Japan">
                                                            Japan </option>
                                                        <option value="China">
                                                            China </option>
                                                        <option value="South Korea">
                                                            South Korea </option>
                                                        <option value="Mexico">
                                                            Mexico </option>
                                                        <option value="Brazil">
                                                            Brazil </option>
                                                        <option value="Argentina">
                                                            Argentina </option>
                                                    </select>
                                                </th>
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
        id="modal-disable-store"
        title="{{ __('stores\stores.disable_store') }}"
        message="{{ __('stores\stores.disable_store_confirmation') }}"
        form-id="admin-disable-store-form"
        submit-text="{{ __('stores\stores.disable') }}"
        method='DELETE'
    />

    <div id="admin-stores-config"
        data-stores-url="{{ route('admin.stores') }}"
        data-delete-url="{{ url('admin/stores/delete') }}"
        >
    </div>

</x-layouts.app>
