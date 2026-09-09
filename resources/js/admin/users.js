import {
    stylePagination,
    styleInfo,
    styleSearch,
    styleLength
} from '../tablestyling.js';

import {
    showToast
} from '../toasts.js';


$(document).ready(function () {

    const config = $('#users-config');

    const usersUrl = config.data('users-url');
    const deleteUrl = config.data('delete-url');

    const table = $('#user-table').DataTable({
        serverSide: true,
        processing: true,
        titleRow: 0,
        ajax: {
            url: usersUrl,
            data: function(d) {
                d.role = $('#role-filter').val();
                d.status = $('#status-filter').val();
            }
        },
        columns: [{
            data: 'name',
            name: 'name'
        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'role',
            name: 'role_id',

        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'status',
            name: 'email_verified_at',
            orderable: false,
            searchable: false
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
        ],
        //Table styles for different elements
        initComplete: function () {
            const container = $(this.api().table().container());

            styleSearch(container);
            styleLength(container);
            stylePagination(container);
            styleInfo(container);
        },
        //This function is here to make sure the pagination does not lose the styling
        drawCallback: function () {
            const container = $(this.api().table().container());

            stylePagination(container);
            styleInfo(container);
        }

    });

    $(document).on('click', '.delete-user', function (e) {

        let userId = $(this).attr('data-id');
        let redirect = $(this).attr('data-redirect');

        $('#delete-user-form')
            .data('user-id', userId)
            .data('redirect', redirect);
    });

    $('#delete-user-form').on('submit', function (e) {

        e.preventDefault();

        let userId = $(this).data('user-id');

        if (userId) {

            $.ajax({
                url: `${deleteUrl}/${userId}`,
                method: 'DELETE',
                data: {
                    redirect: $('#delete-user-form').data('redirect')
                },
                success: function (response) {
                    if (response.status === 'success') {

                        if (response.redirect) {
                            window.location.href = response.redirect;
                            return;
                        }

                        showToast('success', response.message);
                        table.ajax.reload(null, false); //callback, boolean
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function (error) {
                    showToast('error', error.message);
                }
            })
        }

        const modalElement = document.getElementById('modal-delete-user');
        const modal = bootstrap.Modal.getInstance(modalElement);

        console.log(bootstrap);

        modal.hide();

    });


    $('#role-filter').on('change', function () {
        table.ajax.reload();
    });

    $('#status-filter').on('change', function () {
        table.ajax.reload();
    });

    Livewire.on('reload-users-table', () => {
        table.ajax.reload(null, false);
    });

});
