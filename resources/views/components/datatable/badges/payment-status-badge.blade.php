@props(['status'])

<span class="badge

    @switch($status)
        @case('Partially Refunded')
        @case('Refunded')
            text-bg-primary
            @break

        @case('Cancelled')
            text-bg-danger
            @break

        @case('Paid')
            text-bg-success
            @break

        @case('Refund Pending')
            text-bg-warning
            @break

        @default
            text-bg-secondary
    @endswitch

    ">
    {{ strtoupper($status) }}
</span>
