<?php

use App\Models\Product;
use App\Exports\ProductsExport;
use App\Exports\ProductsExample;
use App\Traits\Datatable\WithFileImportExport;
use Edmirkasapi\LiveDatatable\abstracts\LiveDatatable;
use App\Services\Products\ProductService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Validators\ValidationException;

new class extends LiveDatatable {

    use WithFileImportExport;

    protected array $columnOrder = ['name', 'brand', 'type_id', 'price', 'stock_level', 'created_at', 'actions'];

    public ?string $productToDelete = null;
    protected ProductService $productService;

    public function boot(ProductService $productService): void
    {
        $this->productService = $productService;
    }

    public function prepareDeleteProduct(string $id): void
    {
        $this->productToDelete = $id;
        $this->dispatch('show-modal', modalId: 'modal-delete-product');
    }

    public function proceedDeletion(): void
    {
        if (!$this->productToDelete) {
            return;
        }

        $product = Product::find($this->productToDelete);

        if (!$product) {
            $this->productToDelete = null;
            $this->dispatch('show-show-error-message', message: 'Invalid product ID provided. Cannot Delete.');
        }

        $this->productService->deleteProduct($product);
        $this->dispatch('show-success-message', message: 'Product deleted successfully');
        $this->goToPreviousPageIfEmpty($this->query());
    }

    public function cancelDeletion(): void
    {
        $this->productToDelete = null;
    }

    #[Override]
    public function exportData(): ProductsExport
    {
        $query = $this->query();
        $query = $this->applySearch($query);
        $query = $this->applyFilters($query);
        $query = $this->applySorting($query);

        return $this->productService->exportProducts($query);;
    }

    #[Override]
    public function importData(): void
    {
        if (!$this->importFile) {
            this->dispatch('show-error-message', message: 'File not uploaded.');
            return;
        }

        $validated = $this->validate([
            'importFile' => ['required', 'file', 'mimes:xlsx,xls', 'max:10240'],
        ]);

        try {
            $this->productService->importProducts($validated['importFile']);

            $this->dispatch('show-success-message', message: 'Import successful.');
            $this->dispatch('hide-modal', modalId: 'modal-import-file');

            $this->resetPage();
        } catch (validationException $e) {
            $failures = $e->failures();

            $errors = collect($failures)
                ->flatMap(function ($failure) {
                    return collect($failure->errors())->map(fn($error) => "Row {$failure->row()} ({$failure->attribute()}): {$error}");
                })
                ->implode("\n");

            $this->dispatch('show-error-message', message: $errors);
        }
    }

    #[Override]
    public function downloadExample(): ProductsExample
    {
        return new ProductsExample();
    }

    #[Override]
    protected function columns(): array
    {
        return [
            'name' => [
                'label' => __('products/products.product'),
                'sortable' => true
            ],

            'brand' => [
                'label' => __('products/products.brand'),
                'sortable' => true
            ],

            'type_id' => [
                'label' => __('products/products.type'),
                'sortable' => true
            ],

            'price' => [
                'label' => __('products/products.price'),
                'sortable' => true
            ],

            'stock_level' => [
                'label' => __('products/products.stock_level'),
                'sortable' => true
            ],

            'created_at' => [
                'label' => __('products/products.date_registered'),
                'sortable' => true
            ],

            'actions' => [
                'label' => __('products/products.actions'),
            ],
        ];
    }

    #[Override]
    protected function query(): Builder
    {
        return Product::query()->with(['type', 'pictures']);
    }

    #[Override]
    protected function applyFilters(Builder $query): Builder
    {
        foreach ($this->filters as $column => $value) {
            //$value = $this->filters[$filter] ?? null;

            if (blank($value)) {
                continue;
            }

            $valid_cols = $this->columns();
            if(blank($value) || !$this->isValidFilter($column))
            {
                continue;
            }

            switch ($column) {
                case 'name':
                case 'brand':
                    $query->where($column, 'LIKE', "%{$value}%");
                    break;

                case 'min_price':
                    $query->minPrice($value);
                    break;

                case 'max_price':
                    $query->maxPrice($value);
                    break;

                case 'stock_level':
                    $query->filterStock($value);
                    break;

                default:
                    $query->where($column, $value);
                    break;
            }
        }

        return $query;
    }

    #[Override]
    protected function isValidFilter(string $column): bool
    {
        $validCols = array_keys($this->columns());
        return in_array($column, array_merge($validCols, ['max_price', 'min_price']));
    }

    #[Override]
    protected function searchable(): array
    {
        return [
            'name',
            'brand'
            ];
    }
};
?>

