@php
    $id = $order->id;
@endphp

<div class="btn-group d-flex justify-content-center">

    <a href="{{ route('admin.orders.view', $id) }}" class="btn btn-outline-primary">
        <i class="bi bi-eye" aria-hidden="true"> </i>
    </a>

    @if ($order->canArchive())
        <x-datatable.buttons.action-button
            action-class="delete-order"
            :data-id="$id"
            modal-id="modal-delete-order"
            icon="archive"
            type="danger"
        />
    @endif

</div>
