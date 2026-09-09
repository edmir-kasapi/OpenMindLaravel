<x-layouts.guest>

    <x-slot:title>
        {{ __('contact.title_contact_us') }}
    </x-slot:title>

    <section class="hero min-h-[80vh] bg-base-200 py-10">
        <div class="hero-content w-full max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 w-full">

                <!-- Contact Information -->
                <div>
                    <h1 class="text-5xl font-bold mb-4">{{ __('contact.title_contact_us') }}</h1>
                    <p class="text-lg text-base-content/80 mb-6">
                        {{ __('contact.contact_intro') }}
                    </p>

                    <div class="space-y-4">
                        <div class="card bg-base-100 shadow">
                            <div class="card-body">
                                <h2 class="card-title">📧 {{ __('contact.email') }}</h2>
                                <p>openmind.support@gmail.com</p>
                            </div>
                        </div>

                        <div class="card bg-base-100 shadow">
                            <div class="card-body">
                                <h2 class="card-title">📍 {{ __('contact.address') }}</h2>
                                <p>123 Innovation Street<br>Tech City, TC 10001</p>
                            </div>
                        </div>


                        <div class="card bg-base-100 shadow">
                            <div class="card-body">
                                <h2 class="card-title">🕒 {{ __('contact.support_hours') }}</h2>
                                <p>{{ __('contact.monday_friday') }}</p>
                                <p>{{ __('contact.support_time') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-2xl mb-4">{{ __('contact.send_us_message') }}</h2>

                        <form action="{{ route('contact-mail.send') }}" method="POST">
                            @csrf

                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">{{ __('contact.name') }}</span>
                                </label>
                                <input type="text" name="name" class="input input-bordered w-full"
                                    placeholder="{{ __('contact.your_name') }}" required>
                            </div>
                            @error('name')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror

                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Email</span>
                                </label>
                                <input type="email" name="email" class="input input-bordered w-full"
                                    placeholder="{{ __('contact.email_placeholder') }}" required>
                            </div>
                            @error('email')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-red">{{ $message }}</span>
                                </div>
                            @enderror

                            <div class="form-control mb-6">
                                <label class="label-text">
                                    <span class="label-text">{{ __('contact.message') }}</span>
                                </label>
                                <textarea name="message" rows="6" class="textarea textarea-bordered"
                                    placeholder="{{ __('contact.write_message_here') }}" required></textarea>
                            </div>
                            @error('message')
                                <div class="label mb-2">
                                    <span class="label-text-alt text-red">{{ $message }}</span>
                                </div>
                            @enderror

                            <button type="submit" class="btn btn-primary w-full">
                                {{ __('contact.send_message') }}
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.guest>
