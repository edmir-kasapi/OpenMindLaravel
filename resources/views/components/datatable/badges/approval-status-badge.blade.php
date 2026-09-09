@props(['isApproved'])

@php
    $color = "text-bg-danger";
    $status = "Unapproved";
@endphp

@if($isApproved)
    @php
        $color = "text-bg-success";
        $status = "Approved";
    @endphp
@endif

<span class="badge {{ $color }}">

    {{ strtoupper($status) }}
</span>
