@props(['active' => false])

<a {{ $attributes }} @class([
    'btn  text-xl',
    'btn-dark text-white' => $active,
    'btn-ghost' => !$active,
])>
    {{ $slot }}
</a>

