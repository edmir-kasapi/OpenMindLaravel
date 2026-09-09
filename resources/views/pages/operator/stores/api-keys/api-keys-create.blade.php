<x-layouts.app>

    <x-slot:title>
        {{ __('stores\api-keys.create_api_key') }} - {{ $store->name }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('stores\api-keys.register_your_new_token') }}</h1>

    <section class="w-50 mx-auto">

        <div class="card card-dark card-outline mb-4">
            <div class="card-header">
                <div class="card-title">{{ __('stores\api-keys.fill_fields_below') }}</div>
            </div>
            <div class="card-body">

                <form action="{{ route('operator.stores.api-keys.store', $store) }}" method="post">
                    @csrf

                    {{-- Token Name --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text @error('name') text-danger @enderror" id="token-name-label">
                            {{ __('stores\api-keys.token_name') }}
                        </span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ __('stores\api-keys.token_name_placeholder') }}" value="{{ old('name') }}" aria-label="Token name"
                            aria-describedby="token-name-label" required maxlength="100">
                    </div>
                    @error('name')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">
                                {{ $message }}
                            </span>
                        </div>
                    @enderror


                    {{-- Abilities --}}
                    <div class="mb-3">

                        <label class="form-label">
                            {{ __('stores\api-keys.permissions') }}
                        </label>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="abilities[]" value="products:read"
                                id="productsRead"
                                {{ in_array('products:read', old('abilities', ['products:read', 'collections:read'])) ? 'checked' : '' }}>

                            <label class="form-check-label" for="productsRead">
                                {{ __('stores\api-keys.view_products') }}
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="abilities[]" value="collections:read"
                                id="collectionsRead"
                                {{ in_array('collections:read', old('abilities', ['products:read', 'collections:read'])) ? 'checked' : '' }}>

                            <label class="form-check-label" for="collectionsRead">
                                {{ __('stores\api-keys.view_collections') }}
                            </label>
                        </div>

                        @error('abilities')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">
                                    {{ $message }}
                                </span>
                            </div>
                        @enderror

                        @error('abilities.*')
                            <div class="label mb-2">
                                <span class="label-text-alt text-danger">
                                    {{ $message }}
                                </span>
                            </div>
                        @enderror

                    </div>


                    {{-- Token Duration --}}
                    <div class="input-group mb-3">

                        <span class="input-group-text @error('duration') text-danger @enderror"
                            id="token-duration-label">
                            {{ __('stores\api-keys.token_duration') }}
                        </span>

                        <select name="duration" class="form-select @error('duration') is-invalid @enderror"
                            id="tokenDuration" aria-describedby="token-duration-label" required>
                            <option value="never" {{ old('duration', 'never') === 'never' ? 'selected' : '' }}>
                                {{ __('stores\api-keys.never_expires') }}
                            </option>

                            <option value="30" {{ old('duration') === '30' ? 'selected' : '' }}>
                               {{ __('stores\api-keys.days_30') }}
                            </option>

                            <option value="90" {{ old('duration') === '90' ? 'selected' : '' }}>
                                {{ __('stores\api-keys.days_90') }}
                            </option>

                            <option value="365" {{ old('duration') === '365' ? 'selected' : '' }}>
                                {{ __('stores\api-keys.year_1') }}
                            </option>
                        </select>
                    </div>
                    @error('duration')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">
                                {{ $message }}
                            </span>
                        </div>
                    @enderror


                    {{-- Actions --}}
                    <div class="d-flex mt-3 gap-2">

                        <input type="submit" value="{{ __('stores\api-keys.generate_api_key') }}" class="btn btn-dark">

                        <input type="reset" value="{{ __('stores\api-keys.reset') }}" class="btn btn-secondary">

                    </div>

                </form>

            </div>
        </div>

    </section>

</x-layouts.app>
