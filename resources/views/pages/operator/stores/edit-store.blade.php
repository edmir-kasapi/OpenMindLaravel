<x-layouts.app>

    <x-slot:title>
        {{ __('stores\stores.edit_store_operator') }}
    </x-slot:title>

    <h1 class="w-25 mx-auto text-center display-4 mt-3 mb-4">{{ __('stores\stores.editing_store') }} #{{ $store->id }}</h1>

    <section class="w-50 mx-auto">

        <div class="card card-warning card-outline mb-4">
            <div class="card-header">
                <div class="card-title">{{ __('stores\stores.fill_fields_below') }}</div>
            </div>
            <div class="card-body">

                <form action="{{ route('operator.stores.update', $store->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="input-group mb-3">
                        <span class="input-group-text @error('name') text-danger @enderror" id="basic-addon1">Store
                            {{ __('stores\stores.store_name') }}</span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ __('stores\stores.enter_store_name') }}" value="{{ old('name', $store->name) }}"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    @error('name')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text @error('country') text-danger @enderror"> Country </span>
                        <select id="storeCountry" name="country"
                            class="form-select tomselected ts-hidden-accessible @error('country') is-invalid @enderror"
                            required>
                            <option value=""> {{ __('stores\stores.select_country') }} </option>
                            <option value="Albania"
                                {{ old('country', $store->country) == 'Albania' ? 'selected' : '' }}>
                                Albania </option>
                            <option value="United States"
                                {{ old('country', $store->country) == 'United States' ? 'selected' : '' }}>
                                United States </option>
                            <option value="United Kingdom"
                                {{ old('country', $store->country) == 'United Kingdom' ? 'selected' : '' }}>
                                United Kingdom </option>
                            <option value="Germany"
                                {{ old('country', $store->country) == 'Germany' ? 'selected' : '' }}>
                                Germany </option>
                            <option value="France" {{ old('country', $store->country) == 'France' ? 'selected' : '' }}>
                                France </option>
                            <option value="Italy" {{ old('country', $store->country) == 'Italy' ? 'selected' : '' }}>
                                Italy </option>
                            <option value="Spain" {{ old('country', $store->country) == 'Spain' ? 'selected' : '' }}>
                                Spain </option>
                            <option value="Canada" {{ old('country', $store->country) == 'Canada' ? 'selected' : '' }}>
                                Canada </option>
                            <option value="Australia"
                                {{ old('country', $store->country) == 'Australia' ? 'selected' : '' }}>
                                Australia </option>
                            <option value="Japan" {{ old('country', $store->country) == 'Japan' ? 'selected' : '' }}>
                                Japan </option>
                            <option value="China" {{ old('country', $store->country) == 'China' ? 'selected' : '' }}>
                                China </option>
                            <option value="South Korea"
                                {{ old('country', $store->country) == 'South Korea' ? 'selected' : '' }}>
                                South Korea </option>
                            <option value="Mexico" {{ old('country', $store->country) == 'Mexico' ? 'selected' : '' }}>
                                Mexico </option>
                            <option value="Brazil" {{ old('country', $store->country) == 'Brazil' ? 'selected' : '' }}>
                                Brazil </option>
                            <option value="Argentina"
                                {{ old('country', $store->country) == 'Argentina' ? 'selected' : '' }}>
                                Argentina </option>
                        </select>
                    </div>
                    @error('country')
                        <div class="label mb-2"> <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text @error('address') text-danger @enderror"
                            id="basic-addon1">{{ __('stores\stores.address') }}</span>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                            placeholder="{{ __('stores\stores.enter_store_address') }}" value="{{ old('address', $store->address) }}"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    @error('address')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="input-group mb-3"> <!-- pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" -->
                        <span class="input-group-text @error('phone') text-danger @enderror"
                            id="basic-addon1">{{ __('stores\stores.phone') }}</span>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            placeholder="{{ __('stores\stores.enter_store_phone') }}" value="{{ old('phone', $store->phone) }}"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    @error('phone')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text  @error('domain') text-danger @enderror" id="basic-addon1">{{ __('stores\stores.website_url') }}</span>
                        <input type="url" name="domain" class="form-control @error('domain') is-invalid @enderror"
                            placeholder="{{ __('stores\stores.enter_store_website_url') }}" value="{{ old('domain', $store->domain) }}"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    @error('domain')
                        <div class="label mb-2">
                            <span class="label-text-alt text-danger">{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="d-flex mt-3 gap-2">
                        <input type="submit" value="{{ __('stores\stores.save_changes') }}" class="btn btn-warning">
                        <input type="reset" value="{{ __('stores\stores.reset') }}" class="btn btn-secondary">
                        <x-datatable.buttons.action-button action-class="disable-store" :data-id="$store->id"
                            :redirect="true" modal-id="modal-disable-store" icon="x-lg" type="danger" />
                    </div>
                </form>
            </div>
        </div>

    </section>

    <x-modals.danger-modal id="modal-disable-store" title="{{ __('stores\stores.disable_store') }}"
        message="{{ __('stores\stores.disable_store_confirmation') }}"
        form-id="operator-disable-store-form" submit-text="{{ __('stores\stores.disable') }}" method='DELETE' />

    <div id="operator-stores-config" data-delete-url="{{ url('operator/stores/delete') }}">
    </div>

</x-layouts.app>
