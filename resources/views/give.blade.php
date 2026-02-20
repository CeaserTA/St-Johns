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


    <!-- Scripture Encouragement Section -->
    <section class="page-hero bg-[#0c1b3a] py-14 px-10 relative overflow-hidden text-center">
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 serif leading-none pointer-events-none select-none" style="font-size:420px; color:rgba(200,151,58,0.04);">✝</div>
        <div class="relative z-10 max-w-[680px] mx-auto">
            <p class="eyebrow fade-up text-white justify-center">Stewardship · Generosity · Faith</p>
            <h1 class="serif fade-up fade-up-1 font-semibold text-white leading-[0.95] tracking-tight mt-4 mb-5"
                style="font-size:clamp(48px,8vw,84px);">
                Give with a<br><em class="italic text-[#e8b96a] font-light">Cheerful Heart</em>
            </h1>
            <p class="fade-up fade-up-2 text-sm font-light text-white/50 leading-[1.85] max-w-[480px] mx-auto">
                Your generosity is an act of worship. Every gift — great or small — helps us serve our community, support ministry, and spread the love of Christ.
            </p>
            <p class="fade-up fade-up-3 serif text-[15px] italic text-white/30 mt-5">
                "God loves a cheerful giver." — 2 Corinthians 9:7
            </p>
        </div>
    </section>


    <!-- Main Content Grid: Form centered -->
    <div>

        <!-- Form – Centered -->
        <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl p-6 lg:p-8 border-2 border-accent/20">
            <h2 class="text-2xl md:text-3xl font-bold text-primary text-center mb-4">
                Let Us Know Your Giving
            </h2>

            <!-- Messages -->
            <div id="message-container" class="mb-5 hidden">
                <div id="success-message"
                    class="bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-xl hidden">
                    <strong>Thank you!</strong> <span id="success-text"></span>
                </div>
                <div id="error-message"
                    class="bg-red-50 border border-red-200 text-red-800 px-5 py-3 rounded-xl hidden">
                    <strong>Error:</strong> <span id="error-text"></span>
                </div>
            </div>

            <form id="giving-form" class="space-y-4">
                @csrf

                <!-- Guest / Member Info -->
                @auth
                    @if(auth()->user()->member)
                        <div class="bg-green-50 border border-green-200 rounded-2xl p-2 text-center text-sm">
                            Welcome back, <strong>{{ auth()->user()->member->full_name }}</strong>!
                            Your giving will be linked to your account.
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-2 text-center text-sm">
                            Welcome, {{ auth()->user()->name }}!
                            Please fill in your details below.
                        </div>
                    @endif
                @endauth

                <!-- Guest Fields -->
                @if(!auth()->check() || !auth()->user()->member)
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-primary border-b border-gray-200 pb-2">
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
                    <h3 class="text-lg font-bold text-primary border-b border-gray-200 pb-2">
                        Giving Details
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-primary mb-1">Type of Giving *</label>
                            <select name="giving_type" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                                <option value="">Select type</option>
                                <option value="tithe">Tithe (10% of income)</option>
                                <option value="offering">Offering (Freewill gift)</option>
                                <option value="donation">Donation (Specific cause)</option>
                                <option value="special_offering">Special Offering</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-1">Amount (UGX) *</label>
                            <input type="number" name="amount" required min="1000" step="100"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                                placeholder="e.g. 50000">
                            <input type="hidden" name="currency" value="UGX">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-primary mb-1">Purpose / Designation</label>
                        <input type="text" name="purpose"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"
                            placeholder="e.g. Building Fund, Missions, Youth Ministry">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-primary mb-1">Personal Message / Prayer
                            Request</label>
                        <textarea name="notes" rows="2"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition resize-none"
                            placeholder="Share your heart or prayer request (optional)"></textarea>
                    </div>
                </div>

                <!-- Payment Method -->
                    <div class="payment-method space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Payment Method</h3>
                        
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">
                                How would you like to give? <span class="text-red-500">*</span>
                            </label>
                            <select id="payment_method" name="payment_method" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select payment method</option>
                                <option value="cash">Cash (In-person)</option>
                                <option value="mobile_money">Mobile Money (MTN/Airtel)</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="check">Check</option>
                            </select>
                        </div>

                        <!-- Payment Details (shown based on method) -->
                        <div id="payment-details" class="hidden space-y-4">
                            <!-- Mobile Money Details -->
                            <div id="mobile-money-details" class="hidden">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-blue-800 mb-2">Mobile Money Instructions</h4>
                                    <p class="text-blue-700 text-sm mb-3">
                                        Send money to: <strong>0700-123-456</strong> (Church Account)<br>
                                        Then enter your transaction reference below.
                                    </p>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="payment_provider" class="block text-sm font-medium text-gray-700 mb-1">
                                            Provider
                                        </label>
                                        <select id="payment_provider" name="payment_provider" disabled
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                            <option value="">Select provider</option>
                                            <option value="MTN">MTN Mobile Money</option>
                                            <option value="Airtel">Airtel Money</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="payment_account" class="block text-sm font-medium text-gray-700 mb-1">
                                            Your Phone Number
                                        </label>
                                        <input type="tel" id="payment_account" name="payment_account" disabled
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                               placeholder="0700-000-000">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="transaction_reference" class="block text-sm font-medium text-gray-700 mb-1">
                                        Transaction Reference <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="transaction_reference" name="transaction_reference" disabled
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="Enter transaction ID from SMS">
                                </div>
                            </div>

                            <!-- Bank Transfer Details -->
                            <div id="bank-transfer-details" class="hidden">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-green-800 mb-2">Bank Transfer Details</h4>
                                    <div class="text-green-700 text-sm space-y-1">
                                        <p><strong>Bank:</strong> Stanbic Bank Uganda</p>
                                        <p><strong>Account Name:</strong> St. Johns Church</p>
                                        <p><strong>Account Number:</strong> 9030012345678</p>
                                        <p><strong>Branch:</strong> Kampala Main Branch</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="transaction_reference_bank" class="block text-sm font-medium text-gray-700 mb-1">
                                        Transaction Reference <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="transaction_reference_bank" name="transaction_reference" disabled
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="Bank transaction reference">
                                </div>
                            </div>

                            <!-- Cash Details -->
                            <div id="cash-details" class="hidden">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-yellow-800 mb-2">Cash Giving</h4>
                                    <p class="text-yellow-700 text-sm">
                                        Please bring your cash offering to the church during service or office hours. 
                                        Your giving will be confirmed immediately upon submission.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Submit -->
                <div class="flex justify-center">
                    <button type="submit" id="submit-btn"
                        class="px-6 bg-secondary hover:bg-accent text-white font-bold text-lg py-2 rounded-2xl shadow-xl hover:shadow-accent/30 transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-3">
                        <span id="submit-text">Submit </span>
                        <span id="submit-loading" class="hidden">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Cards – Below form, centered -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto mt-8">
            <!-- Security Card -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-accent/20">
                <h3 class="text-xl font-bold text-primary mb-4 flex items-center gap-3">
                    <span class="text-accent text-2xl">🔒</span>
                    Secure & Transparent
                </h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="text-accent text-lg">✓</span>
                        All transactions encrypted & secure
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent text-lg">✓</span>
                        Instant digital receipt
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent text-lg">✓</span>
                        Full financial transparency reports
                    </li>
                </ul>
            </div>

            <!-- Impact Card -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-accent/20">
                <h3 class="text-xl font-bold text-primary mb-4 flex items-center gap-3">
                    <span class="text-accent text-2xl">🌟</span>
                    Your Impact
                </h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="text-accent text-lg">✓</span>
                        Local community outreach & food programs
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent text-lg">✓</span>
                        Youth, children & education support
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent text-lg">✓</span>
                        Church maintenance & missions
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <!-- Contact Note -->
    <div class="text-center mt-8 text-gray-600">
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
        <p class="mb-2 text-sm italic text-gray-500">
            “God loves a cheerful giver” — thank you for your generosity.
        </p>
    </div>
    </div>
    </section>

    @include('partials.footer')
