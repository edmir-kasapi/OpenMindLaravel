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

    const config = $('#trash-users-config');

    const trashedUrl = config.data('users-url');
    const restoreUrl = config.data('restore-url');
    const forceDeleteUrl = config.data('force-delete-url');


    const table = $('#trashed-users-table').DataTable({
        serverSide: true,
        processing: true,
        titleRow: 0,
        ajax: {
            url: trashedUrl,
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
            data: 'deleted_at',
            name: 'deleted_at'
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



    $(document).on('click', '.restore-user', function (e) {

        let userId = $(this).attr('data-id');
        $('#restore-user-form').data('user-id', userId);
    });

    $('#restore-user-form').on('submit', function (e) {

        e.preventDefault();

        let userId = $(this).data('user-id');

        if (userId) {
            $.ajax({
                url: `${restoreUrl}/${userId}`,
                method: 'POST',
                success: function (response) {
                    if (response.status === 'success') {
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

        const modalElement = document.getElementById('modal-restore-user');
        const modal = bootstrap.Modal.getInstance(modalElement);

        console.log(bootstrap);

        modal.hide();

    });

    $(document).on('click', '.force-delete-user', function (e) {

        let userId = $(this).attr('data-id');
        $('#force-delete-user-form').data('user-id', userId);
    });

    $('#force-delete-user-form').on('submit', function (e) {

        e.preventDefault();

        let userId = $(this).data('user-id');

        if (userId) {
            $.ajax({
                url: `${forceDeleteUrl}/${userId}`,
                method: 'DELETE',
                success: function (response) {
                    if (response.status === 'success') {
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

        const modalElement = document.getElementById('modal-force-delete-user');
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


});
