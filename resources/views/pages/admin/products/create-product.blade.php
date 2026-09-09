<x-layouts.app>

    <x-slot:title>
        {{ __('products/products-create.create_product') }}
    </x-slot:title>


    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('products/products-create.new_product') }}</h1>

    <section class="w-50 mx-auto">

        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">{{ __('products/products-create.fill_fields_below') }}</div>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="input-group mb-3">
                        <span class="input-group-text @error('name') text-danger @enderror"
                            id="basic-addon1">{{ __('products/products-create.product_name') }}</span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ __('products/products-create.enter_product_name') }}"
                            value="{{ old('name') }}" aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    @error('name')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror


                    <div class="input-group mb-3">
                        <span class="input-group-text @error('brand') text-danger @enderror"
                            id="basic-addon1">{{ __('products/products-create.brand') }}</span>
                        <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
                            placeholder="{{ __('products/products-create.enter_brand_name') }}"
                            value="{{ old('brand') }}" aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    @error('brand')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span
                            class="input-group-text @error('brand') text-danger @enderror">{{ __('products/products-create.price') }}</span>
                        <input type="number" step="0.01" min=0 value="{{ old('price') }}" name="price"
                            class="form-control @error('price') is-invalid @enderror" required>
                        <span class="input-group-text">$</span>
                    </div>
                    @error('price')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text @error('product_type') text-danger @enderror">{{ __('products/products-create.type') }}</span>
                        <select id="productCategory" name="product_type"
                            class="form-select @error('product_type') is-invalid @enderror" required>
                            <option value="">{{ __('products/products-create.select_category') }}</option>
                            <option value="1" {{ old('product_type') == 1 ? 'selected' : '' }}>
                                {{ __('products/products-create.electronics') }}</option>
                            <option value="2" {{ old('product_type') == 2 ? 'selected' : '' }}>
                                {{ __('products/products-create.clothing') }}</option>
                            <option value="3" {{ old('product_type') == 3 ? 'selected' : '' }}>
                                {{ __('products/products-create.footwear') }}</option>
                            <option value="4" {{ old('product_type') == 4 ? 'selected' : '' }}>
                                {{ __('products/products-create.accessories') }}</option>
                            <option value="5" {{ old('product_type') == 5 ? 'selected' : '' }}>
                                {{ __('products/products-create.home_kitchen') }}</option>
                            <option value="6" {{ old('product_type') == 6 ? 'selected' : '' }}>
                                {{ __('products/products-create.furniture') }}</option>
                            <option value="7" {{ old('product_type') == 7 ? 'selected' : '' }}>
                                {{ __('products/products-create.beauty_personal_care') }}</option>
                            <option value="8" {{ old('product_type') == 8 ? 'selected' : '' }}>
                                {{ __('products/products-create.health_wellness') }}</option>
                            <option value="9" {{ old('product_type') == 9 ? 'selected' : '' }}>
                                {{ __('products/products-create.sports_outdoors') }}</option>
                            <option value="10" {{ old('product_type') == 10 ? 'selected' : '' }}>
                                {{ __('products/products-create.toys_games') }}</option>
                            <option value="11" {{ old('product_type') == 11 ? 'selected' : '' }}>
                                {{ __('products/products-create.books') }}</option>
                            <option value="12" {{ old('product_type') == 12 ? 'selected' : '' }}>
                                {{ __('products/products-create.office_supplies') }}</option>
                            <option value="13" {{ old('product_type') == 13 ? 'selected' : '' }}>
                                {{ __('products/products-create.automotive') }}</option>
                            <option value="14" {{ old('product_type') == 14 ? 'selected' : '' }}>
                                {{ __('products/products-create.pet_supplies') }}</option>
                            <option value="15" {{ old('product_type') == 15 ? 'selected' : '' }}>
                                {{ __('products/products-create.food_beverages') }}</option>
                            <option value="16" {{ old('product_type') == 16 ? 'selected' : '' }}>
                                {{ __('products/products-create.jewelry') }}</option>
                            <option value="17" {{ old('product_type') == 17 ? 'selected' : '' }}>
                                {{ __('products/products-create.watches') }}</option>
                            <option value="18" {{ old('product_type') == 18 ? 'selected' : '' }}>
                                {{ __('products/products-create.baby_products') }}</option>
                            <option value="19" {{ old('product_type') == 19 ? 'selected' : '' }}>
                                {{ __('products/products-create.garden_outdoor') }}</option>
                            <option value="20" {{ old('product_type') == 20 ? 'selected' : '' }}>
                                {{ __('products/products-create.tools_hardware') }}</option>
                            <option value="21" {{ old('product_type') == 21 ? 'selected' : '' }}>
                                {{ __('products/products-create.art_crafts') }}</option>
                            <option value="22" {{ old('product_type') == 22 ? 'selected' : '' }}>
                                {{ __('products/products-create.musical_instruments') }}</option>
                            <option value="23" {{ old('product_type') == 23 ? 'selected' : '' }}>
                                {{ __('products/products-create.software') }}</option>
                            <option value="24" {{ old('product_type') == 24 ? 'selected' : '' }}>
                                {{ __('products/products-create.digital_products') }}</option>
                            <option value="25" {{ old('product_type') == 25 ? 'selected' : '' }}>
                                {{ __('products/products-create.gift_cards') }}</option>
                        </select>
                    </div>
                    @error('product_type')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text @error('stock') text-danger @enderror">{{ __('products/products-create.initial_stock') }}</span>
                        <input type="number" min=0 step=1 value="{{ old('stock') }}" name="stock"
                            class="form-control @error('stock') is-invalid @enderror"
                            aria-label="Amount (to the nearest dollar)" required>
                    </div>
                    @error('stock')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                    @enderror


                    <div class="input-group mb-3">
                        <span class="input-group-text @error('description') text-danger @enderror">{{ __('products/products-create.description') }}</span>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" aria-label="With textarea"
                            style="height: 82px;" required>{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                    @enderror

                    <div class="input-group">
                        <span class="input-group-text @error('product_photos') text-danger @enderror">{{ __('products/products-create.pictures') }}</span>
                        <input type="file" multiple name="product_photos[]" class="form-control @error('product_photos') is-invalid @enderror">
                    </div>
                    @error('product_photos')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">{{ $message }}</span>
                            </div>
                     @enderror

                    <div class="d-flex mt-3 gap-2">
                        <input type="submit" value="{{ __('products/products-create.create_product_button') }}"
                            class="btn btn-success">
                        <input type="reset" value="{{ __('products/products-create.cancel') }}"
                            class="btn btn-secondary">
                    </div>
                </form>

            </div>
        </div>

    </section>


</x-layouts.app>