@php
    $orderedColumns = $this->getOrderedColumns();
@endphp

<section class="w-75 mx-auto">

    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-12">
                    <!--begin::Card-->
                    <div class="card mb-4">
                        <!--begin::Card Header-->
                        <div class="card-header">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-4">
                                    <h3 class="card-title">{{ __('products/products.products_list') }}</h3>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="d-flex flex-wrap justify-content-md-end gap-3">

                                        <a href="{{ route('admin.trashed.products') }}">
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="">
                                                <i class="bi bi-archive-fill me-1" aria-hidden="true"> </i>
                                                {{ __('products/products.deleted_products') }}
                                            </button>
                                        </a>

                                        <a href="{{ route('admin.products.create') }}">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="">
                                                <i class="bi bi-plus-lg me-1" aria-hidden="true"> </i>
                                                {{ __('products/products.new_product') }}
                                            </button>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card Header-->
                        <!--begin::Card Body-->
                        <div class="card-body p-0">
                            <div class="table-responsive">

                                <div class="dt-layout-row d-flex justify-content-start gap-3 bg-body-secondary">

                                    <div class="dt-layout-cell dt-layout-start d-flex">
                                        <div
                                            class="dt-length d-flex align-items-center gap-2 mb-3 ms-3 p-2 w-auto my-3 bg-light border rounded">
                                            <label class="mb-0 text-muted small fw-semibold">
                                                {{ __('products/products.entries_per_page') }}
                                            </label>
                                            <select wire:model.live="perPage" wire:change="$dispatch('filters-updated')"
                                                class="dt-input form-select form-select-sm" style="width: 80px;">
                                                <option value="5">5</option>
                                                <option value="10" selected>10</option>
                                                <option value="15">15</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="dt-layout-cell dt-layout-start d-flex">
                                        <div
                                            class="dt-length d-flex align-items-center gap-2 mb-3 mr-3 p-2 w-auto my-3 bg-light border rounded">
                                            <label class="mb-0 text-muted small fw-semibold">
                                                {{ __('admin/users.search') }} </label>
                                            <input type="text" wire:model.live="search"
                                                @input="$dispatch('filters-updated')" class="form-control">
                                        </div>
                                    </div>

                                    <div class="dt-layout-cell dt-layout-start d-flex">
                                        <div
                                            class="dt-length d-flex align-items-center mb-3 mr-3 p-2 gap-1 w-auto my-3">
                                            <button wire:click="exportData()" class="btn btn-light text-secondary">
                                                <i class="bi bi-file-earmark-excel-fill"></i>
                                                {{ __('products\products.export_excel') }}
                                            </button>

                                            <button class="btn btn-light text-secondary" data-bs-toggle="modal"
                                                data-bs-target="#modal-import-file">
                                                <i class="bi bi-upload"></i>
                                                {{ __('products\products.import_excel') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <table class="table table-hover align-middle m-0" id="" role="table">
                                    <thead>
                                        <tr>
                                            @foreach ($orderedColumns as $key => $column)
                                                <th scope="col" wire:click="sortBy('{{ $key }}')"
                                                    class="text-nowrap user-select-none"
                                                    @if ($this->isSortable($key))  style="cursor: pointer" @endif
                                                    aria-sort="{{ $key === $this->sortColumn ? ($this->sortDirection === 'asc' ? 'ascending' : 'descending') : 'none' }}">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between gap-2">
                                                        <span>{{ $column['label'] }}</span>

                                                        @if ($this->isSortable($key))
                                                            <span class="sort-icon">
                                                            @if ($key === $this->sortColumn && !blank($this->sortDirection))
                                                                @if ($this->sortDirection === 'asc')
                                                                    <i class="bi bi-arrow-up"></i>
                                                                @else
                                                                    <i class="bi bi-arrow-down"></i>
                                                                @endif
                                                            @else
                                                                <i class="bi bi-arrow-down-up"></i>
                                                            @endif
                                                        </span>
                                                        @endif
                                                    </div>
                                                </th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($orderedColumns as $key => $column)
                                                <th scope="col">
                                                    @switch($key)
                                                        @case('name')
                                                            <input type="text" wire:model.live="filters.name"
                                                                @input="$dispatch('filters-updated')" class="form-control">
                                                        @break

                                                        @case('brand')
                                                            <input type="text" wire:model.live="filters.brand"
                                                                @input="$dispatch('filters-updated')" class="form-control">
                                                        @break

                                                        @case('type_id')
                                                            <select id="category-filter" wire:model.live="filters.type_id"
                                                                wire:change="$dispatch('filters-updated')" class="form-select ">
                                                                <option value="">
                                                                    {{ __('products/products-catalog.any') }}
                                                                </option>
                                                                <option value="1">
                                                                    {{ __('products/products-create.electronics') }}</option>
                                                                <option value="2">
                                                                    {{ __('products/products-create.clothing') }}</option>
                                                                <option value="3">
                                                                    {{ __('products/products-create.footwear') }}</option>
                                                                <option value="4">
                                                                    {{ __('products/products-create.accessories') }}</option>
                                                                <option value="5">
                                                                    {{ __('products/products-create.home_kitchen') }}</option>
                                                                <option value="6">
                                                                    {{ __('products/products-create.furniture') }}</option>
                                                                <option value="7">
                                                                    {{ __('products/products-create.beauty_personal_care') }}
                                                                </option>
                                                                <option value="8">
                                                                    {{ __('products/products-create.health_wellness') }}
                                                                </option>
                                                                <option value="9">
                                                                    {{ __('products/products-create.sports_outdoors') }}
                                                                </option>
                                                                <option value="10">
                                                                    {{ __('products/products-create.toys_games') }}</option>
                                                                <option value="11">
                                                                    {{ __('products/products-create.books') }}</option>
                                                                <option value="12">
                                                                    {{ __('products/products-create.office_supplies') }}
                                                                </option>
                                                                <option value="13">
                                                                    {{ __('products/products-create.automotive') }}</option>
                                                                <option value="14">
                                                                    {{ __('products/products-create.pet_supplies') }}</option>
                                                                <option value="15">
                                                                    {{ __('products/products-create.food_beverages') }}
                                                                </option>
                                                                <option value="16">
                                                                    {{ __('products/products-create.jewelry') }}</option>
                                                                <option value="17">
                                                                    {{ __('products/products-create.watches') }}</option>
                                                                <option value="18">
                                                                    {{ __('products/products-create.baby_products') }}</option>
                                                                <option value="19">
                                                                    {{ __('products/products-create.garden_outdoor') }}
                                                                </option>
                                                                <option value="20">
                                                                    {{ __('products/products-create.tools_hardware') }}
                                                                </option>
                                                                <option value="21">
                                                                    {{ __('products/products-create.art_crafts') }}</option>
                                                                <option value="22">
                                                                    {{ __('products/products-create.musical_instruments') }}
                                                                </option>
                                                                <option value="23">
                                                                    {{ __('products/products-create.software') }}</option>
                                                                <option value="24">
                                                                    {{ __('products/products-create.digital_products') }}
                                                                </option>
                                                                <option value="25">
                                                                    {{ __('products/products-create.gift_cards') }}</option>
                                                            </select>
                                                        @break

                                                        @case('stock_level')
                                                            <select class="form-control" id="stock-filter"
                                                                wire:model.live="filters.stock_level"
                                                                wire:change="$dispatch('filters-updated')">
                                                                <option value="" selected>
                                                                    {{ __('products\products-catalog.any') }}</option>
                                                                <option value="in-stock">
                                                                    {{ __('products\products-catalog.in_stock') }}</option>
                                                                <option value="medium-stock">
                                                                    {{ __('products\products-catalog.medium_stock') }}</option>
                                                                <option value="low-stock">
                                                                    {{ __('products\products-catalog.low_stock') }}</option>
                                                                <option value="out-of-stock">
                                                                    {{ __('products\products-catalog.out_of_stock') }}</option>
                                                            </select>
                                                        @break

                                                        @case('price')
                                                            <div class="d-flex gap-2 align-items-end">
                                                                <div>
                                                                    <label for="minPrice" class="form-label small mb-1">
                                                                        {{ __('products\products-catalog.minimum_price') }}
                                                                    </label>
                                                                    <input type="number" class="form-control form-control-sm"
                                                                        min="0" step="0.01"
                                                                        wire:model.live.blur="filters.min_price"
                                                                        wire:change="$dispatch('filters-updated')"
                                                                        id="minPrice"
                                                                        placeholder="{{ __('products\products.min') }}">
                                                                </div>

                                                                <div>
                                                                    <label for="maxPrice" class="form-label small mb-1">
                                                                        {{ __('products\products-catalog.maximum_price') }}
                                                                    </label>
                                                                    <input type="number" class="form-control form-control-sm"
                                                                        min="0" step="0.01"
                                                                        wire:model.live.blur="filters.max_price"
                                                                        wire:change="$dispatch('filters-updated')"
                                                                        id="maxPrice"
                                                                        placeholder="{{ __('products\products.max') }}">
                                                                </div>
                                                            </div>
                                                        @break

                                                        @default
                                                    @endswitch
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $product)
                                            <tr>
                                                @foreach ($orderedColumns as $key => $column)
                                                    <td>
                                                        @switch($key)
                                                            @case('type_id')
                                                                <x-datatable.badges.product-type-badge :type="$product->type->getTypeName()" />
                                                            @break

                                                            @case('stock_level')
                                                                <x-datatable.badges.stock-level-badge :stock="$product->available_stock" />
                                                            @break

                                                            @case('actions')
                                                                <x-datatable.buttons.button-layout>
                                                                    <a href=" {{ route('admin.products.inspect', $product->id) }} "
                                                                        class="btn btn-outline-secondary">
                                                                        <i class="bi bi-pen" aria-hidden="true"> </i>
                                                                    </a>

                                                                    <x-datatable.buttons.action-button-mk2 type="danger"
                                                                        icon="trash"
                                                                        wire:click="prepareDeleteProduct({{ $product->id }})" />
                                                                </x-datatable.buttons.button-layout>
                                                            @break

                                                            @default
                                                                {{ data_get($product, $key) }}
                                                        @endswitch
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!--end::Card Body-->
                        <!--begin::Card Footer-->

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                                {{ $data->links(data: ['scrollTo' => false]) }}
                            </ul>
                        </div>

                    </div>
                    <!--end::Card Footer-->
                </div>
                <!--end::Card-->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->

    </div>
    <!--end::Container-->

    <x-modals.import-file-modal id="modal-import-file" title="{{ __('products\products.import_products') }}"
        message="{{ __('products\products.import_products_message') }}"
        submit-text="{{ __('products\products.import') }}" wire-submit="importData" wire-model="importFile" />

    <x-modals.confirm-modal-mk2 id="modal-delete-product" type="danger"
        title="{{ __('modals/delete-product-modal.delete_product') }}"
        message="{{ __('modals/delete-product-modal.delete_product_confirmation') }}"
        submit-text="{{ __('modals/delete-product-modal.delete') }}" wire-confirm="proceedDeletion()"
        wire-cancel="cancelDeletion()" />


</section>
