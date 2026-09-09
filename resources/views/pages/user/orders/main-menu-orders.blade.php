<x-layouts.app>

    <x-slot:title>
        {{ __('orders\orders-user-view.title') }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4"> {{ __('orders\orders-user-view.your_orders') }}</h1>

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
                                        <h3 class="card-title"> {{ __('orders\orders-user-view.orders_list') }}</h3>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-3">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card Header-->
                            <!--begin::Card Body-->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle m-0" id="user-orders-table" role="table">

                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('orders\orders-user-view.id') }}</th>
                                                <th scope="col">{{ __('orders\orders-user-view.product') }}</th>
                                                <th scope="col">{{ __('orders\orders-user-view.quantity') }}</th>
                                                <th scope="col">{{ __('orders\orders-user-view.address') }}</th>
                                                <th scope="col">{{ __('orders\orders-user-view.total_price') }}</th>
                                                <th scope="col">{{ __('orders\orders-user-view.date_issued') }}</th>
                                                <th scope="col">{{ __('orders\orders-user-view.order_status') }}</th>
                                                <th scope="col">{{ __('orders\orders-user-view.payment_status') }}</th>
                                                <th scope="col">{{ __('orders\orders-user-view.shipment_status') }}</th>
                                                <th class="text-end" scope="col">{{ __('orders\orders-user-view.actions') }}</th>
                                            </tr>
                                            <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col">
                                                    <select class="form-control" id="order-status-filter" name="order_status_id">
                                                        <option value="">Any</option>
                                                        <option value="1">
                                                            Pending</option>
                                                        <option value="2">
                                                            Confirmed</option>
                                                        <option value="3">
                                                            Cancelled</option>
                                                        <option value="4">
                                                            Completed</option>
                                                    </select>
                                                </th>
                                                <th scope="col">
                                                    <select class="form-control" id="payment-status-filter" name="payment_status_id">
                                                        <option value="">Any</option>
                                                        <option value="1">
                                                            Unpaid</option>
                                                        <option value="2">
                                                            Paid</option>
                                                        <option value="3">
                                                            Refund Pending</option>
                                                        <option value="4">
                                                            Refunded</option>
                                                        <option value="5">
                                                            Partially Refunded</option>
                                                        <option value="6">
                                                            failed</option>
                                                    </select>
                                                </th>
                                                <th scope="col">
                                                    <select class="form-control" id="shipment-status-filter" name="shipment_status_id">
                                                        <option value="">Any</option>
                                                        <option value="1">
                                                            Not Shipped</option>
                                                        <option value="2">
                                                            Packed</option>
                                                        <option value="3">
                                                            Shipped</option>
                                                        <option value="4">
                                                            Delivered</option>
                                                        <option value="5">
                                                            Returned</option>
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

    <x-modals.danger-modal
        id="modal-delete-order"
        title="{{ __('modals\delete-order-modal.title') }}"
        message="{{ __('modals\delete-order-modal.message') }}"
        form-id="user-delete-order-form"
        submit-text="{{ __('modals\delete-order-modal.confirm_order_cancellation') }}"
        method='DELETE'
    />

    <x-modals.danger-modal
        id="modal-return-order"
        title="Return Order"
        message="Are you sure you want to return this order? The shipment will be turned back. THis action cannot be undone."
        form-id="user-return-order-form"
        submit-text="Confirm Return"
        method='POST'
    />

    <x-modals.warning-modal
        id="modal-request-refund"
        title="request Refund"
        message="Are you sure you want to request a refund? Your request for refund will be sent to the staff."
        form-id="user-request-refund-form"
        submit-text="Confirm Refund"
        method='POST'
    />

    <div id="user-orders-config"
        data-orders-url="{{ route('user.orders') }}"
        data-delete-url="{{ url('user/orders/delete') }}"
        data-refund-url="{{ url('user/orders/refund') }}"
        data-return-url="{{ url('user/orders/return') }}"
        >

    </div>

</x-layouts.app>
