@props(['verified'])
<span class="badge

    @if ($verified)
        text-bg-success
    @else
        text-bg-danger
    @endif

    ">

    @if ($verified)
        VERIFIED
    @else
        UNVERIFIED
    @endif

</span>
