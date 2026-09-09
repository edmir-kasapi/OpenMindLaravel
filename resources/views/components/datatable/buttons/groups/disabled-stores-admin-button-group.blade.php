<div class="btn-group d-flex justify-content-center">

    <x-datatable.buttons.action-button
        action-class="reinstate-store"
        :data-id="$id"
        modal-id="modal-reinstate-store"
        icon="arrow-clockwise"
        type="success"
    />

    <x-datatable.buttons.action-button
        action-class="force-delete-store"
        :data-id="$id"
        modal-id="modal-force-delete-store"
        icon="x-octagon-fill"
        type="danger"
    />

</div>
