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


    <!-- GIVING / TITHE PAGE – Sacred, Trustworthy & Beautiful -->
    <section class="py-16 lg:py-20 bg-background-light">
        <div class="max-w-5xl mx-auto px-6">

            <!-- Hero Header – Warm & Inviting -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-black text-primary mb-4">
                    Give / Tithe <span class="inline-block animate-pulse">❤️</span>
                </h1>
                <p class="text-xl text-gray-700 font-medium">
                    Supporting God’s Work at St. John’s Parish Church Entebbe
                </p>
                <div class="w-24 h-1 bg-accent mx-auto mt-6"></div>
            </div>

            <!-- Scripture – Centered, Gold Accent -->
            <div class="text-center mb-12 max-w-3xl mx-auto">
                <blockquote class="text-xl md:text-2xl italic font-medium text-primary leading-relaxed">
                    “Each of you should give what you have decided in your heart to give,
                    not reluctantly or under compulsion, for God loves a cheerful giver.”
                </blockquote>
                <cite class="block mt-4 text-sm font-bold text-secondary uppercase tracking-wider">
                    — 2 Corinthians 9:7
                </cite>
            </div>

            <!-- Main Form Card – Clean, Shadowed, Gold Border -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border-2 border-accent/30 max-w-3xl mx-auto">
                <h2 class="text-3xl font-bold text-primary text-center mb-10">
                    Let Us Know Your Giving
                </h2>

                <!-- Messages -->
                <div id="message-container" class="mb-8 hidden">
                    <div id="success-message"
                        class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl hidden">
                        <strong class="block mb-1">Thank you!</strong>
                        <span id="success-text"></span>
                    </div>
                    <div id="error-message"
                        class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl hidden">
                        <strong class="block mb-1">Error:</strong>
                        <span id="error-text"></span>
                    </div>
                </div>

                <form id="giving-form" class="space-y-8">
                    @csrf

                    <!-- Guest / Member Info -->
                    @auth
                        @if(auth()->user()->member)
                            <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
                                <p class="text-green-800 font-medium">
                                    Welcome back, <strong>{{ auth()->user()->member->full_name }}</strong>!
                                </p>
                                <p class="text-green-700 text-sm mt-1">
                                    Your giving will be linked to your member account.
                                </p>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
                                <p class="text-yellow-800 font-medium">
                                    Welcome, {{ auth()->user()->name }}!
                                </p>
                                <p class="text-yellow-700 text-sm mt-1">
                                    Please fill in your details below.
                                </p>
                            </div>
                        @endif
                    @endauth

                    <!-- Guest Fields (if not member) -->
                    @if(!auth()->check() || !auth()->user()->member)
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold text-primary border-b border-gray-200 pb-3">
                                Your Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-primary mb-2">Full Name *</label>
                                    <input type="text" name="guest_name" required
                                        class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-primary mb-2">Email</label>
                                    <input type="email" name="guest_email"
                                        class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                        placeholder="For receipt & confirmation">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-primary mb-2">Phone Number</label>
                                <input type="tel" name="guest_phone"
                                    class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                    placeholder="For mobile money / updates">
                            </div>
                        </div>
                    @endif

                    <!-- Giving Details -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-primary border-b border-gray-200 pb-3">
                            Giving Details
                        </h3>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-primary mb-2">Type of Giving *</label>
                                <select name="giving_type" required
                                    class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                                    <option value="">Select type</option>
                                    <option value="tithe">Tithe (10% of income)</option>
                                    <option value="offering">Offering (Freewill gift)</option>
                                    <option value="donation">Donation (Specific cause)</option>
                                    <option value="special_offering">Special Offering</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-primary mb-2">Amount (UGX) *</label>
                                <input type="number" name="amount" required min="1000" step="100"
                                    class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                    placeholder="e.g. 50000">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-2">Purpose / Designation</label>
                            <input type="text" name="purpose"
                                class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                placeholder="e.g. Building Fund, Missions, Youth Ministry">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-2">Personal Message / Prayer
                                Request</label>
                            <textarea name="notes" rows="3"
                                class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition resize-none"
                                placeholder="Share your heart or prayer request (optional)"></textarea>
                        </div>
                    </div>

                    <!-- Payment Method – Clean & Clear -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-primary border-b border-gray-200 pb-3">
                            How would you like to give?
                        </h3>

                        <div class="grid md:grid-cols-2 gap-6">
                            <label
                                class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-secondary transition">
                                <input type="radio" name="payment_method" value="mobile_money"
                                    class="w-5 h-5 text-secondary">
                                <span class="font-medium text-gray-800"> Mobile Money (MTN/Airtel)</span>
                            </label>

                            <label
                                class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-secondary transition">
                                <input type="radio" name="payment_method" value="bank_transfer"
                                    class="w-5 h-5 text-secondary">
                                <span class="font-medium text-gray-800">Bank Transfer</span>
                            </label>

                            <label
                                class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-secondary transition">
                                <input type="radio" name="payment_method" value="cash" class="w-5 h-5 text-secondary">
                                <span class="font-medium text-gray-800">Cash (In-person)</span>
                            </label>

                            <label
                                class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-secondary transition">
                                <input type="radio" name="payment_method" value="card" class="w-5 h-5 text-secondary">
                                <span class="font-medium text-gray-800">Credit/Debit Card</span>
                            </label>
                        </div>

                        <!-- Payment Instructions (shown via JS) -->
                        <div id="payment-instructions"
                            class="hidden mt-6 p-6 bg-gray-50 rounded-2xl border border-gray-200">
                            <!-- Content filled by JS based on selection -->
                        </div>
                    </div>

                    <!-- Submit – Big, Red, Gold Hover -->
                    <button type="submit"
                        class="w-full bg-secondary hover:bg-accent text-white font-bold text-xl py-6 rounded-2xl shadow-2xl hover:shadow-accent/30 transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-3">
                        <span>Submit My Giving</span>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Trust & Impact Cards – Two-column, Gold Accents -->
            <div class="grid md:grid-cols-2 gap-8 mt-16">
                <div class="bg-white p-8 rounded-3xl shadow-lg border border-accent/20">
                    <h3 class="text-2xl font-bold text-primary mb-4 flex items-center gap-3">
                        <span class="text-accent text-3xl">🔒</span>
                        Secure & Transparent
                    </h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start gap-3">
                            <span class="text-accent text-xl">✓</span>
                            All transactions encrypted & secure
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-accent text-xl">✓</span>
                            Instant digital receipt
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-accent text-xl">✓</span>
                            Full financial transparency reports
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-lg border border-accent/20">
                    <h3 class="text-2xl font-bold text-primary mb-4 flex items-center gap-3">
                        <span class="text-accent text-3xl">🌟</span>
                        Your Impact
                    </h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start gap-3">
                            <span class="text-accent text-xl">✓</span>
                            Local community outreach & food programs
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-accent text-xl">✓</span>
                            Youth, children & education support
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-accent text-xl">✓</span>
                            Church maintenance & missions
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact & Final Note -->
            <div class="text-center mt-16 text-gray-600">
                <p class="text-lg">
                    Questions? Contact us at
                    <a href="mailto:giving@stjohnsentebbe.org"
                        class="text-secondary font-bold hover:text-accent transition">
                        giving@stjohnsentebbe.org
                    </a>
                    or call
                    <a href="tel:+256700123456" class="text-secondary font-bold hover:text-accent transition">
                        +256 700 123 456
                    </a>
                </p>
                <p class="mt-4 text-sm italic text-gray-500">
                    “God loves a cheerful giver” — thank you for your generosity.
                </p>
            </div>
        </div>
    </section>

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