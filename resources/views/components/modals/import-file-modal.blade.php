@props(['id',
    'title',
    'message',
    'submitText',
    'type' => 'secondary',
    'wireSubmit',
    'wireModel'])

<!--begin::Danger Modal-->
<div wire:ignore.self class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $type }}-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="{{ $wireSubmit }}" enctype="multipart/form-data">
                <div class="modal-header bg-{{ $type }} text-white">
                    <h5 class="modal-title" id="modal-{{ $type }}-label">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg">
                    <p class="mb-0">
                        {{ $message }}
                    </p>

                    <div class="form-group mt-3">

                        <input class="form-control @error($wireModel) is-invalid @enderror" type="file" accept=".xlsx, .xls"
                            wire:model="{{ $wireModel }}" required>
                        @error( $wireModel )
                            <div class="label mt-1 mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                        @enderror

                        <div wire:loading wire:target="{{ $wireModel }}" class="ms-2">
                            <span> Loading file... </span>
                        </div>

                        <div wire:loading wire:target="{{ $wireSubmit }}" class="ms-2">
                            <span> Uploading Content... </span>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('modals/delete-product-modal.cancel') }}
                    </button>

                    <button type="submit"
                        class="btn btn-outline-{{ $type }}"
                            wire:loading.attr="disabled"
                            wire:target="{{ $wireModel }},{{ $wireSubmit }}">
                        {{ $submitText }}
                    </button>

                    <div class="d-flex gap-1 mx-auto">
                         <div class="label mt-1 mb-2">
                            <span class="label-text-alt text-primary">{{ __('modals/delete-modal.example_message') }}</span>
                        </div>

                        <button wire:click="downloadExample()" type="button" class="btn btn-warning">
                            <i class="bi bi-file-earmark-spreadsheet"></i>
                            {{ __('modals/delete-modal.example') }}
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
