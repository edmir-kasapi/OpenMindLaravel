<x-layouts.app>

    <x-slot:title>
        {{ __('products/products-trashed.page_title') }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('products/products-trashed.heading') }}</h1>

    <livewire:components.datatables.products.trashed-products-datatable />

</x-layouts.app>
