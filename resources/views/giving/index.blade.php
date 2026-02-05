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
    <style>
        .church-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .heart-pulse {
            animation: heartbeat 1.5s ease-in-out infinite;
        }
        @keyframes heartbeat {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .scripture-text {
            font-family: 'Georgia', serif;
            font-style: italic;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header with Church Branding -->
    <div class="church-gradient text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">
                Give / Tithe <span class="heart-pulse inline-block">❤️</span>
            </h1>
            <p class="text-xl opacity-90">St. Johns Church - Supporting God's Work</p>
        </div>
    </div>

    <!-- Scripture Encouragement -->
    <div class="bg-white border-l-4 border-purple-500 py-6">
        <div class="container mx-auto px-4">
            <blockquote class="scripture-text text-lg text-gray-700 text-center">
                "Each of you should give what you have decided in your heart to give, not reluctantly or under compulsion, for God loves a cheerful giver."
                <cite class="block mt-2 text-sm font-semibold text-purple-600">- 2 Corinthians 9:7</cite>
            </blockquote>
        </div>
    </div>

    <!-- Main Giving Form -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Success/Error Messages -->
            <div id="message-container" class="mb-6 hidden">
                <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 hidden">
                    <strong>Thank you!</strong> <span id="success-text"></span>
                </div>
                <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 hidden">
                    <strong>Error:</strong> <span id="error-text"></span>
                </div>
            </div>

            <!-- Giving Form Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                <form id="giving-form" class="space-y-6">
                    @csrf
                    
                    <!-- Member Status Check -->
                    @auth
                        @if(auth()->user()->member)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-blue-800">
                                    <strong>Welcome, {{ auth()->user()->member->full_name }}!</strong>
                                    Your giving will be automatically linked to your member account.
                                </p>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-yellow-800">
                                    <strong>Welcome, {{ auth()->user()->name }}!</strong>
                                    Since you don't have a member profile, please fill in your details below.
                                </p>
                            </div>
                        @endif
                    @endauth

                    <!-- Guest Information (shown if not logged in as member) -->
                    @if(!auth()->check() || !auth()->user()->member)
                    <div class="guest-info space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Your Information</h3>
                        
                        <div>
                            <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="guest_name" name="guest_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address
                                </label>
                                <input type="email" id="guest_email" name="guest_email"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       placeholder="For receipt delivery">
                            </div>
                            <div>
                                <label for="guest_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number
                                </label>
                                <input type="tel" id="guest_phone" name="guest_phone"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       placeholder="For mobile money payments">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Giving Details -->
                    <div class="giving-details space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Giving Details</h3>
                        
                        <!-- Giving Type -->
                        <div>
                            <label for="giving_type" class="block text-sm font-medium text-gray-700 mb-1">
                                Type of Giving <span class="text-red-500">*</span>
                            </label>
                            <select id="giving_type" name="giving_type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select giving type</option>
                                <option value="tithe">Tithe (10% of income)</option>
                                <option value="offering">Offering (Freewill gift)</option>
                                <option value="donation">Donation (Specific cause)</option>
                                <option value="special_offering">Special Offering</option>
                            </select>
                        </div>

                        <!-- Amount -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                                    Amount <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="amount" name="amount" required min="100" step="100"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       placeholder="Enter amount">
                            </div>
                            <div>
                                <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">
                                    Currency
                                </label>
                                <select id="currency" name="currency"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="UGX">UGX</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                        </div>

                        <!-- Purpose -->
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">
                                Purpose / Designation
                            </label>
                            <input type="text" id="purpose" name="purpose"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="e.g., Building Fund, Missions, Youth Ministry">
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Personal Message / Prayer Request
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
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
                                        <select id="payment_provider" name="payment_provider"
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
                                        <input type="tel" id="payment_account" name="payment_account"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                               placeholder="0700-000-000">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="transaction_reference" class="block text-sm font-medium text-gray-700 mb-1">
                                        Transaction Reference <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="transaction_reference" name="transaction_reference"
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
                                        Transaction Reference
                                    </label>
                                    <input type="text" id="transaction_reference_bank" name="transaction_reference"
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

                    <!-- Submit Button -->
                    <div class="text-center pt-6">
                        <button type="submit" id="submit-btn"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
                            <span id="submit-text">Submit My Giving ❤️</span>
                            <span id="submit-loading" class="hidden">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Information Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <!-- Security Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">🔒 Secure & Transparent</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• All transactions are encrypted and secure</li>
                        <li>• You'll receive a receipt for your records</li>
                        <li>• Financial transparency reports available</li>
                        <li>• Tax-deductible receipts provided</li>
                    </ul>
                </div>

                <!-- Impact Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">🌟 Your Impact</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Supporting local community outreach</li>
                        <li>• Funding youth and children's programs</li>
                        <li>• Maintaining church facilities</li>
                        <li>• Supporting missions and evangelism</li>
                    </ul>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="text-center mt-8 text-gray-600">
                <p class="text-sm">
                    Questions about giving? Contact us at 
                    <a href="mailto:giving@stjohnschurch.org" class="text-purple-600 hover:underline">giving@stjohnschurch.org</a>
                    or call <a href="tel:+256700123456" class="text-purple-600 hover:underline">+256 700 123 456</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript for Form Handling -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('giving-form');
            const paymentMethodSelect = document.getElementById('payment_method');
            const paymentDetails = document.getElementById('payment-details');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitLoading = document.getElementById('submit-loading');

            // Show/hide payment details based on method
            paymentMethodSelect.addEventListener('change', function() {
                const method = this.value;
                const allDetails = document.querySelectorAll('[id$="-details"]');
                
                // Hide all payment detail sections
                allDetails.forEach(detail => detail.classList.add('hidden'));
                paymentDetails.classList.add('hidden');

                if (method) {
                    paymentDetails.classList.remove('hidden');
                    
                    // Show specific payment method details
                    if (method === 'mobile_money') {
                        document.getElementById('mobile-money-details').classList.remove('hidden');
                    } else if (method === 'bank_transfer') {
                        document.getElementById('bank-transfer-details').classList.remove('hidden');
                    } else if (method === 'cash') {
                        document.getElementById('cash-details').classList.remove('hidden');
                    }
                }
            });

            // Form submission
            form.addEventListener('submit', function(e) {
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
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
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
                        let errorMessage = data.message || 'An error occurred. Please try again.';
                        
                        // Handle validation errors
                        if (data.errors) {
                            const errorList = Object.entries(data.errors)
                                .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                                .join('\n');
                            errorMessage += '\n\nValidation Errors:\n' + errorList;
                        }
                        
                        showMessage('error', errorMessage);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorMessage = 'An error occurred while processing your giving. Please try again.';
                    
                    // Provide more specific error messages based on error type
                    if (error.message.includes('422')) {
                        errorMessage = 'Please check your input and try again. Some required fields may be missing or invalid.';
                    } else if (error.message.includes('500')) {
                        errorMessage = 'A server error occurred. Please try again in a few moments or contact support if the problem persists.';
                    } else if (error.message.includes('Failed to fetch')) {
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