@props(['status'])

<span class="badge

    @switch($status)
        @case('Shipped')
            text-bg-primary
            @break

        @case('Returned')
            text-bg-danger
            @break

        @case('Delivered')
            text-bg-success
            @break

        @case('Packed')
            text-bg-warning
            @break

        @default
            text-bg-secondary
    @endswitch

    ">
    {{ strtoupper($status) }}
</span>
