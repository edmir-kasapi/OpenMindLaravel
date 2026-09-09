@php
        $src = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF';
        $name = $user->name;

        if ($user->profile) {
            $src = asset('storage/profiles/' . $user->profile->getSrc());
        }
@endphp

<div class="d-flex align-items-center">
    <img src="{{ $src }}" alt="" class="img-size-32 rounded-circle me-2">

    <span class="fw-medium">{{ $user->name }}</span>

</div>
