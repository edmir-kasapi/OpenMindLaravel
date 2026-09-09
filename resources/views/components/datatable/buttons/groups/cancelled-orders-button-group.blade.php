<div class="btn-group d-flex justify-content-center">

    <x-datatable.buttons.action-button
        action-class="restore-order"
        :data-id="$id"
        modal-id="modal-restore-order"
        icon="arrow-return-left"
        type="success"
    />

    <x-datatable.buttons.action-button
        action-class="force-delete-order"
        :data-id="$id"
        modal-id="modal-force-delete-order"
        icon="database-x"
        type="danger"
    />

</div>
