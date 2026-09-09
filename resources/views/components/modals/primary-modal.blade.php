@props([
    'id',
    'title',
    'message',
    'formId',
    'submitText',
    'method'
])

<!--begin::Primary Modal-->
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="primary-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modal-primary-label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg">
                <p class="mb-0">
                    {{ $message }}
                </p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('modals/delete-product-modal.cancel') }}
                </button>

                <form method="post" id="{{$formId}}">
                    @csrf
                    @method($method)
                    <input type="submit" class="btn btn-outline-primary" value="{{ $submitText }}">
                </form>

            </div>
        </div>
    </div>
</div>
<!--end::Primary Modal-->
