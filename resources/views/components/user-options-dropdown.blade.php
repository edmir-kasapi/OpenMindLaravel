<div class="mr-4">
    <div class="nav-item dropdown user-menu d-flex gap-2">

        @if ($isUser)
            @php
                $src = $authUser->profile
                    ? asset('storage/profiles/' . $authUser->profile->getSrc())
                    : 'https://ui-avatars.com/api/?name={{ urlencode($authUser->name) }}&color=7F9CF5&background=EBF4FF';
            @endphp

            <x-user-profile-picture :src="$src" :name="$authUser->name" width="40" height="40" />
        @endif


        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <span class="navbar-brand ms-3 mt-2">{{ $authUser->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu dropdown-menu-end">

            @if ($isUser)
                <li class="user-footer">
                    <a href="{{ route('user.profile') }}" class="dropdown-item">{{ __('app.view_profile') }}</a>
                </li>
                <li><hr class="dropdown-divider"></li>
            @endif

            <li class="user-footer">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">{{ __('app.log_out') }}</button>
                </form>
            </li>
            <!--end::Menu Footer-->
        </ul>
    </div>
</div>
