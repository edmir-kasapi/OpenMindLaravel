<x-layouts.app>

    <x-slot:title>
        {{ __('products/products-edit.edit_product_admin') }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('products/products-edit.inspecting_product') }}
        #{{ $product->id }}</h1>

    <div class="row">

        <div class="col">

            <section class="w-75 ms-auto">

                <div class="card card-warning card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">{{ __('products/products-edit.edit_fields_below') }}</div>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.products.update', $product->id) }}" method="post">
                            @csrf
                            @method('put')

                            <div class="input-group mb-3">
                                <span class="input-group-text @error('name') text-danger @enderror"
                                    id="basic-addon1">{{ __('products/products-edit.product_name') }}</span>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Product Name..." value="{{ old('email', $product->name) }}"
                                    aria-label="Username" aria-describedby="basic-addon1" required>
                            </div>
                            @error('name')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-danger">{{ $message }}</span>
                                </div>
                            @enderror


                            <div class="input-group mb-3">
                                <span class="input-group-text @error('brand') text-danger @enderror"
                                    id="basic-addon1">{{ __('products/products-edit.brand') }}</span>
                                <input type="text" name="brand"
                                    class="form-control @error('brand') is-invalid @enderror"
                                    placeholder="Enter Brand Name..." value="{{ old('brand', $product->brand) }}"
                                    aria-label="Username" aria-describedby="basic-addon1" required>
                            </div>
                            @error('brand')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-danger">{{ $message }}</span>
                                </div>
                            @enderror

                            <div class="input-group mb-3">
                                <span
                                    class="input-group-text @error('price') text-danger @enderror">{{ __('products/products-edit.price') }}</span>
                                <input type="number" step="0.01" min=0 value="{{ old('price', $product->price) }}"
                                    name="price" class="form-control @error('price') is-invalid @enderror" required>
                                <span class="input-group-text">$</span>
                            </div>
                            @error('price')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-danger">{{ $message }}</span>
                                </div>
                            @enderror

                            <div class="input-group mb-3">
                                <span
                                    class="input-group-text @error('product_type') text-danger @enderror">{{ __('products/products-edit.type') }}</span>
                                <select id="productCategory" name="product_type"
                                    class="form-select @error('product_type') is-invalid @enderror" required>
                                    <option value="">{{ __('products/products-edit.select_category') }}</option>
                                    <option value="1"
                                        {{ old('product_type', $product->type->id) == 1 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.electronics') }}</option>
                                    <option value="2"
                                        {{ old('product_type', $product->type->id) == 2 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.clothing') }}</option>
                                    <option value="3"
                                        {{ old('product_type', $product->type->id) == 3 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.footwear') }}</option>
                                    <option value="4"
                                        {{ old('product_type', $product->type->id) == 4 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.accessories') }}</option>
                                    <option value="5"
                                        {{ old('product_type', $product->type->id) == 5 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.home_kitches') }}</option>
                                    <option value="6"
                                        {{ old('product_type', $product->type->id) == 6 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.furniture') }}</option>
                                    <option value="7"
                                        {{ old('product_type', $product->type->id) == 7 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.beauty_personal_care') }}</option>
                                    <option value="8"
                                        {{ old('product_type', $product->type->id) == 8 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.health_wellness') }}</option>
                                    <option value="9"
                                        {{ old('product_type', $product->type->id) == 9 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.sports_outdoors') }}</option>
                                    <option value="10"
                                        {{ old('product_type', $product->type->id) == 10 ? 'selected' : '' }}>

                                        {{ __('products/products-edit.toys_games') }}</option>
                                    <option value="11"
                                        {{ old('product_type', $product->type->id) == 11 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.books') }}</option>
                                    <option value="12"
                                        {{ old('product_type', $product->type->id) == 12 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.office_supplies') }}</option>
                                    <option value="13"
                                        {{ old('product_type', $product->type->id) == 13 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.automotive') }}</option>
                                    <option value="14"
                                        {{ old('product_type', $product->type->id) == 14 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.pet_supplies') }}</option>
                                    <option value="15"
                                        {{ old('product_type', $product->type->id) == 15 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.food_beverages') }}</option>
                                    <option value="16"
                                        {{ old('product_type', $product->type->id) == 16 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.jewelry') }}</option>
                                    <option value="17"
                                        {{ old('product_type', $product->type->id) == 17 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.watches') }}</option>
                                    <option value="18"
                                        {{ old('product_type', $product->type->id) == 18 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.baby_products') }}</option>
                                    <option value="19"
                                        {{ old('product_type', $product->type->id) == 19 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.garden_outdoor') }}</option>
                                    <option value="20"
                                        {{ old('product_type', $product->type->id) == 20 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.tools_hardware') }}</option>
                                    <option value="21"
                                        {{ old('product_type', $product->type->id) == 21 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.art_crafts') }}</option>
                                    <option value="22"
                                        {{ old('product_type', $product->type->id) == 22 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.musical_instruments') }}</option>
                                    <option value="23"
                                        {{ old('product_type', $product->type->id) == 23 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.software') }}</option>
                                    <option value="24"
                                        {{ old('product_type', $product->type->id) == 24 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.digital_products') }}</option>
                                    <option value="25"
                                        {{ old('product_type', $product->type->id) == 25 ? 'selected' : '' }}>
                                        {{ __('products/products-edit.gift_cards') }}</option>
                                </select>

                            </div>
                            @error('product_type')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-danger">{{ $message }}</span>
                                </div>
                            @enderror

                            <div class="input-group mb-3">
                                <span
                                    class="input-group-text @error('stock') text-danger @enderror">{{ __('products/products-edit.stock') }}</span>
                                <input type="number" min=0 step=1 value="{{ old('stock', $product->stock) }}"
                                    name="stock" class="form-control @error('stock') is-invalid @enderror"
                                    aria-label="Amount (to the nearest dollar)" required>
                            </div>
                            @error('stock')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-danger">{{ $message }}</span>
                                </div>
                            @enderror


                            <div class="input-group">
                                <span
                                    class="input-group-text @error('description') text-danger @enderror">{{ __('products/products-edit.description') }}</span>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" aria-label="With textarea"
                                    style="height: 82px;" required>{{ old('description', $product->name) }}</textarea>
                            </div>
                            @error('description')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-danger">{{ $message }}</span>
                                </div>
                            @enderror

                            <div class="d-flex mt-3 gap-2">
                                <input type="submit" value="{{ __('products/products-edit.edit_product_button') }}"
                                    class="btn btn-warning">
                                <input type="reset" value="{{ __('products/products-edit.cancel') }}"
                                    class="btn btn-secondary">
                            </div>
                        </form>

                    </div>
                    <div class="d-flex mt-3 gap-2 card-footer">
                        <a href="{{ route('admin.products') }}">
                            <button class="btn btn-dark"> {{ __('products/products-edit.back') }} </button>
                        </a>

                        <x-datatable.buttons.action-button action-class="delete-product" :data-id="$product->id"
                            redirect="true" modal-id="modal-delete-product" icon="journal-minus" type="danger" />

                    </div>
                </div>

            </section>

        </div>

        <div class="col">

            <section class="card card-dark card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ __('products/products-edit.pictures') }}</h3>
                </div>

                <div class="card-body">

                    @if ($product->pictures->count())

                        <div id="editProductCarousel" class="carousel slide rounded overflow-hidden bg-dark shadow-sm"
                            data-bs-interval="false">

                            <div class="carousel-inner">

                                @foreach ($product->pictures as $picture)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

                                        <div class="position-relative d-flex justify-content-center align-items-center"
                                            style="height:400px;">

                                            <img src="{{ asset('storage/products/' . $picture->getSrc()) }}"
                                                class="img-fluid" style="max-height:100%; object-fit:contain;"
                                                alt="Product image">

                                            <form action="{{ route('admin.products.pictures.remove', $picture->id) }}"
                                                method="post" class="position-absolute top-0 mx-auto">
                                                @csrf
                                                @method('DELETE')
                                                {{-- hidden fields --}}


                                                <button type="submit"
                                                    class="btn btn-danger btn-sm rounded-circle shadow"
                                                    style="width:40px;height:40px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

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
                                {{ __('products/products-edit.no_pictures') }}
                            </p>
                        </div>

                    @endif

                </div>

            </section>

            <section class="card card-info card-outline mt-2">

                <div class="card-header">
                    {{ __('products/products-edit.add_pictures') }}
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.products.pictures.add', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="input-group mb-3">
                            <span
                                class="input-group-text @error('product_photos') text-danger @enderror">{{ __('products/products-edit.pictures') }}</span>
                            <input type="file" multiple name="product_photos[]" class="form-control @error('product_photos') is-invalid @enderror">
                        </div>
                        @error('product_photos')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                        @enderror

                        <input type="submit" class="btn btn-info" value="{{ __('products/products-edit.add') }}">

                    </form>
                </div>

            </section>

        </div>

    </div>

    <x-modals.danger-modal id="modal-delete-product" title="{{ __('modals/delete-product-modal.delete_product') }}"
        message="{{ __('modals/delete-product-modal.delete_product_confirmation') }}" form-id="delete-product-form"
        submit-text="{{ __('modals/delete-product-modal.delete') }}" method='DELETE' />

    <div id="products-config" data-products-url="{{ route('admin.products') }}"
        data-delete-url="{{ url('/admin/products/delete') }}">
    </div>

</x-layouts.app>
