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

    const config = $('#products-config');

    const productsUrl = config.data('products-url');
    const deleteUrl = config.data('delete-url');

    const table = $('#products-table').DataTable({
        serverSide: true,
        processing: true,
        titleRow:0,
        ajax: {
            url: productsUrl,
            data: function(d) {
                d.product_type = $('#category-filter').val();
                d.stock_level = $('#stock-filter').val();
            }
        },
        columns: [{
            data: 'name',
            name: 'name'
        },
        {
            data: 'brand',
            name: 'brand'
        },
        {
            data: 'type',
            name: 'type_id'
        },
        {
            data: 'price',
            name: 'price'
        },
        {
            data: 'stock',
            name: 'stock'
        },
        {
            data: 'created_at',
            name: 'created_at'
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

    $(document).on('click', '.delete-product', function (e) {

        let userId = $(this).attr('data-id');
        let redirect = $(this).attr('data-redirect');

        $('#delete-product-form')
            .data('user-id', userId)
            .data('redirect', redirect);
    });

    $('#delete-product-form').on('submit', function (e) {

        e.preventDefault();

        let userId = $(this).data('user-id');

        if (userId) {

            console.log({
                deleteUrl,
                userId,
                url: `${deleteUrl}/${userId}`
            });

            $.ajax({
                url: `${deleteUrl}/${userId}`,
                method: 'DELETE',
                data: {
                    redirect: $('#delete-product-form').data('redirect')
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

        const modalElement = document.getElementById('modal-delete-product');
        const modal = bootstrap.Modal.getInstance(modalElement);

        console.log(bootstrap);

        modal.hide();

    });

    $('#category-filter').on('change', function () {
        table.ajax.reload();
    });

    $('#stock-filter').on('change', function () {
        table.ajax.reload();
    });

});
