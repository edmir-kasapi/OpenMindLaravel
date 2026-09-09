<x-layouts.app>

    <x-slot:title>
        {{ __('admin/users.title_users_admin') }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('admin/users.manage_users') }}</h1>

    <livewire:components.datatables.users.active-users-datatable />

    <livewire:modals.user-create-modal />

</x-layouts.app>
