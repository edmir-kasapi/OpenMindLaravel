<div class="btn-group d-flex justify-content-center">

    <x-datatable.buttons.action-button
        action-class="restore-product"
        :data-id="$id"
        modal-id="modal-restore-product"
        icon="recycle"
        type="success"
    />

    <x-datatable.buttons.action-button
        action-class="force-delete-product"
        :data-id="$id"
        modal-id="modal-force-delete-product"
        icon="eraser"
        type="danger"
    />

</div>
