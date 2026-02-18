<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Services - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700" rel="stylesheet" />

    @include('partials.theme-config')
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-text-light dark:text-text-dark min-h-screen">

    @include('partials.navbar')

    @include('partials.announcement')

    {{-- Success Message --}}
    @if ($message = Session::get('success'))
        <div class="mb-6 max-w-7xl mx-auto px-6">
            <div
                class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-r-lg shadow-md flex items-start gap-4">
                <svg class="w-7 h-7 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-bold text-lg text-green-900">Success!</p>
                    <p class="mt-1">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Error Message --}}
    @if ($message = Session::get('error'))
        <div class="mb-6 max-w-7xl mx-auto px-6">
            <div
                class="bg-red-50 border-l-4 border-secondary text-secondary p-5 rounded-r-lg shadow-md flex items-start gap-4">
                <svg class="w-7 h-7 text-secondary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-bold text-lg">Error</p>
                    <p class="mt-1">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Services Page Hero – Shorter & Cleaner -->
    <section class="py-16 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-12"> <!-- Wider container + more padding on large screens -->
            <div class="text-center max-w-4xl mx-auto"> <!-- Text stays readable but not cramped -->
                <p class="text-accent font-bold uppercase tracking-widest text-xs mb-3">
                    Worship • Sacraments • Community
                </p>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-primary leading-tight mb-6">
                    Our Services
                </h1>
                <div class="w-20 h-1 bg-accent mx-auto mb-8"></div>

                <div class="space-y-4 text-base md:text-lg text-gray-700 leading-relaxed">
                    <p>
                        At <span class="text-primary font-semibold">St. John’s Parish Church Entebbe</span>, every
                        service
                        is an invitation to encounter the living God.
                    </p>
                    <p class="text-gray-600">
                        Whether through the beauty of the Holy Eucharist, the joy of baptism and marriage, the
                        comfort of
                        reconciliation, or the hope of Christian burial — we are here to walk with you in every
                        season of faith and life.
                    </p>
                    <p class="italic text-secondary font-medium">
                        "Come to me, all you who are weary and burdened, and I will give you rest." — Matthew 11:28
                    </p>
                </div>

            </div>
        </div>
        <!-- Decorative SVGs -->
    </section>
    <!-- Church Services Grid – Tighter & Faster -->
    <section class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-10">
                <p class="text-accent font-bold uppercase tracking-widest text-xs mb-2">
                    Sacraments & Spiritual Care
                </p>
                <h2 class="text-4xl font-black text-primary mb-3">Our Services</h2>
                <div class="w-20 h-1 bg-accent mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $iconColors = ['accent', 'primary', 'secondary', 'accent'];
                    $iconPaths = [
                        'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        'M19 13l-7 8-7-8m14 0v-2a4 4 0 00-4-4h-2a4 4 0 00-4 4v2',
                        'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                        'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L4 20V4a2 2 0 012-2h8a2 2 0 012 2v2'
                    ];
                @endphp

                @forelse($services as $index => $service)
                    @php
                        $colorClass = $iconColors[$index % count($iconColors)];
                        $iconPath = $iconPaths[$index % count($iconPaths)];
                    @endphp
                    <div
                        class="bg-white rounded-3xl p-6 shadow hover:shadow-xl transition-all border border-gray-100 text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 bg-{{ $colorClass }}/10 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-{{ $colorClass }}" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="{{ $iconPath }}" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-3">{{ $service->name }}</h3>
                        <p class="text-sm text-gray-600 leading-snug mb-3">
                            {{ $service->description }}
                        </p>

                        @if($service->isFree())
                            <span class="inline-block px-4 py-1.5 bg-green-100 text-green-800 text-sm font-bold rounded-full">
                                FREE
                            </span>
                        @else
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Registration Fee
                                </p>
                                <p class="text-2xl font-black text-secondary">
                                    {{ $service->formatted_fee }}
                                </p>
                            </div>
                        @endif

                        @if($service->schedule)
                            <p class="text-xs text-gray-500 mt-3 font-medium">
                                📅 {{ $service->schedule }}
                            </p>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">No services available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SERVICE REGISTRATION – EVEN SHORTER -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-center">

            <div class="space-y-6">
                <p class="text-secondary font-bold uppercase tracking-widest text-xs mb-2">
                    You Are Welcome Here
                </p>
                <h2 class="text-4xl md:text-5xl font-black leading-tight text-primary">
                    Register for a<br>
                    <span class="text-secondary">Church Service</span>
                </h2>

                <div class="space-y-4 text-base text-gray-800">
                    <p>
                        We are overjoyed that you're considering joining us at
                        <strong>St. John's Parish Church Entebbe</strong>.
                    </p>
                    <p>
                        Whether it's baptism, confirmation, holy matrimony, or spiritual counseling —
                        we are here to walk with you every step of the way.
                    </p>
                    <p class="italic text-secondary font-medium">
                        "Where two or three are gathered in my name, there am I among them." — Matthew
                        18:20
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">
                <h3 class="text-2xl font-bold text-center mb-6 text-primary">
                    Let Us Know You're Coming
                </h3>

                <form action="{{ route('service.register') }}" method="POST" class="space-y-5">
                    @csrf

                    @auth
                        <!-- User is logged in, show simple form -->
                        <div class="bg-blue-50 rounded-xl p-4 mb-4">
                            <p class="text-sm text-blue-800">
                                <strong>Registering as:</strong>
                                {{ Auth::user()->member->full_name ?? Auth::user()->name }}
                            </p>
                        </div>

                        <select name="service_id" required
                            class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                            <option value="" disabled selected>Choose a service...</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="w-full bg-secondary hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            Register for Service →
                        </button>
                    @else
                        <!-- User not logged in, show login prompt -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl">
                            <p class="text-yellow-800 font-medium">Please login to register for services</p>
                            <div class="mt-3 flex gap-3">
                                <a href="{{ route('login') }}"
                                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700">
                                    Login
                                </a>
                                <a href="#" onclick="showQuickAccountModal(); return false;"
                                    class="px-4 py-2 border-2 border-primary text-primary rounded-lg hover:bg-blue-50">
                                    Create Account
                                </a>
                            </div>
                        </div>
                    @endauth
                </form>
            </div>
        </div>
    </section>

    <!-- Payment Instructions Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-8">
                <!-- Modal Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-primary mb-2">Payment Instructions</h3>
                        <p class="text-gray-600">Complete your registration by making payment</p>
                    </div>
                    <button onclick="closePaymentModal()"
                        class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>

                <!-- Service Details -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2">Service Details</h4>
                    <div class="space-y-1 text-sm">
                        <p><span class="font-medium">Service:</span> <span id="modal-service-name"></span></p>
                        <p><span class="font-medium">Fee:</span> <span id="modal-service-fee"
                                class="text-secondary font-bold"></span></p>
                        <p><span class="font-medium">Registration ID:</span> <span id="modal-registration-id"
                                class="font-mono"></span></p>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-4">Payment Methods</h4>

                    <!-- Mobile Money -->
                    <div class="border border-gray-200 rounded-xl p-4 mb-3">
                        <div class="flex items-center mb-2">
                            <span class="text-2xl mr-2">📱</span>
                            <h5 class="font-semibold text-gray-800">Mobile Money</h5>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1 ml-8">
                            <p><strong>MTN:</strong> 0772-567-789 (St. John's Church)</p>
                            <p><strong>Airtel:</strong> 0752-666-024 (St. John's Church)</p>
                        </div>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="border border-gray-200 rounded-xl p-4 mb-3">
                        <div class="flex items-center mb-2">
                            <span class="text-2xl mr-2">🏦</span>
                            <h5 class="font-semibold text-gray-800">Bank Transfer</h5>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1 ml-8">
                            <p><strong>Bank:</strong> Stanbic Bank Uganda</p>
                            <p><strong>Account Name:</strong> St. John's Parish Church Entebbe</p>
                            <p><strong>Account Number:</strong> 9030XXXXXXXX</p>
                        </div>
                    </div>

                    <!-- Cash Payment -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center mb-2">
                            <span class="text-2xl mr-2">💵</span>
                            <h5 class="font-semibold text-gray-800">Cash Payment</h5>
                        </div>
                        <div class="text-sm text-gray-600 ml-8">
                            <p>Visit the church office during business hours:</p>
                            <p class="mt-1"><strong>Mon-Fri:</strong> 9:00 AM - 5:00 PM</p>
                            <p><strong>Location:</strong> St. John's Parish Church, Entebbe</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Proof Submission Form -->
                <form id="paymentProofForm" class="space-y-4">
                    @csrf
                    <input type="hidden" id="proof-registration-id" name="registration_id">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method Used
                            *</label>
                        <select name="payment_method" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                            <option value="">Select payment method...</option>
                            <option value="mobile_money">Mobile Money (MTN/Airtel)</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Transaction
                            Reference *</label>
                        <input type="text" name="transaction_reference" required
                            placeholder="e.g., MTN123456789 or Bank Ref"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                        <p class="text-xs text-gray-500 mt-1">Enter the transaction ID from your mobile
                            money or bank receipt</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes
                            (Optional)</label>
                        <textarea name="payment_notes" rows="2" placeholder="Any additional information..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition"></textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-secondary hover:bg-red-700 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            Submit
                        </button>
                        <button type="button" onclick="closePaymentModal()"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                            I'll Pay Later
                        </button>
                    </div>
                </form>

                <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                    <p class="text-sm text-blue-800">
                        <strong>Note:</strong> Your registration is confirmed, but you need to complete
                        payment.
                        You can submit payment proof now or later. Our team will verify and send you a
                        confirmation email.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentRegistrationData = null;

        // Check if we should show payment modal on page load
        @if(session('show_payment_modal') && session('registration_data'))
            document.addEventListener('DOMContentLoaded', function () {
                showPaymentModal(@json(session('registration_data')));
            });
        @endif

            function showPaymentModal(registrationData) {
                currentRegistrationData = registrationData;

                // Populate modal with registration data
                document.getElementById('modal-service-name').textContent = registrationData.service_name;
                document.getElementById('modal-service-fee').textContent = registrationData.service_fee;
                document.getElementById('modal-registration-id').textContent = '#' + registrationData.registration_id;
                document.getElementById('proof-registration-id').value = registrationData.registration_id;

                // Show modal
                const modal = document.getElementById('paymentModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

        function closePaymentModal() {
            const modal = document.getElementById('paymentModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            // Reset form
            document.getElementById('paymentProofForm').reset();
        }

        // Handle payment proof form submission
        document.getElementById('paymentProofForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;

            // Disable button and show loading
            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';

            try {
                const response = await fetch('{{ route("service.payment.proof") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                const data = await response.json();

                if (data.success) {
                    closePaymentModal();
                    alert('Payment proof submitted successfully! Our team will verify and send you a confirmation email.');
                    // Optionally reload the page
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to submit payment proof'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        });

        // Close modal when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closePaymentModal();
            }
        });
    </script>

    @include('partials.member-modals')
    @include('partials.quick-account-modal')

    @include('partials.footer')
</body>

</html>