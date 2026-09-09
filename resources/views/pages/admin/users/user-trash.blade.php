<x-layouts.app>

    <x-slot:title>
        {{ __('admin/users.deleted_users') }}
    </x-slot:title>


    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('admin/USERS.deleted_users_heading') }}</h1>

    <livewire:components.datatables.users.trashed-users-datatable />

</x-layouts.app>


