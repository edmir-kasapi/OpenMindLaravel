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

    const config = $('#operator-stores-config');

    const storesUrl = config.data('stores-url');
    const deleteUrl = config.data('delete-url');

    const table = $('#operator-stores-table').DataTable({
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
            data: 'created_at',
            name: 'created_at'
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


    $(document).on('click', '.disable-store', function (e) {

        let storeId = $(this).attr('data-id');
        let redirect = $(this).attr('data-redirect');

        $('#operator-disable-store-form')
            .data('store-id', storeId)
            .data('redirect', redirect);

        console.log(redirect);
    });

    $('#operator-disable-store-form').on('submit', function (e) {

        e.preventDefault();

        let storeId = $(this).data('store-id');

        if (storeId) {

            $.ajax({
                url: `${deleteUrl}/${storeId}`,
                method: 'DELETE',
                data: {
                    redirect: $('#operator-disable-store-form').data('redirect')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response.redirect);
                        if (response.redirect) {
                            console.log(response.redirect);
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

        const modalElement = document.getElementById('modal-disable-store');
        const modal = bootstrap.Modal.getInstance(modalElement);

        modal.hide();

    });


    $('#country-filter').on('change', function () {
        table.ajax.reload();
    });

});
