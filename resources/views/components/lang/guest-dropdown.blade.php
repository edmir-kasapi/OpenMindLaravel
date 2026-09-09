<div class="dropdown">
    <label tabindex="0" class="btn btn-ghost btn-sm">
        {{ config('localization.locales.'.session()->get('lang')) }}
    </label>

    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-40">
        @foreach (config('localization.locales') as $locale => $language)
            <li>
                <a href="{{ route('localization', $locale) }}">
                    {{ $language }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
