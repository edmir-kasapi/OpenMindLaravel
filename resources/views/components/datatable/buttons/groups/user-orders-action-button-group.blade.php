@php
    $id = $order->id;
    $orderStatus = $order->getOrderStatus();
    $paymentStatus = $order->getPaymentStatus();
    $shipmentStatus = $order->getShipmentStatus();
@endphp

<div class="btn-group d-flex justify-content-center">

    @if ($order->canRetry())
        <a href="{{ route('checkout.retry', $id) }}" class="btn btn-outline-success">
            <i class="bi bi-cash" aria-hidden="true"> </i>
        </a>
    @endif

    @if ($order->canCancel())
        <x-datatable.buttons.action-button
            action-class="delete-order"
            :data-id="$id"
            modal-id="modal-delete-order"
            icon="cart-x"
            type="danger"
        />
    @endif

    @if ($order->canReturn())
        <x-datatable.buttons.action-button
            action-class="return-order"
            :data-id="$id"
            modal-id="modal-return-order"
            icon="truck"
            type="danger"
        />
    @endif

    @if ($order->canRefund() && !$order->canCancel())
        <x-datatable.buttons.action-button
                action-class="request-refund"
                :data-id="$id"
                modal-id="modal-request-refund"
                icon="credit-card-fill"
                type="warning"
            />
    @endif

</div>
