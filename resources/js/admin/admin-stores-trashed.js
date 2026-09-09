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

    const config = $('#admin-disabled-stores-config');

    const storesUrl = config.data('stores-url');
    const restoreUrl = config.data('restore-url');
    const forceDeleteUrl = config.data('force-delete-url');

    const table = $('#admin-disabled-stores-table').DataTable({
        serverSide: true,
        processing: true,
        titleRow: 0,
        ajax: {
            url: storesUrl,
            data: function(d)
            {
                d.country = $('#country-filter').val();
            }
        },
        columns: [
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'operator',
            name: 'operator_id'
        },
        {
            data: 'country',
            name: 'country'
        },
        {
            data: 'address',
            name: 'address'
        },
        {
            data: 'phone',
            name: 'phone'
        },
        {
            data: 'domain',
            name: 'domain'
        },
        {
            data: 'deleted_at',
            name: 'deleted_at'
        },
        {
            data: 'status',
            name: 'is_approved',
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


    $(document).on('click', '.reinstate-store', function (e) {

        let storeId = $(this).attr('data-id');
        $('#reinstate-store-form').data('store-id', storeId);
    });

    $('#reinstate-store-form').on('submit', function (e) {

        e.preventDefault();

        let storeId = $(this).data('store-id');

        if (storeId) {
            $.ajax({
                url: `${restoreUrl}/${storeId}`,
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

        const modalElement = document.getElementById('modal-reinstate-store');
        const modal = bootstrap.Modal.getInstance(modalElement);

        modal.hide();

    });

    $(document).on('click', '.force-delete-store', function (e) {

        let storeId = $(this).attr('data-id');
        $('#force-delete-store-form').data('store-id', storeId);
    });

    $('#force-delete-store-form').on('submit', function (e) {

        e.preventDefault();

        let storeId = $(this).data('store-id');

        if (storeId) {
            $.ajax({
                url: `${forceDeleteUrl}/${storeId}`,
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

        const modalElement = document.getElementById('modal-force-delete-store');
        const modal = bootstrap.Modal.getInstance(modalElement);

        modal.hide();

    });

    $('#country-filter').on('change', function () {
        table.ajax.reload();
    });

});
