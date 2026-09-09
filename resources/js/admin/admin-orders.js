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

    const config = $('#admin-orders-config');

    const ordersUrl = config.data('orders-url');
    const deleteUrl = config.data('delete-url');

    const table = $('#admin-orders-table').DataTable({
        serverSide: true,
        processing: true,
        titleRow: 0,
        ajax: {
            url: ordersUrl,
            data: function(d) {
                d.order_status_id = $('#order-status-filter').val();
                d.payment_status_id = $('#payment-status-filter').val();
                d.shipment_status_id = $('#shipment-status-filter').val();
            }
        },
        columns: [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'user',
            name: 'user_id'
        },
        {
            data: 'product',
            name: 'product_id'
        },
        {
            data: 'quantity',
            name: 'quantity'
        },
        {
            data: 'address',
            name: 'address',

        },
        {
            data: 'total_price',
            name: 'total_price'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'order_status',
            name: 'order_status'
        },
        {
            data: 'payment_status',
            name: 'payment_status'
        },
        {
            data: 'shipment_status',
            name: 'shipment_status'
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

    $(document).on('click', '.delete-order', function (e) {

        let orderId = $(this).attr('data-id');
        let redirect = $(this).attr('data-redirect');

        $('#admin-delete-order-form')
            .data('order-id', orderId)
            .data('redirect', redirect);

        console.log(redirect);
    });

    $('#admin-delete-order-form').on('submit', function (e) {

        e.preventDefault();

        let orderId = $(this).data('order-id');

        if (orderId) {

            console.log('order id retrieved');
            $.ajax({
                url: `${deleteUrl}/${orderId}`,
                method: 'DELETE',
                data: {
                    redirect: $('#admin-delete-order-form').data('redirect')
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

        const modalElement = document.getElementById('modal-delete-order');
        const modal = bootstrap.Modal.getInstance(modalElement);

        modal.hide();

    });

    $('#order-status-filter').on('change', function () {
        table.ajax.reload();
    });

    $('#payment-status-filter').on('change', function () {
        table.ajax.reload();
    });

    $('#shipment-status-filter').on('change', function () {
        table.ajax.reload();
    });

});
