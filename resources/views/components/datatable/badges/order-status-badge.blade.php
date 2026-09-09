@props(['status'])

<span class="badge

    @switch($status)
        @case('Confirmed')
            text-bg-primary
            @break

        @case('Cancelled')
            text-bg-danger
            @break

        @case('Completed')
            text-bg-success
            @break

        @case('Pending')
            text-bg-warning
            @break

        @default
            text-bg-secondary
    @endswitch

    ">
    {{ strtoupper($status) }}
</span>
