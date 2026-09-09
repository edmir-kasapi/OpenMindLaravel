<x-layouts.app>

    <x-slot:title>
        {{ __('orders\orders-admin-trashed.title') }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">
        {{ __('orders\orders-admin-trashed.manage_deleted_orders') }}</h1>

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
                                        <h3 class="card-title">{{ __('orders\orders-admin-trashed.orders_list') }}</h3>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-3">
                                            <a href="{{ route('admin.orders') }}">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="">
                                                    <i class="bi bi-cart me-1" aria-hidden="true"> </i>
                                                    {{ __('orders\orders-admin-trashed.active_orders') }}
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
                                    <table class="table table-hover align-middle m-0" id="admin-trashed-orders-table"
                                        role="table">

                                        <thead>

                                            <tr>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.id') }}</th>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.user') }}</th>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.product') }}</th>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.quantity') }}</th>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.address') }}</th>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.total_price') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('orders\orders-admin-trashed.date_cancelled') }}</th>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.order_status') }}</th>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.payment_status') }}</th>
                                                <th scope="col">{{ __('orders\orders-admin-trashed.shipment_status') }}</th>
                                                <th class="text-end" scope="col">
                                                    {{ __('orders\orders-admin-trashed.actions') }}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col">
                                                    <select class="form-control" id="order-status-filter" name="order_status_id">
                                                        <option value="">{{ __('orders\orders-admin-view.any') }}</option>
                                                        <option value="1">
                                                            {{ __('orders\orders-admin-view.pending') }}</option>
                                                        <option value="2">
                                                            {{ __('orders\orders-admin-view.confirmed') }}</option>
                                                        <option value="3">
                                                            {{ __('orders\orders-admin-view.cancelled') }}</option>
                                                        <option value="4">
                                                            {{ __('orders\orders-admin-view.completed') }}</option>
                                                    </select>
                                                </th>
                                                <th scope="col">
                                                    <select class="form-control" id="payment-status-filter" name="payment_status_id">
                                                        <option value="">{{ __('orders\orders-admin-view.any') }}</option>
                                                        <option value="1">
                                                            {{ __('orders\orders-admin-view.unpaid') }}</option>
                                                        <option value="2">
                                                            {{ __('orders\orders-admin-view.paid') }}</option>
                                                        <option value="3">
                                                            {{ __('orders\orders-admin-view.refund_pending') }}</option>
                                                        <option value="4">
                                                            {{ __('orders\orders-admin-view.refunded') }}</option>
                                                        <option value="5">
                                                            {{ __('orders\orders-admin-view.partially_refunded') }}</option>
                                                        <option value="6">
                                                            {{ __('orders\orders-admin-view.failed') }}</option>
                                                    </select>
                                                </th>
                                                <th scope="col">
                                                    <select class="form-control" id="shipment-status-filter" name="shipment_status_id">
                                                        <option value="">{{ __('orders\orders-admin-view.actions') }}</option>
                                                        <option value="1">
                                                            {{ __('orders\orders-admin-view.not_shipped') }}</option>
                                                        <option value="2">
                                                            {{ __('orders\orders-admin-view.packed') }}</option>
                                                        <option value="3">
                                                            {{ __('orders\orders-admin-view.shipped') }}</option>
                                                        <option value="4">
                                                            {{ __('orders\orders-admin-view.delivered') }}</option>
                                                        <option value="5">
                                                            {{ __('orders\orders-admin-view.returned') }}</option>
                                                    </select>
                                                </th>
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

    <x-modals.success-modal
        id="modal-restore-order"
        title="{{ __('modals\restore-order-modal.title')}}"
        message="{{ __('modals\restore-order-modal.message')}}"
        form-id="restore-order-form"
        submit-text="{{ __('modals\restore-order-modal.confirm_reinstatement')}}"
        method='POST'
    />
    <x-modals.danger-modal
        id="modal-force-delete-order"
        title="{{ __('modals\force-delete-order-modal.title') }}"
        message="{{ __('modals\force-delete-order-modal.message') }}"
        form-id="force-delete-order-form"
        submit-text="{{ __('modals\force-delete-order-modal.force_delete') }}"
        method='DELETE'
    />


    <div id="admin-trashed-orders-config" data-orders-url="{{ route('admin.trashed.orders') }}"
        data-restore-url="{{ url('admin/orders/restore') }}"
        data-force-delete-url="{{ url('admin/orders/force-delete') }}">
    </div>




</x-layouts.app>
