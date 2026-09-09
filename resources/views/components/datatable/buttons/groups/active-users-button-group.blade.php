<div class="btn-group d-flex justify-content-center">

    <a href=" {{ route('admin.users.inspect', $id) }} " class="btn btn-outline-secondary">
        <i class="bi bi-pencil" aria-hidden="true"> </i>
    </a>

    <x-datatable.buttons.action-button
        action-class="delete-user"
        :data-id="$id"
        modal-id="modal-delete-user"
        icon="clipboard2-x"
        type="danger"
    />

</div>
