<x-layouts.app>

    <x-slot:title>
        Payment Successful
    </x-slot:title>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card card-success card-outline">
                    <div class="card-body text-center p-5">

                        <div class="mb-4">
                            <i class="fas fa-check-circle fa-5x text-success"></i>
                        </div>

                        <h2 class="mb-3">Payment Successful</h2>

                        <p class="text-muted mb-4">
                            Thank you! Your payment has been processed successfully.
                        </p>

                        <div class="alert alert-success">
                            A confirmation email has been sent, and your order is now being processed.
                        </div>


                    <dl class="row text-left">
                        <dt class="col-5">Order</dt>
                        <dd class="col-7">#{{ $order->id }}</dd>

                        <dt class="col-5">Product</dt>
                        <dd class="col-7">{{ $order->product->name }}</dd>

                        <dt class="col-5">Quantity</dt>
                        <dd class="col-7">{{ $order->quantity }}</dd>

                        <dt class="col-5">Address</dt>
                        <dd class="col-7">{{ $order->address }}</dd>

                        <dt class="col-5">Amount</dt>
                        <dd class="col-7">${{ $order->total_price }}</dd>
                    </dl>


                        <a href="{{ route('user.products') }}" class="btn btn-success">
                            <i class="fas fa-home mr-1"></i>
                            Continue
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.app>
