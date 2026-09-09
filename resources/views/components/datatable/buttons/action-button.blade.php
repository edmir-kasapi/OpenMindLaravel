@props([
    'actionClass',
    'dataId',
    'redirect' => false,
    'modalId',
    'icon',
    'type'
])
<button type="button"
        class="btn btn-outline-{{ $type }} {{ $actionClass }}"
        data-id="{{ $dataId }}"
        data-redirect="{{ $redirect }}"
        data-bs-toggle="modal"
        data-bs-target="#{{ $modalId }}"
        >

    <i class="bi bi-{{ $icon }}" aria-hidden="true"> </i>
</button>
