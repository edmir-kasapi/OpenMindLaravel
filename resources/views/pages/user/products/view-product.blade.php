<x-layouts.app>

    <x-slot:title>
        {{ $product->name }} - {{ __('products\products-view.products') }}
    </x-slot:title>

    <div>
        <a href=" {{ route('user.products') }} " class="btn btn-lg mb-2">
            <i class="bi bi-arrow-left" aria-hidden="true"> {{ __('products\products-view.back') }}</i>
        </a>
    </div>

    <div class="container-fluid">

        <!-- Product -->
        <div class="card">
            <div class="card-body">

                <div class="container-fluid">

                    <div class="row">

                        <!-- Product Image -->
                        <div class="col-lg-5">

                            <div class="card">
                                <div class="card-body text-center">

                                    @if ($product->pictures->count())

                                        <div id="editProductCarousel"
                                            class="carousel slide rounded overflow-hidden bg-dark shadow-sm"
                                            data-bs-interval="false">

                                            <div class="carousel-inner">

                                                @foreach ($product->pictures as $picture)
                                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

                                                        <div class="position-relative d-flex justify-content-center align-items-center"
                                                            style="height:400px;">

                                                            <img src="{{ asset('storage/products/' . $picture->getSrc()) }}"
                                                                class="img-fluid"
                                                                style="max-height:100%; object-fit:contain;"
                                                                alt="Product image">

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>

                                            @if ($product->pictures->count() > 1)
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#editProductCarousel" data-bs-slide="prev">

                                                    <span class="carousel-control-prev-icon"></span>

                                                </button>

                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#editProductCarousel" data-bs-slide="next">

                                                    <span class="carousel-control-next-icon"></span>

                                                </button>
                                            @endif

                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-image display-4 text-secondary"></i>
                                            <p class="text-muted mt-3 mb-0">
                                                {{ __('products/products-view.no_pictures') }}
                                            </p>
                                        </div>

                                    @endif

                                </div>
                            </div>

                        </div>

                        <!-- Product Information -->
                        <div class="col-lg-7">

                            <div class="card">
                                <div class="card-body">

                                    <h2 class="font-weight-bold">
                                        {{ $product->name }}
                                    </h2>

                                    <hr>

                                    <div class="mb-4">

                                        <small class="text-muted text-uppercase">
                                            {{ __('products\products-view.price') }}
                                        </small>

                                        <h1 class="text-success font-weight-bold mb-0">
                                            ${{ number_format($product->price, 2) }}
                                        </h1>

                                    </div>

                                    <table class="table table-borderless table-sm">

                                        <tr>
                                            <th width="120">{{ __('products\products-view.brand') }}</th>
                                            <td>{{ $product->brand }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ __('products\products-view.type') }}</th>
                                            <td><x-datatable.badges.product-type-badge :type="$product->type->getTypeName()" /></td>
                                        </tr>

                                        <tr>
                                            <th>{{ __('products\products-view.availability') }}</th>
                                            <td>
                                                <span>
                                                    {{ $product->available_stock }} - <x-datatable.badges.stock-level-badge :stock="$product->available_stock" />
                                                </span>
                                            </td>
                                        </tr>



                                    </table>

                                    <form method="GET">
                                        @csrf

                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <div class="form-group mt-4">

                                            <label class="form-label @error('quantity') text-danger @enderror">{{ __('products\products-view.quantity') }}</label>

                                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="1"
                                                min="1" max="{{ $product->stock }}" style="width:120px;">
                                            @error('quantity')
                                                <div class="label mb-2">
                                                    <span class="label-text-alt text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror


                                        </div>

                                        <div class="mt-4">

                                            <button class="btn btn-warning btn-lg">
                                                <i class="fas fa-shopping-cart"></i>
                                                {{ __('products\products-view.add_to_cart') }}
                                            </button>

                                            <button class="btn btn-success btn-lg" data-bs-toggle="modal"
                                                data-bs-target="#modal-order-product">
                                                {{ __('products\products-view.buy_now') }}
                                            </button>

                                            <x-modals.order-product-modal />

                                        </div>


                                    </form>



                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Description -->
                    <div class="card mt-2">

                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('products\products-view.product_description') }}
                            </h3>
                        </div>

                        <div class="card-body">

                            {{ $product->description }}

                        </div>

                    </div>

                </div>


</x-layouts.app>
