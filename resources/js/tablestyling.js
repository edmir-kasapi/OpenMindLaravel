export function stylePagination(container) {
    const paging = container.find('.dt-paging');

    paging.addClass('d-flex justify-content-end mt-3');
    paging.find('.dt-paging-button')
        .addClass('btn btn-sm btn-outline-primary mx-1 rounded');

    paging.find('.current')
        .removeClass('btn-outline-primary')
        .addClass('btn-primary');
}

export function styleInfo(container) {
    container.find('.dt-info')
        .addClass('text-muted small fw-semibold mt-3 ms-2');
}

export function styleSearch(container) {
    const search = container.find('.dt-search');

    search.addClass('d-flex align-items-center justify-content-end gap-2 mb-3 mr-4');
    search.find('label')
            .addClass('mb-0');
    search.find('input[type="search"]')
            .addClass('form-control form-control-sm')
            .css('width', '250px')
            .attr('placeholder', 'Search entries...');
}

export function styleLength(container) {
    const length = container.find('.dt-length');

    length.addClass('d-flex align-items-center gap-2 mb-3 ms-3 p-2 bg-light border rounded');
    length.find('label').addClass('mb-0 text-muted small fw-semibold');
    length.find('select')
        .addClass('form-select form-select-sm')
        .css('width', '80px');
}
