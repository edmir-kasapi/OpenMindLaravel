<x-layouts.app>

    <x-slot:title>
        {{ __('orders\orders-admin-view.view_order') }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">
        {{ __('orders\orders-admin-view.viewing_order') }} #{{ $order->id }}
    </h1>

    <div class="w-50 mx-auto">
        <div class="card card-primary card-outline mb-4">

            <div class="card-header d-flex gap-2">
                <h3 class="card-title">
                    <i class="bi bi-receipt me-2"></i>
                    {{ __('orders\orders-admin-view.order') }} #{{ $order->id }} -
                </h3>

                <span class="text-muted">
                    {{ $order->created_at->format('d M Y H:i') }}
                </span>
            </div>

            <div class="card-body">

                <div class="row text-center">

                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3">
                            <small class="text-muted d-block">{{ __('orders\orders-admin-view.order_status') }}</small>
                            <hr>
                            <x-datatable.badges.order-status-badge :status="$order->getOrderStatus()" />
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3">
                            <small class="text-muted d-block">{{ __('orders\orders-admin-view.payment_status') }}</small>
                            <hr>
                            <x-datatable.badges.payment-status-badge :status="$order->getPaymentStatus()" />
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3">
                            <small class="text-muted d-block">{{ __('orders\orders-admin-view.shipment_status') }}</small>
                            <hr>
                            <x-datatable.badges.shipment-status-badge :status="$order->getShipmentStatus()" />
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="row">

        <div class="col">

            <div class="card card-outline card-info w-50 ms-auto">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-box-seam me-2"></i>
                        {{ __('orders\orders-admin-view.order_information') }}
                    </h3>
                </div>

                <div class="card-body">

                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ __('orders\orders-admin-view.product') }}</span>
                        <input class="form-control" value="{{ $order->product->name }}" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ __('orders\orders-admin-view.quantity') }}</span>
                        <input class="form-control" value="{{ $order->quantity }}" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ __('orders\orders-admin-view.unit_price') }}</span>
                        <input class="form-control" value="${{ number_format($order->product->price, 2) }}" readonly>
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">{{ __('orders\orders-admin-view.total') }}</span>
                        <input class="form-control fw-bold text-success"
                            value="${{ number_format($order->total_price, 2) }}" readonly>
                    </div>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card card-outline card-info w-50">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-person me-2"></i>
                        {{ __('orders\orders-admin-view.customer_information') }}
                    </h3>
                </div>

                <div class="card-body">

                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ __('orders\orders-admin-view.customer') }}</span>
                        <input class="form-control" value="{{ $order->user->name }}" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ __('orders\orders-admin-view.email') }}</span>
                        <input class="form-control" value="{{ $order->user->email }}" readonly>
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">{{ __('orders\orders-admin-view.address') }}</span>

                        <textarea class="form-control" rows="3" readonly>{{ $order->address }}</textarea>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card mt-4 w-50 mx-auto">

        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-lightning-charge me-2"></i>
                {{ __('orders\orders-admin-view.actions') }}
            </h3>
        </div>

        <div class="card-body">

            <div class="d-flex flex-wrap gap-2 ">

                @if ($order->canConfirm())
                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>
                           {{ __('orders\orders-admin-view.confirm') }}
                        </button>
                    </form>
                @endif

                @if ($order->canPack())
                    <form action="{{ route('admin.orders.pack', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-box-seam me-1"></i>
                            {{ __('orders\orders-admin-view.pack_shipment') }}
                        </button>
                    </form>
                @endif

                @if ($order->canUnconfirm())
                    <form action="{{ route('admin.orders.unconfirm', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-arrow-left-circle me-1"></i>
                            {{ __('orders\orders-admin-view.undo_confirmation') }}
                        </button>
                    </form>
                @endif

                @if ($order->canShip())
                    <form action="{{ route('admin.orders.ship', $order->id) }}" method="post">
                        @csrf
                        <button class="btn btn-primary">
                            <i class="bi bi-truck me-1"></i>
                            {{ __('orders\orders-admin-view.ship') }}
                        </button>
                    </form>


                    <form action="{{ route('admin.orders.unpack', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-box-seam-fill me-1"></i>
                            {{ __('orders\orders-admin-view.undo_packing') }}
                        </button>
                    </form>
                @endif

                @if ($order->canDeliver())
                    <form action="{{ route('admin.orders.deliver', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-clipboard-check me-1"></i>
                            {{ __('orders\orders-admin-view.finish_delivery') }}
                        </button>
                    </form>

                    <form action="{{ route('admin.orders.unship', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-truck-flatbed me-1"></i>
                            {{ __('orders\orders-admin-view.undo_shipping') }}
                        </button>
                    </form>
                @endif

                @if ($order->canReturn())
                    <form action="{{ route('admin.orders.undeliver', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-unindent me-1"></i>
                            {{ __('orders\orders-admin-view.undo_delivery') }}
                        </button>
                    </form>
                @endif

                @if ($order->canCancel())
                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i>
                        {{ __('orders\orders-admin-view.cancel_order') }}
                        </button>
                    </form>
                @endif

                @if ($order->canReturn())
                    <form action="{{ route('admin.orders.return', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                        <i class="bi bi-truck me-1"></i>
                        <i class="bi bi-arrow-return-left me-1"></i>
                        {{ __('orders\orders-admin-view.return_order') }}
                        </button>
                    </form>
                @endif

                @if ($order->isRefundPending())
                    <form action="{{ route('admin.orders.refund.accept', $order->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            {{ __('orders\orders-admin-view.accept_refund') }}
                        </button>
                    </form>

                    <form action="{{ route('admin.orders.refund.reject', $order->id) }}" method="post">
                        @csrf
                        <button class="btn btn-danger">
                            <i class="bi bi-x-circle-fill me-1"></i>
                            {{ __('orders\orders-admin-view.reject_refund') }}
                        </button>
                    </form>
                @endif


                <button class="btn btn-dark">
                    <i class="bi bi-printer me-1"></i>
                    {{ __('orders\orders-admin-view.invoice') }}
                </button>

                @if ($order->canArchive())
                    <x-datatable.buttons.action-button
                        action-class="delete-order"
                        :data-id="$order->id"
                        :redirect="true"
                        modal-id="modal-delete-order"
                        icon="archive"
                        type="danger"
                    />
                @endif

            </div>

        </div>

        <x-modals.danger-modal
            id="modal-delete-order"
            title="{{ __('orders\orders-admin-view.archive_order') }}"
            message="{{ __('orders\orders-admin-view.archive_order_confirmation') }}"
            form-id="admin-delete-order-form"
            submit-text="{{ __('orders\orders-admin-view.archive') }}"
            method='DELETE'
        />

        <div id="admin-orders-config"
        data-orders-url="{{ route('admin.orders') }}"
        data-delete-url="{{ url('admin/orders/delete') }}"
        >
    </div>

</x-layouts.app>
