<x-layouts.guest>

    <x-slot:title>
        {{ __("about.title_about_us")}}
    </x-slot:title>

    <section class="hero bg-base-200 py-16">
        <div class="hero-content max-w-6xl flex-col">

            <!-- Heading -->
            <div class="text-center max-w-3xl mb-12">
                <h1 class="text-5xl font-bold mb-4">{{ __("about.about_openmind")}}</h1>
                <p class="text-lg text-base-content/70">
                    {{ __("about.about_intro")}}
                </p>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 w-full">

                <!-- Our Story -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-primary text-2xl">
                            📖 {{ __("about.our_story")}}
                        </h2>

                        <p>
                            {{ __("about.our_story_text_1")}}
                        </p>

                        <p>
                            {{ __("about.our_story_text_2")}}
                        </p>
                    </div>
                </div>

                <!-- Our Mission -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-secondary text-2xl">
                            🎯 {{ __("about.our_mission")}}
                        </h2>

                        <p>
                            {{ __("about.our_mission_text_1")}}
                        </p>

                        <p>
                            {{ __("about.our_mission_text_2")}}
                        </p>
                    </div>
                </div>

                <!-- What We Offer -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-accent text-2xl">
                            ✨ {{ __("about.what_we_offer")}}
                        </h2>

                        <ul class="space-y-3">
                            <li>📝 {{ __("about.offer_publish")}}</li>
                            <li>📚 {{ __("about.offer_discover")}}</li>
                            <li>💡 {{ __("about.offer_learn")}}</li>
                            <li>🌍 {{ __("about.offer_community")}}</li>
                        </ul>
                    </div>
                </div>

                <!-- Our Values -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-info text-2xl">
                            ❤️ {{ __("about.our_values")}}
                        </h2>

                        <div class="space-y-3">
                            <p><strong>{{ __("about.value_openness")}}</strong> – {{ __("about.value_openness_text")}}</p>
                            <p><strong>{{ __("about.value_respect")}}</strong> – {{ __("about.value_respect_text")}}</p>
                            <p><strong>{{ __("about.value_learning")}}</strong> – {{ __("about.value_leqarning_text")}}</p>
                            <p><strong>{{ __("about.value_innovation")}}</strong> – {{ __("about.value_innovation_text")}}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom CTA -->
            <div class="card bg-primary text-primary-content shadow-xl mt-12 w-full max-w-4xl">
                <div class="card-body text-center">
                    <h2 class="text-3xl font-bold">
                        {{ __("about.become_part_community")}}
                    </h2>

                    <p class="text-lg">
                        {{ __("about.community_cta")}}
                    </p>

                </div>
            </div>

        </div>
    </section>

</x-layouts.guest>
