<div class="btn-group d-flex justify-content-center">

    <a href="{{ route('operator.stores.edit', $store->id) }}" class="btn btn-outline-secondary">
        <i class="bi bi-pencil" aria-hidden="true"> </i>
    </a>

    @if ($store->is_approved)
        <a href="{{ route('operator.stores.api-keys', $store->id) }}" class="btn btn-outline-primary">
            <i class="bi bi-key" aria-hidden="true"> </i>
        </a>
    @endif

    <x-datatable.buttons.action-button
        action-class="disable-store"
        :data-id="$store->id"
        modal-id="modal-disable-store"
        icon="x-lg"
        type="danger"
    />

</div>
