<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give / Tithe ❤️ - St. Johns Church</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom styles for church theme -->
    @include('partials.theme-config')
</head>

<body class="bg-gray-50 min-h-screen">

    @include('partials.navbar')


    <!-- GIVING / TITHE SECTION – Clean, Balanced & Shorter -->
    <section class="py-10 lg:py-10 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Header – Compact & Sacred -->
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-black text-primary mb-4">
                    Give / Tithe <span class="inline-block animate-pulse">❤️</span>
                </h1>
                <p class="text-xl text-gray-700 font-medium">
                    Supporting God’s Work at St. John’s Parish Church Entebbe
                </p>
                <div class="w-24 h-1 bg-accent mx-auto mt-6"></div>
            </div>

            <!-- Scripture – Short & Gold Highlight -->
            <div class="text-center mb-6 max-w-3xl mx-auto">
                <blockquote class="text-xl italic font-medium text-primary leading-relaxed">
                    “Each of you should give what you have decided in your heart to give,
                    not reluctantly or under compulsion, for God loves a cheerful giver.”
                </blockquote>
                <cite class="block mt-4 text-sm font-bold text-secondary uppercase tracking-wider">
                    — 2 Corinthians 9:7
                </cite>
            </div>
        </div>
    </section>

<!-- GIVING / TITHE SECTION – Perfectly Balanced (Form & Cards Match Height) -->
<section class="py-10 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Main Grid: Form left + Cards right (balanced) -->
        <div class="grid lg:grid-cols-3 gap-10 lg:gap-12">

            <!-- LEFT: Form – Tighter spacing to reduce height -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl p-6 lg:p-8 border-2 border-accent/20">
                <h2 class="text-3xl font-bold text-primary text-center mb-6">
                    Let Us Know Your Giving
                </h2>

                <!-- Messages -->
                <div id="message-container" class="mb-5 hidden">
                    <!-- your success/error divs -->
                </div>

                <form id="giving-form" class="space-y-5">
                    @csrf

                    <!-- Guest / Member Info -->
                    @auth
                        @if(auth()->user()->member)
                            <div class="bg-green-50 border border-green-200 rounded-2xl p-4 text-center text-sm">
                                Welcome back, <strong>{{ auth()->user()->member->full_name }}</strong>!
                                Your giving will be linked to your account.
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 text-center text-sm">
                                Welcome, {{ auth()->user()->name }}!
                                Please fill in your details below.
                            </div>
                        @endif
                    @endauth

                    <!-- Guest Fields -->
                    @if(!auth()->check() || !auth()->user()->member)
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold text-primary border-b border-gray-200 pb-2">
                                Your Information
                            </h3>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-primary mb-1">Full Name *</label>
                                    <input type="text" name="guest_name" required
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-primary mb-1">Email</label>
                                    <input type="email" name="guest_email"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                           placeholder="For receipt & confirmation">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-primary mb-1">Phone Number</label>
                                <input type="tel" name="guest_phone"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                       placeholder="For mobile money / updates">
                            </div>
                        </div>
                    @endif

                    <!-- Giving Details -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-primary border-b border-gray-200 pb-2">
                            Giving Details
                        </h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-primary mb-1">Type of Giving *</label>
                                <select name="giving_type" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                                    <!-- options unchanged -->
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-primary mb-1">Amount (UGX) *</label>
                                <input type="number" name="amount" required min="1000" step="100"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                       placeholder="e.g. 50000">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-1">Purpose / Designation</label>
                            <input type="text" name="purpose"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                   placeholder="e.g. Building Fund, Missions, Youth Ministry">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-1">Personal Message / Prayer Request</label>
                            <textarea name="notes" rows="2"
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition resize-none"
                                      placeholder="Share your heart or prayer request (optional)"></textarea>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-primary border-b border-gray-200 pb-2">
                            How would you like to give?
                        </h3>

                        <!-- your radio buttons (unchanged) -->
                        <!-- ... -->

                        <div id="payment-instructions" class="hidden mt-4 p-5 bg-gray-50 rounded-2xl border border-gray-200">
                            <!-- JS-filled -->
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full bg-secondary hover:bg-accent text-white font-bold text-xl py-5 rounded-2xl shadow-xl hover:shadow-accent/30 transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-3 mt-4">
                        <span>Submit My Giving</span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- RIGHT: Cards – Stacked vertically, slightly taller to match form -->
            <div class="flex flex-col gap-8 lg:min-h-[680px]"> <!-- min-h forces balance -->
                <!-- Security Card -->
                <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-lg border border-accent/20 flex-1">
                    <h3 class="text-xl font-bold text-primary mb-4 flex items-center gap-3">
                        <span class="text-accent text-2xl">🔒</span>
                        Secure & Transparent
                    </h3>
                    <ul class="space-y-2.5 text-sm text-gray-700">
                        <li class="flex items-start gap-2.5">
                            <span class="text-accent text-lg">✓</span>
                            All transactions encrypted & secure
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-accent text-lg">✓</span>
                            Instant digital receipt
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-accent text-lg">✓</span>
                            Full financial transparency reports
                        </li>
                    </ul>
                </div>

                <!-- Impact Card -->
                <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-lg border border-accent/20 flex-1">
                    <h3 class="text-xl font-bold text-primary mb-4 flex items-center gap-3">
                        <span class="text-accent text-2xl">🌟</span>
                        Your Impact
                    </h3>
                    <ul class="space-y-2.5 text-sm text-gray-700">
                        <li class="flex items-start gap-2.5">
                            <span class="text-accent text-lg">✓</span>
                            Local community outreach & food programs
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-accent text-lg">✓</span>
                            Youth, children & education support
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-accent text-lg">✓</span>
                            Church maintenance & missions
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Contact Note -->
        <div class="text-center mt-12 text-gray-600">
            <p class="text-lg">
                Questions? Contact us at 
                <a href="mailto:giving@stjohnsentebbe.org" class="text-secondary font-bold hover:text-accent transition">
                    giving@stjohnsentebbe.org
                </a>
                or call 
                <a href="tel:+256700123456" class="text-secondary font-bold hover:text-accent transition">
                    +256 700 123 456
                </a>
            </p>
            <p class="mt-3 text-sm italic text-gray-500">
                “God loves a cheerful giver” — thank you for your generosity.
            </p>
        </div>
    </div>
