<div class="btn-group d-flex justify-content-center">

    <x-datatable.buttons.action-button
        action-class="restore-user"
        :data-id="$id"
        modal-id="modal-restore-user"
        icon="arrow-repeat"
        type="success"
    />

    <x-datatable.buttons.action-button
        action-class="force-delete-user"
        :data-id="$id"
        modal-id="modal-force-delete-user"
        icon="trash"
        type="danger"
    />

</div>
