<div class="dropdown">
    <button class="btn btn-default dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{ config('localization.locales.'.session()->get('lang')) }}
    </button>

    <div class="dropdown-menu dropdown-menu">
        @foreach (config('localization.locales') as $locale => $language)
            <li>
                <a href="{{ route('localization', $locale) }}" class="dropdown-item">
                    {{ $language }}
                </a>
            </li>
        @endforeach
    </div>
</div>
