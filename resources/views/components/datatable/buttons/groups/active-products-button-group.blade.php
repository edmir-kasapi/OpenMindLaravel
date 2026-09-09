<div class="btn-group d-flex justify-content-center">

    <a href=" {{ route('admin.products.inspect', $id) }} "class="btn btn-outline-secondary">
        <i class="bi bi-pen" aria-hidden="true"> </i>
    </a>

    <x-datatable.buttons.action-button
        action-class="delete-product"
        :data-id="$id"
        modal-id="modal-delete-product"
        icon="journal-minus"
        type="danger"
    />

</div>
