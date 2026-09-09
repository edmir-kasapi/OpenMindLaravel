import {
    stylePagination,
    styleInfo,
    styleSearch,
    styleLength
} from '../tablestyling';

$(document).ready(function () {

    const config = $('#products-trashed-config');

    const trashedProductsUrl = config.data('products-trashed-url');
    const restoreProductUrl = config.data('restore-url');
    const forceDeleteProductUrl = config.data('force-delete-url');

    const table = $('#products-trashed-table').DataTable({
        serverSide: true,
        processing: true,
        titleRow: 0,
        ajax: {
            url: trashedProductsUrl,
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
            data: 'deleted_at',
            name: 'deleted_at'
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

    $(document).on('click', '.restore-product', function (e) {

        let productId = $(this).attr('data-id');
        $('#restore-product-form').data('product-id', productId);
    });

    $('#restore-product-form').on('submit', function (e) {

        e.preventDefault();

        let productId = $(this).data('product-id');
        console.log(productId);

        if (productId) {
            $.ajax({
                url: `${restoreProductUrl}/${productId}`,
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

        const modalElement = document.getElementById('modal-restore-product');
        const modal = bootstrap.Modal.getInstance(modalElement);

        console.log(bootstrap);

        modal.hide();

    });

    $(document).on('click', '.force-delete-product', function (e) {

        let productId = $(this).attr('data-id');
        $('#force-delete-product-form').data('product-id', productId);
    });

    $('#force-delete-product-form').on('submit', function (e) {

        e.preventDefault();

        let productId = $(this).data('product-id');

        if (productId) {
            $.ajax({
                url: `${forceDeleteProductUrl}/${productId}`,
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

        const modalElement = document.getElementById('modal-force-delete-product');
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
