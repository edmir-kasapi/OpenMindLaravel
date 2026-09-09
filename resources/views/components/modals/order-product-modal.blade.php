<!--begin::Order Product Modal-->
<div class="modal fade" id="modal-order-product" tabindex="-1" aria-labelledby="modal-add-user-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-user-label">Purchase Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('common.close') }}"></button>
                </div>
                <div class="modal-body">
                    <section>

                        <div class="form-group">
                            <label class="form-label @error('address') text-danger @enderror">Address</label>
                            <input
                                type="text"
                                name="address"
                                class="form-control @error('address') is-invalid @enderror"
                                placeholder="Enter address here..."
                                required
                                value="{{ old('address') }}">
                        </div>
                        @error('order-address')
                            <div class="label mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                    </section>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('modals/user-modal.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-primary" formaction="{{ route('checkout') }}">
                        Place Order
                    </button>
                </div>
        </div>
    </div>
</div>
<!--end::Order Product Modal-->
