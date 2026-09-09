<div class="navbar-start">
    @guest
        <a href="{{ route('index') }}" class="btn btn-ghost text-xl"><i class="bi bi-brilliance">OpenMind</i></a>
    @endguest

    @auth

        @if (auth()->user()->hasRole(['Admin']))
            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost text-xl"><i class="bi bi-brilliance">OpenMind</i></a>
        @else
            <a href="{{ route('user.home') }}" class="btn btn-ghost text-xl"><i class="bi bi-brilliance">OpenMind</i></a>
        @endif

    @endauth
</div>