</section>

    <!-- Contact Note – Below both columns -->
    <div class="text-center mt-12 mb-4 text-gray-600">
        <p class="text-lg">
            Questions? Contact us at
            <a href="mailto:giving@stjohnsentebbe.org" class="text-secondary font-bold hover:text-accent transition">
                giving@stjohnsentebbe.org
            </a>
            or call
            <a href="tel:+256700123456" class="text-secondary font-bold hover:text-accent transition">
                +256 700 123 456
            </a>
        </p>
        <p class="mt-3 text-sm italic text-gray-500">
            “God loves a cheerful giver” — thank you for your generosity.
        </p>
    </div>
    </div>

    <!-- JavaScript for Form Handling -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('giving-form');
            const paymentMethod = document.getElementById('payment_method');
            const instructionsDiv = document.getElementById('payment-instructions');

            if (paymentMethod) {
                paymentMethod.addEventListener('change', (e) => {
                    const method = e.target.value;
                    instructionsDiv.innerHTML = '';

                    if (method === 'mobile_money') {
                        instructionsDiv.innerHTML = `
                        <div class="bg-red-50 border border-secondary/30 rounded-2xl p-6">
                        <h4 class="font-bold text-secondary mb-3">Mobile Money Instructions</h4>
                        <p class="text-gray-700">Send to: <strong>0700-123-456</strong> (St. John’s Church)</p>
                        <p class="text-sm text-gray-600 mt-2">Enter transaction ID below</p>
                        </div>
                        `;
                    } else if (method === 'bank_transfer') {
                        instructionsDiv.innerHTML = `
                        <div class="bg-red-50 border border-secondary/30 rounded-2xl p-6">
                        <h4 class="font-bold text-secondary mb-3">Bank Transfer Details</h4>
                        <p class="text-gray-700"><strong>Bank:</strong> Stanbic Bank Uganda</p>
                        <p class="text-gray-700"><strong>Account:</strong> 9030012345678</p>
                        <p class="text-gray-700"><strong>Name:</strong> St. John's Parish Church</p>
                        </div>
                        `;
                    }

                    if (method) instructionsDiv.classList.remove('hidden');
                    else instructionsDiv.classList.add('hidden');
                });
            }

            // Form submit (your existing code + improved UX)
            form?.addEventListener('submit', (e) => {
                // Your existing fetch logic here...
                // Add loading state
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = 'Processing...';
            });
        });
    </script>

    @include('partials.footer')
</body>

</html>