</body>

</html>

<!-- JavaScript for Form Handling -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('giving-form');
        const paymentMethodSelect = document.getElementById('payment_method');
        const paymentDetails = document.getElementById('payment-details');
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');

        // Show/hide payment details based on method
        paymentMethodSelect.addEventListener('change', function () {
            const method = this.value;
            const allDetails = document.querySelectorAll('[id$="-details"]');

            // Hide all payment detail sections
            allDetails.forEach(detail => detail.classList.add('hidden'));
            paymentDetails.classList.add('hidden');

            // Clear all payment-specific fields when switching methods
            document.getElementById('payment_provider').value = '';
            document.getElementById('payment_account').value = '';
            document.getElementById('transaction_reference').value = '';
            document.getElementById('transaction_reference_bank').value = '';
            
            // Disable fields that aren't being used
            document.getElementById('payment_provider').disabled = true;
            document.getElementById('payment_account').disabled = true;
            document.getElementById('transaction_reference').disabled = true;
            document.getElementById('transaction_reference_bank').disabled = true;

            if (method) {
                paymentDetails.classList.remove('hidden');

                // Show specific payment method details and enable relevant fields
                if (method === 'mobile_money') {
                    document.getElementById('mobile-money-details').classList.remove('hidden');
                    document.getElementById('payment_provider').disabled = false;
                    document.getElementById('payment_account').disabled = false;
                    document.getElementById('transaction_reference').disabled = false;
                } else if (method === 'bank_transfer') {
                    document.getElementById('bank-transfer-details').classList.remove('hidden');
                    document.getElementById('transaction_reference_bank').disabled = false;
                } else if (method === 'cash') {
                    document.getElementById('cash-details').classList.remove('hidden');
                }
            }
        });

        // Form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Show loading state
            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');
            submitBtn.disabled = true;

            // Prepare form data
            const formData = new FormData(form);

            // Submit via fetch
            fetch('{{ route("giving.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    // Parse JSON regardless of status
                    return response.json().then(data => ({
                        status: response.status,
                        ok: response.ok,
                        data: data
                    }));
                })
                .then(({status, ok, data}) => {
                    if (ok && data.success) {
                        showMessage('success', data.message);

                        // Show next steps if available
                        if (data.next_steps) {
                            setTimeout(() => {
                                showMessage('info', data.next_steps);
                            }, 2000);
                        }

                        form.reset();
                        paymentDetails.classList.add('hidden');

                        // Scroll to top
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } else {
                        // Handle validation errors (422) or other errors
                        let errorMessage = data.message || 'An error occurred. Please try again.';

                        // Handle validation errors
                        if (data.errors) {
                            const errorList = Object.entries(data.errors)
                                .map(([field, messages]) => {
                                    const fieldName = field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                                    return `<strong>${fieldName}:</strong> ${Array.isArray(messages) ? messages.join(', ') : messages}`;
                                })
                                .join('<br>');
                            errorMessage = `<strong>Validation Errors:</strong><br>${errorList}`;
                        }

                        showMessage('error', errorMessage);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorMessage = 'An error occurred while processing your giving. Please try again.';

                    // Provide more specific error messages based on error type
                    if (error.message.includes('Failed to fetch')) {
                        errorMessage = 'Network error. Please check your internet connection and try again.';
                    }

                    showMessage('error', errorMessage);
                })
                .finally(() => {
                    // Reset button state
                    submitText.classList.remove('hidden');
                    submitLoading.classList.add('hidden');
                    submitBtn.disabled = false;
                });
        });

        function showMessage(type, message) {
            const container = document.getElementById('message-container');
            const successDiv = document.getElementById('success-message');
            const errorDiv = document.getElementById('error-message');
            const successText = document.getElementById('success-text');
            const errorText = document.getElementById('error-text');

            // Hide all messages first
            successDiv.classList.add('hidden');
            errorDiv.classList.add('hidden');

            // Show appropriate message
            if (type === 'success') {
                successText.innerHTML = message.replace(/\n/g, '<br>');
                successDiv.classList.remove('hidden');
            } else if (type === 'info') {
                // Show info messages as success style but with blue color
                successText.innerHTML = message.replace(/\n/g, '<br>');
                successDiv.classList.remove('hidden');
                successDiv.className = successDiv.className.replace('bg-green-100 border-green-400 text-green-700', 'bg-blue-100 border-blue-400 text-blue-700');
            } else {
                errorText.innerHTML = message.replace(/\n/g, '<br>');
                errorDiv.classList.remove('hidden');
            }

            container.classList.remove('hidden');

            // Scroll to message
            container.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Auto-hide success messages after 8 seconds
            if (type === 'success' || type === 'info') {
                setTimeout(() => {
                    container.classList.add('hidden');
                }, 8000);
            }
        }
    });
</script>
</body>

</html>