@props([
    'icon',
    'type' => 'secondary'
])
<button type="button"
        class="btn btn-outline-{{ $type }}"
        {{ $attributes }}
        >

    <i class="bi bi-{{ $icon }}" aria-hidden="true"> </i>
</button>
