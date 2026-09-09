@props([
    'id',
    'title',
    'message',
    'submitText',
    'type' => 'secondary',
    'wireConfirm',
    'wireCancel'
])

<!--begin::Danger Modal-->
<div wire:ignore.self class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $type }}-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-{{ $type }} text-white">
                <h5 class="modal-title" id="modal-{{ $type }}-label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg">
                <p class="mb-0">
                    {{ $message }}
                </p>
            </div>
            <div class="modal-footer">

                <button wire:click="{{ $wireCancel }}" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('modals/delete-product-modal.cancel') }}
                </button>

                <button wire:click="{{ $wireConfirm }}" type="button" class="btn btn-outline-{{ $type }}" data-bs-dismiss="modal">
                    {{ $submitText }}
                </button>

            </div>
        </div>
    </div>
</div>
