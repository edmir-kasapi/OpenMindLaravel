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

    const config = $('#operator-keys-config');

    const keysUrl = config.data('keys-url');
    const revokeUrl = config.data('revoke-url');

    const table = $('#operator-keys-table').DataTable({
        serverSide: true,
        processing: true,
        titleRow: 0,
        ajax: {
            url: keysUrl,
        },
        columns: [
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'can_read_product',
            name: 'can_read_product'
        },
        {
            data: 'can_read_collections',
            name: 'can_read_collections'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'expires_at',
            name: 'expires_at'
        },
        {
            data: 'last_used_at',
            name: 'last_used_at'
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


    $(document).on('click', '.revoke-token', function (e) {

        let tokenId = $(this).attr('data-id');
        let redirect = $(this).attr('data-redirect');

        $('#operator-revoke-token-form')
            .data('token-id', tokenId)
            .data('redirect', redirect);

        console.log(redirect);
    });

    $('#operator-revoke-token-form').on('submit', function (e) {

        e.preventDefault();

        let tokenId = $(this).data('token-id');

        if (tokenId) {

            $.ajax({
                url: `${revokeUrl}/${tokenId}`,
                method: 'DELETE',
                data: {
                    redirect: $('#operator-revoke-token-form').data('redirect')
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

        const modalElement = document.getElementById('modal-revoke-token');
        const modal = bootstrap.Modal.getInstance(modalElement);

        modal.hide();

    });

});
