<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Services\Products\ProductService;
use App\Models\Product;

new class extends Component {

    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';
    protected ProductService $productService;

    public ?string $name = null;
    public ?int $product_type = null;
    public ?string $brand = null;
    public ?string $stock_level = null;
    public ?float $min_price = null;
    public ?float $max_price = null;
    public ?string $sort_type = null;

    public function boot(ProductService $productService) //method binding. Used boot because it carries on every request/page.
    {
        $this->productService = $productService;
    }

    public function filterCatalog()
    {
        $this->render();
    }

    public function render()
    {
        $products = $this->productService->getProductCatalogForLivewire(
        $this->name,
        $this->brand,
        $this->product_type,
        $this->stock_level,
        $this->min_price,
        $this->max_price,
        $this->sort_type,
        );

        return $this->view([
            'products' => $products,
        ]);
    }

};
?>

<div class="w-100">
    <div class="d-flex mx-auto mb-5 gap-3 w-75 mx-auto">
        {{ $products->oneachSide(2)->links()}}

        <a href="{{ route('user.products') }}">
            <button class="btn btn-warning" type="submit">
                <i class="bi bi-repeat"> {{ __('products\products-catalog.reset') }} </i>
            </button>
        </a>

        <form wire:submit="filterCatalog" class="d-flex gap-2">

            <div class="input-group">
                <input type="text" wire:model="name" class="form-control"
                    value="@if (request()->filled('name')) {{ request()->name }} @endif"
                    placeholder="{{ __('products\products-catalog.enter_product_name') }}">
            </div>

            <div class="input-group">
                <span class="input-group-text">{{ __('products/products-create.type') }}</span>
                <select id="productCategory" wire:model="product_type"
                    class="form-select @error('product_type') input-error @enderror">
                    <option value="">{{ __('products/products-create.select_category') }}
                    </option>
                    <option value="1" {{ old('product_type', request()->product_type) == 1 ? 'selected' : '' }}>
                        {{ __('products/products-create.electronics') }}</option>
                    <option value="2" {{ old('product_type', request()->product_type) == 2 ? 'selected' : '' }}>
                        {{ __('products/products-create.clothing') }}</option>
                    <option value="3" {{ old('product_type', request()->product_type) == 3 ? 'selected' : '' }}>
                        {{ __('products/products-create.footwear') }}</option>
                    <option value="4" {{ old('product_type', request()->product_type) == 4 ? 'selected' : '' }}>
                        {{ __('products/products-create.accessories') }}</option>
                    <option value="5" {{ old('product_type', request()->product_type) == 5 ? 'selected' : '' }}>
                        {{ __('products/products-create.home_kitchen') }}</option>
                    <option value="6" {{ old('product_type', request()->product_type) == 6 ? 'selected' : '' }}>
                        {{ __('products/products-create.furniture') }}</option>
                    <option value="7" {{ old('product_type', request()->product_type) == 7 ? 'selected' : '' }}>
                        {{ __('products/products-create.beauty_personal_care') }}</option>
                    <option value="8" {{ old('product_type', request()->product_type) == 8 ? 'selected' : '' }}>
                        {{ __('products/products-create.health_wellness') }}</option>
                    <option value="9" {{ old('product_type', request()->product_type) == 9 ? 'selected' : '' }}>
                        {{ __('products/products-create.sports_outdoors') }}</option>
                    <option value="10" {{ old('product_type', request()->product_type) == 10 ? 'selected' : '' }}>
                        {{ __('products/products-create.toys_games') }}</option>
                    <option value="11" {{ old('product_type', request()->product_type) == 11 ? 'selected' : '' }}>
                        {{ __('products/products-create.books') }}</option>
                    <option value="12" {{ old('product_type', request()->product_type) == 12 ? 'selected' : '' }}>
                        {{ __('products/products-create.office_supplies') }}</option>
                    <option value="13" {{ old('product_type', request()->product_type) == 13 ? 'selected' : '' }}>
                        {{ __('products/products-create.automotive') }}</option>
                    <option value="14" {{ old('product_type', request()->product_type) == 14 ? 'selected' : '' }}>
                        {{ __('products/products-create.pet_supplies') }}</option>
                    <option value="15" {{ old('product_type', request()->product_type) == 15 ? 'selected' : '' }}>
                        {{ __('products/products-create.food_beverages') }}</option>
                    <option value="16" {{ old('product_type', request()->product_type) == 16 ? 'selected' : '' }}>
                        {{ __('products/products-create.jewelry') }}</option>
                    <option value="17" {{ old('product_type', request()->product_type) == 17 ? 'selected' : '' }}>
                        {{ __('products/products-create.watches') }}</option>
                    <option value="18" {{ old('product_type', request()->product_type) == 18 ? 'selected' : '' }}>
                        {{ __('products/products-create.baby_products') }}</option>
                    <option value="19" {{ old('product_type', request()->product_type) == 19 ? 'selected' : '' }}>
                        {{ __('products/products-create.garden_outdoor') }}</option>
                    <option value="20" {{ old('product_type', request()->product_type) == 20 ? 'selected' : '' }}>
                        {{ __('products/products-create.tools_hardware') }}</option>
                    <option value="21" {{ old('product_type', request()->product_type) == 21 ? 'selected' : '' }}>
                        {{ __('products/products-create.art_crafts') }}</option>
                    <option value="22" {{ old('product_type', request()->product_type) == 22 ? 'selected' : '' }}>
                        {{ __('products/products-create.musical_instruments') }}</option>
                    <option value="23" {{ old('product_type', request()->product_type) == 23 ? 'selected' : '' }}>
                        {{ __('products/products-create.software') }}</option>
                    <option value="24" {{ old('product_type', request()->product_type) == 24 ? 'selected' : '' }}>
                        {{ __('products/products-create.digital_products') }}</option>
                    <option value="25" {{ old('product_type', request()->product_type) == 25 ? 'selected' : '' }}>
                        {{ __('products/products-create.gift_cards') }}</option>
                </select>
                @error('product_type')
                    <div class="label mb-2">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="dropdown">

                <button class="btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    {{ __('products\products-catalog.advanced_search') }}
                </button>

                <div class="dropdown-menu dropdown-menu-right p-3" style="min-width: 400px;"
                    aria-labelledby="advancedSearchDropdown">

                    <h6>{{ __('products\products-catalog.apply_filters') }}</h6>

                    <hr>

                    <div class="form-group mb-3">
                        <label for="brand">{{ __('products\products-catalog.brand') }}</label>
                        <input type="text" wire:model="brand" class="form-control"
                            value="@if (request()->filled('brand')) {{ request()->brand }} @endif"
                            placeholder="{{ __('products\products-catalog.enter_brand_name') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="stockStatus">{{ __('products\products-catalog.stock_level') }}</label>

                        <select class="form-control" id="stockStatus" wire:model="stock_level">
                            <option value="">{{ __('products\products-catalog.any') }}</option>
                            <option value="in-stock"
                                {{ old('stock_level', request()->stock_level) == 'in-stock' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.in_stock') }}</option>
                            <option value="medium-stock"
                                {{ old('stock_level', request()->stock_level) == 'medium-stock' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.medium_stock') }}</option>
                            <option value="low-stock"
                                {{ old('stock_level', request()->stock_level) == 'low-stock' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.low_stock') }}</option>
                            <option value="out-of-stock"
                                {{ old('stock_level', request()->stock_level) == 'out-of-stock' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.out_of_stock') }}</option>
                        </select>
                    </div>

                    <div class="form-group d-flex mb-1">
                        <label for="minPrice">{{ __('products\products-catalog.minimum_price') }}</label>
                        <input type="number" class="form-control" min=0 step="0.01" wire:model="min_price"
                            value=@if (request()->filled('min_price')) {{ request()->min_price }} @endif id="">
                    </div>

                    <div class="form-group d-flex">
                        <label for="minPrice">{{ __('products\products-catalog.maximum_price') }}</label>
                        <input type="number" class="form-control" min=0 step="0.01" wire:model="max_price"
                            value=@if (request()->filled('max_price')) {{ request()->max_price }} @endif id="">
                    </div>

                    <hr>

                    <div class="form-group mb-3">
                        <label for="stockStatus">{{ __('products\products-catalog.sort_by') }}</label>
                        <select class="form-control" id="sortType" wire:model="sort_type">
                            <option value="">{{ __('products\products-catalog.no_sorting') }}</option>
                            <option value="name-asc"
                                {{ old('sort_type', request()->sort_type) == 'name-asc' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.name_asc') }}</option>
                            <option value="name-desc"
                                {{ old('sort_type', request()->sort_type) == 'name-desc' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.name_desc') }}</option>
                            <option value="price-asc"
                                {{ old('sort_type', request()->sort_type) == 'price-asc' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.price_asc') }}</option>
                            <option value="price-desc"
                                {{ old('sort_type', request()->sort_type) == 'price-desc' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.price_desc') }}</option>
                            <option value="stock-asc"
                                {{ old('sort_type', request()->sort_type) == 'stock-asc' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.stock_asc') }}</option>
                            <option value="stock-desc"
                                {{ old('sort_type', request()->sort_type) == 'stock-desc' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.stock_desc') }}</option>
                            <option value="date-asc"
                                {{ old('sort_type', request()->sort_type) == 'date-asc' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.date_asc') }}</option>
                            <option value="date-desc"
                                {{ old('sort_type', request()->sort_type) == 'date-desc' ? 'selected' : '' }}>
                                {{ __('products\products-catalog.date_desc') }}</option>
                        </select>
                    </div>

                </div>

            </div>


            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
            </button>

        </form>

    </div>

    <div class="row row-cols-5 g-5 p-4">

        @if ($products->count())
            @foreach ($products as $product)
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden" style="max-width: 22rem;">

                        @if ($product->pictures->count())
                            <img src="{{ asset('storage/products/' . $product->pictures[0]->getSrc()) }}"
                                class="card-img-top" alt="{{ $product->name }}"
                                style="height: 240px; object-fit: cover;">
                        @else
                            <div class="text-center py-5" style="height: 240px;">
                                <i class="bi bi-image display-4 text-secondary"></i>
                                <p class="text-muted mt-3 mb-0">
                                    {{ __('products/products-edit.no_pictures') }}
                                </p>
                            </div>
                        @endif



                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold mb-0">{{ $product->name }}</h5>
                                <span class="fs-5 fw-bold text-success">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                {{ Str::limit($product->brand, 20) }} <br />
                                <x-datatable.badges.product-type-badge :type="$product->type->getTypeName()" /> <br />
                                <x-datatable.badges.stock-level-badge :stock="$product->stock" />
                            </div>

                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($product->description, 120) }}
                            </p>

                            <div class="d-grid mt-auto">
                                <a href="{{ route('user.products.view', $product->id) }}"
                                    class="btn btn-primary rounded-pill">
                                    {{ __('products\products-catalog.view_product') }}
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center"
                style="min-height: 350px; background-color: #f4f6f9;">

                <i class="fas fa-box-open fa-4x text-secondary mb-3"></i>

                <h4 class="text-secondary mb-2">
                    {{ __('products\products-catalog.no_products_found') }}
                </h4>

                <p class="text-muted mb-0">
                    {{ __('products\products-catalog.no_products_found_message') }}
                </p>

            </div>

        @endif


    </div>
</div>
