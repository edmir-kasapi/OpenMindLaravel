<x-layouts.app>

    <x-slot:title>
        {{ __('products/products.page_title') }}
    </x-slot:title>


    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('products/products.heading') }}</h1>

    <livewire:components.datatables.products.active-products-datatable />

    <x-modals.danger-modal
        id="modal-delete-product"
        title="{{ __('modals/delete-product-modal.delete_product') }}"
        message="{{ __('modals/delete-product-modal.delete_product_confirmation') }}"
        form-id="delete-product-form"
        submit-text="{{ __('modals/delete-product-modal.delete') }}"
        method='DELETE'
    />

    <div id="products-config" data-products-url="{{ route('admin.products') }}"
        data-delete-url="{{ url('/admin/products/delete') }}">
    </div>

</x-layouts.app>
