<x-layouts.app>

    <x-slot:title>
        {{ __('user/home.title_home_user') }}
    </x-slot:title>

    <h1 class="text-center text-5xl font-sans"> {{ __('user/home.welcome_user', ["name" => auth()->user()->name] ) }} </h1>
</x-layouts.app> 


