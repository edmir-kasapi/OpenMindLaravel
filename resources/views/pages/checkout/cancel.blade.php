<x-layouts.app>

    <x-slot:title>
        Payment Cancelled
    </x-slot:title>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card card-danger card-outline">
                    <div class="card-body text-center p-5">

                        <div class="mb-4">
                            <i class="fas fa-times-circle fa-5x text-danger"></i>
                        </div>

                        <h2 class="mb-3">Payment Cancelled</h2>

                        <p class="text-muted mb-4">
                            Your checkout was cancelled before the payment was completed.
                        </p>

                        <div class="alert alert-warning">
                            No payment has been charged. You can try again whenever you're ready.
                        </div>

                        <a href="{{ route('checkout.retry', $order->id) }}" class="btn btn-primary mr-2">
                            <i class="fas fa-redo mr-1"></i>
                            Try Again
                        </a>

                        <a href="{{ route('user.home') }}" class="btn btn-secondary">
                            <i class="fas fa-home mr-1"></i>
                            Back to Home
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.app>
