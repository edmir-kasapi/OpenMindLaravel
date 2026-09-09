@props(['role'])
<span class="badge

    @switch($role)
        @case('User')
            text-bg-info
            @break
        @case('Admin')
            text-bg-danger
            @break
        @case('Store Operator')
            text-bg-warning
            @break

        @default

    @endswitch

    ">
    {{ strtoupper($role) }} </span>
