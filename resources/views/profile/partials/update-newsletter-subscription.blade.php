<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Newsletter Subscription') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Manage your subscription to weekly sermons and church updates.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if (session('newsletter-success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-md">
                <p class="text-sm text-green-800">{{ session('newsletter-success') }}</p>
            </div>
        @endif

        @if (session('newsletter-error'))
            <div class="p-4 bg-red-50 border border-red-200 rounded-md">
                <p class="text-sm text-red-800">{{ session('newsletter-error') }}</p>
            </div>
        @endif

        @if ($errors->has('newsletter_subscribe'))
            <div class="p-4 bg-red-50 border border-red-200 rounded-md">
                <p class="text-sm text-red-800">{{ $errors->first('newsletter_subscribe') }}</p>
            </div>
        @endif

        <form method="post" action="{{ route('profile.newsletter.toggle') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex-1">
                    <label for="newsletter_subscribe" class="font-medium text-gray-900">
                        {{ __('Subscribe to Newsletter') }}
                    </label>
                    <p class="text-sm text-gray-600 mt-1">
                        @if (auth()->user()->member && auth()->user()->member->isSubscribedToNewsletter())
                            {{ __('You are currently subscribed. You will receive weekly sermons and updates.') }}
                        @else
                            {{ __('Subscribe to receive weekly sermons and church updates via email.') }}
                        @endif
                    </p>
                    @if (auth()->user()->member && auth()->user()->member->newsletter_subscribed_at)
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Subscribed on: ') . auth()->user()->member->newsletter_subscribed_at->format('M d, Y') }}
                        </p>
                    @endif
                </div>

                <div class="ml-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="newsletter_subscribe" 
                            id="newsletter_subscribe"
                            value="1"
                            class="sr-only peer"
                            {{ (auth()->user()->member && auth()->user()->member->isSubscribedToNewsletter()) ? 'checked' : '' }}
                            onchange="this.form.submit()"
                        >
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            <noscript>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Update Subscription') }}</x-primary-button>
                </div>
            </noscript>
        </form>

        @if (!auth()->user()->member || !auth()->user()->member->email)
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                <p class="text-sm text-yellow-800">
                    {{ __('You need to have an email address associated with your member profile to subscribe to the newsletter.') }}
                </p>
            </div>
        @endif
    </div>
</section>
