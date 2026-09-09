@props(['stock'])

@php
    $stockLevel = match(true) {
        $stock <= 0 => 'Out of Stock',
        $stock <= 10 => 'Low Stock',
        $stock <= 50 => 'Medium Stock',
        default => 'In Stock'
    }
@endphp

<span class="badge

    @switch($stockLevel)
        @case('Out of Stock')
            text-bg-danger
            @break

        @case('Low Stock')
            text-bg-warning
            @break

        @case('Medium Stock')
            text-bg-info
            @break

        @case('In Stock')
            text-bg-success
            @break

        @default
            text-bg-secondary
    @endswitch

">
{{ strtoupper($stockLevel) }}
</span>
