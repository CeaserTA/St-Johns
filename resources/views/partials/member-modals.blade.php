@auth
<!-- My Service Registrations Modal -->
<div id="myRegistrationsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-8">
            <!-- Modal Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-2">My Service Registrations</h3>
                    <p class="text-gray-600">View all your service registrations and their status</p>
                </div>
                <button onclick="closeMyRegistrationsModal()" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
            </div>

            <!-- Registrations List -->
            <div id="registrationsList" class="space-y-4">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
                    <p class="text-gray-500 mt-4">Loading your registrations...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Payments Modal -->
<div id="pendingPaymentsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-8">
            <!-- Modal Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-2">Pending Payments</h3>
                    <p class="text-gray-600">Complete payment for your service registrations</p>
                </div>
                <button onclick="closePendingPaymentsModal()" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
            </div>

            <!-- Pending Payments List -->
            <div id="pendingPaymentsList" class="space-y-4">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
                    <p class="text-gray-500 mt-4">Loading pending payments...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My Giving History Modal -->
<div id="myGivingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl max-w-6xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-8">
            <!-- Modal Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-2">My Giving History</h3>
                    <p class="text-gray-600">Track your tithes, offerings, and donations</p>
                </div>
                <button onclick="closeMyGivingModal()" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
            </div>

            <!-- Summary Cards -->
            <div id="givingSummary" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <p class="text-xs text-gray-600 mb-1">Total This Year</p>
                    <p class="text-2xl font-bold text-primary" id="summary-total">-</p>
                </div>
                <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                    <p class="text-xs text-gray-600 mb-1">Tithes</p>
                    <p class="text-2xl font-bold text-green-600" id="summary-tithes">-</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                    <p class="text-xs text-gray-600 mb-1">Offerings</p>
                    <p class="text-2xl font-bold text-blue-600" id="summary-offerings">-</p>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                    <p class="text-xs text-gray-600 mb-1">Donations</p>
                    <p class="text-2xl font-bold text-purple-600" id="summary-donations">-</p>
                </div>
            </div>

            <!-- Givings List -->
            <div id="givingsList" class="space-y-3">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
                    <p class="text-gray-500 mt-4">Loading your giving history...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Settings Modal -->
<style>
/* Profile Settings Modal - Minimalistic scrollbar (matches reference) */
#profileSettingsModal {
    backdrop-filter: blur(4px);
}
#profileSettingsModal .profile-modal-scroll {
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-gutter: stable;
    /* Firefox */
    scrollbar-width: thin;
    scrollbar-color: #9ca3af #f3f4f6;
}
/* WebKit - thin, light track, medium gray rounded thumb */
#profileSettingsModal .profile-modal-scroll::-webkit-scrollbar {
    width: 6px;
}
#profileSettingsModal .profile-modal-scroll::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 0;
}
#profileSettingsModal .profile-modal-scroll::-webkit-scrollbar-thumb {
    background: #9ca3af;
    border-radius: 9999px;
}
#profileSettingsModal .profile-modal-scroll::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}
#profileSettingsModal .profile-modal-scroll::-webkit-scrollbar-button {
    display: none;
}
</style>

<div id="profileSettingsModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="profile-modal-panel bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-xl">
        <!-- Minimal header -->
        <div class="flex justify-between items-center px-8 pt-8 pb-6 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Profile Settings</h3>
            </div>
            <button onclick="closeProfileSettingsModal()" 
                    class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Scrollable content -->
        <div class="profile-modal-scroll flex-1 min-h-0 px-8 pb-8">
            <div id="profileMessages" class="mb-4"></div>

            <!-- Profile Information -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h4 class="text-base font-bold text-gray-900">Profile Information</h4>
                </div>

                <form id="updateProfileForm" class="space-y-4">
                    @csrf
                    @method('patch')
                    
                    <!-- Profile Photo -->
                    <div class="flex items-center gap-6 pb-6 mb-6 border-b border-gray-200">
                        <div class="relative">
                            @if(Auth::user()->member && Auth::user()->member->profile_image)
                                <img id="profilePreviewImage" src="{{ Auth::user()->member->profile_image_url }}" 
                                     alt="Profile" 
                                     class="w-20 h-20 rounded-full object-cover border border-gray-200">
                            @else
                                <div id="profilePreviewImage" class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                            <button type="button" onclick="document.getElementById('profileImageInput').click()" 
                                    class="absolute -bottom-0.5 -right-0.5 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white border-2 border-white shadow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 mb-1">Profile Photo</p>
                            <input type="file" id="profileImageInput" name="profile_image" accept="image/*" class="hidden" onchange="previewProfileImage(this)">
                            <label for="profileImageInput" class="inline-block px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary/90 cursor-pointer transition">
                                Choose File
                            </label>
                            <span id="profileImageName" class="ml-3 text-sm text-gray-500">No file chosen</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name *</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address *</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition">
                    </div>

                    @if(Auth::user()->member)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                            <input type="tel" name="phone" value="{{ Auth::user()->member->phone }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition">
                        </div>
                    @endif

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Changes
                        </button>
                        <button type="button" onclick="resetProfileForm()" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h4 class="text-base font-bold text-gray-900">Change Password</h4>
                </div>

                <form id="updatePasswordForm" class="space-y-4">
                    @csrf
                    @method('put')
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Password *</label>
                        <input type="password" name="current_password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition"
                               placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password *</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition"
                               placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password *</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition"
                               placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Update Password
                    </button>
                </form>
            </div>

            <!-- Account Actions -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                    <h4 class="text-base font-bold text-gray-900">Account Actions</h4>
                </div>

                <button onclick="confirmDeleteAccount()" 
                        class="flex items-center gap-2 px-0 py-2 text-left text-red-600 hover:text-red-700 font-medium transition">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Confirmation Modal -->
<div id="deleteAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[60] p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-8">
        <h3 class="text-2xl font-bold text-red-600 mb-4">Delete Account?</h3>
        <p class="text-gray-700 mb-6">
            Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently deleted.
        </p>
        
        <form id="deleteAccountForm" class="space-y-4">
            @csrf
            @method('delete')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Enter your password to confirm</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition">
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteAccountModal()" 
                        class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-semibold">
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// My Registrations Modal Functions
function showMyRegistrationsModal() {
    const modal = document.getElementById('myRegistrationsModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    loadMyRegistrations();
}

function closeMyRegistrationsModal() {
    const modal = document.getElementById('myRegistrationsModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

async function loadMyRegistrations() {
    try {
        const response = await fetch('/api/my-service-registrations', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success && data.registrations) {
            displayRegistrations(data.registrations);
        } else {
            showRegistrationsError('Failed to load registrations');
        }
    } catch (error) {
        console.error('Error loading registrations:', error);
        showRegistrationsError('An error occurred while loading your registrations');
    }
}

function displayRegistrations(registrations) {
    const container = document.getElementById('registrationsList');
    
    if (registrations.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500 text-lg">No service registrations yet</p>
                <a href="${window.location.origin}/services" class="inline-block mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700">
                    Browse Services
                </a>
            </div>
        `;
        return;
    }
    
    container.innerHTML = registrations.map(reg => `
        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h4 class="text-lg font-bold text-gray-900 mb-2">${reg.service_name}</h4>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p><strong>Registered:</strong> ${reg.registered_date}</p>
                        ${reg.service_fee ? `<p><strong>Fee:</strong> ${reg.service_fee}</p>` : ''}
                    </div>
                </div>
                <div>
                    ${getPaymentStatusBadge(reg.payment_status)}
                </div>
            </div>
            
            ${reg.payment_status === 'pending' && reg.service_fee ? `
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <button onclick="submitPaymentForRegistration(${reg.id}, '${reg.service_name}', '${reg.service_fee}')" 
                            class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-red-700 text-sm font-semibold">
                        Submit Payment Proof
                    </button>
                </div>
            ` : ''}
        </div>
    `).join('');
}

function getPaymentStatusBadge(status) {
    const badges = {
        'paid': '<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">PAID</span>',
        'pending': '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">PENDING</span>',
        'failed': '<span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">FAILED</span>'
    };
    return badges[status] || badges['pending'];
}

function showRegistrationsError(message) {
    const container = document.getElementById('registrationsList');
    container.innerHTML = `
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-red-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-gray-500">${message}</p>
        </div>
    `;
}

// Pending Payments Modal Functions
function showPendingPaymentsModal() {
    const modal = document.getElementById('pendingPaymentsModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    loadPendingPayments();
}

function closePendingPaymentsModal() {
    const modal = document.getElementById('pendingPaymentsModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

async function loadPendingPayments() {
    try {
        const response = await fetch('/api/my-pending-payments', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success && data.payments) {
            displayPendingPayments(data.payments);
        } else {
            showPendingPaymentsError('Failed to load pending payments');
        }
    } catch (error) {
        console.error('Error loading pending payments:', error);
        showPendingPaymentsError('An error occurred while loading pending payments');
    }
}

function displayPendingPayments(payments) {
    const container = document.getElementById('pendingPaymentsList');
    
    if (payments.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500 text-lg">No pending payments</p>
                <p class="text-gray-400 text-sm mt-2">All your payments are up to date!</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = payments.map(payment => `
        <div class="border-2 border-yellow-200 bg-yellow-50 rounded-xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h4 class="text-lg font-bold text-gray-900 mb-2">${payment.service_name}</h4>
                    <div class="space-y-1 text-sm text-gray-700">
                        <p><strong>Amount Due:</strong> <span class="text-secondary font-bold text-lg">${payment.service_fee}</span></p>
                        <p><strong>Registered:</strong> ${payment.registered_date}</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">PENDING</span>
            </div>
            
            <button onclick="submitPaymentForRegistration(${payment.id}, '${payment.service_name}', '${payment.service_fee}')" 
                    class="w-full px-4 py-3 bg-secondary text-white rounded-lg hover:bg-red-700 font-semibold">
                Submit Payment Proof
            </button>
        </div>
    `).join('');
}

function showPendingPaymentsError(message) {
    const container = document.getElementById('pendingPaymentsList');
    container.innerHTML = `
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-red-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-gray-500">${message}</p>
        </div>
    `;
}

function submitPaymentForRegistration(registrationId, serviceName, serviceFee) {
    // Close current modal
    closePendingPaymentsModal();
    closeMyRegistrationsModal();
    
    // Show payment modal from services page
    if (typeof showPaymentModal === 'function') {
        showPaymentModal({
            registration_id: registrationId,
            service_name: serviceName,
            service_fee: serviceFee
        });
    } else {
        // Redirect to services page with payment info
        window.location.href = `/services?payment=${registrationId}`;
    }
}

// Close modals when clicking outside
document.getElementById('myRegistrationsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeMyRegistrationsModal();
    }
});

document.getElementById('pendingPaymentsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closePendingPaymentsModal();
    }
});

document.getElementById('myGivingModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeMyGivingModal();
    }
});

document.getElementById('profileSettingsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeProfileSettingsModal();
    }
});

// Profile Settings Modal Functions
function showProfileSettingsModal() {
    const modal = document.getElementById('profileSettingsModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeProfileSettingsModal() {
    const modal = document.getElementById('profileSettingsModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    // Clear any messages
    document.getElementById('profileMessages').innerHTML = '';
}

function previewProfileImage(input) {
    const preview = document.getElementById('profilePreviewImage');
    const fileName = document.getElementById('profileImageName');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // If preview is an img element, update src
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // If it's a div (placeholder), replace it with an img
                const img = document.createElement('img');
                img.id = 'profilePreviewImage';
                img.src = e.target.result;
                img.className = 'w-20 h-20 rounded-full object-cover border border-gray-200';
                img.alt = 'Profile';
                preview.parentNode.replaceChild(img, preview);
            }
        };
        
        reader.readAsDataURL(input.files[0]);
        fileName.textContent = input.files[0].name;
    }
}

function resetProfileForm() {
    document.getElementById('updateProfileForm').reset();
    document.getElementById('profileImageName').textContent = 'No file chosen';
    // Reload to reset image preview
    location.reload();
}

// Update Profile Form Handler
document.getElementById('updateProfileForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    submitButton.disabled = true;
    submitButton.textContent = 'Updating...';
    
    try {
        const response = await fetch('/profile', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]').value
            }
        });
        
        if (response.ok) {
            showProfileMessage('Profile updated successfully!', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            const data = await response.json();
            showProfileMessage(data.message || 'Failed to update profile', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showProfileMessage('An error occurred. Please try again.', 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    }
});

// Update Password Form Handler
document.getElementById('updatePasswordForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    submitButton.disabled = true;
    submitButton.textContent = 'Updating...';
    
    try {
        const response = await fetch('/password', {
            method: 'PUT',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]').value
            }
        });
        
        if (response.ok) {
            showProfileMessage('Password updated successfully!', 'success');
            this.reset();
        } else {
            const data = await response.json();
            showProfileMessage(data.message || 'Failed to update password', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showProfileMessage('An error occurred. Please try again.', 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    }
});

// Delete Account Functions
function confirmDeleteAccount() {
    const modal = document.getElementById('deleteAccountModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteAccountModal() {
    const modal = document.getElementById('deleteAccountModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('deleteAccountForm').reset();
}

document.getElementById('deleteAccountForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    submitButton.disabled = true;
    submitButton.textContent = 'Deleting...';
    
    try {
        const response = await fetch('/profile', {
            method: 'DELETE',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]').value
            }
        });
        
        if (response.ok) {
            alert('Account deleted successfully. You will be redirected to the homepage.');
            window.location.href = '/';
        } else {
            const data = await response.json();
            alert(data.message || 'Failed to delete account. Please check your password.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    }
});

function showProfileMessage(message, type) {
    const container = document.getElementById('profileMessages');
    const bgColor = type === 'success' ? 'bg-green-50 border-green-500 text-green-800' : 'bg-red-50 border-red-500 text-red-800';
    
    container.innerHTML = `
        <div class="${bgColor} border-l-4 p-4 rounded-r-xl mb-4">
            <p class="font-medium">${message}</p>
        </div>
    `;
    
    if (type === 'success') {
        setTimeout(() => {
            container.innerHTML = '';
        }, 3000);
    }
}

// My Giving History Modal Functions
function showMyGivingModal() {
    const modal = document.getElementById('myGivingModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    loadMyGivingHistory();
}

function closeMyGivingModal() {
    const modal = document.getElementById('myGivingModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

async function loadMyGivingHistory() {
    try {
        const response = await fetch('/my-giving', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            displayGivingSummary(data.summary);
            displayGivingHistory(data.givings);
        } else {
            showGivingError('Failed to load giving history');
        }
    } catch (error) {
        console.error('Error loading giving history:', error);
        showGivingError('An error occurred while loading your giving history');
    }
}

function displayGivingSummary(summary) {
    document.getElementById('summary-total').textContent = 'UGX ' + summary.total_this_year;
    document.getElementById('summary-tithes').textContent = 'UGX ' + summary.tithes_this_year;
    document.getElementById('summary-offerings').textContent = 'UGX ' + summary.offerings_this_year;
    document.getElementById('summary-donations').textContent = 'UGX ' + summary.donations_this_year;
}

function displayGivingHistory(givings) {
    const container = document.getElementById('givingsList');
    
    if (givings.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500 text-lg mb-4">No giving history yet</p>
                <a href="${window.location.origin}/give" class="inline-block px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700">
                    Make a Donation
                </a>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    ${givings.map(giving => `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">${giving.payment_date}</td>
                            <td class="px-4 py-3">
                                ${getGivingTypeBadge(giving.giving_type)}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">UGX ${giving.amount}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">${giving.payment_method}</td>
                            <td class="px-4 py-3">
                                ${getGivingStatusBadge(giving.status)}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 font-mono">${giving.transaction_reference}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

function getGivingTypeBadge(type) {
    const badges = {
        'Tithe': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Tithe</span>',
        'Offering': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Offering</span>',
        'Donation': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Donation</span>',
        'Special_offering': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Special Offering</span>'
    };
    return badges[type] || `<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">${type}</span>`;
}

function getGivingStatusBadge(status) {
    const badges = {
        'completed': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>',
        'pending': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
        'failed': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Failed</span>'
    };
    return badges[status] || badges['pending'];
}

function showGivingError(message) {
    const container = document.getElementById('givingsList');
    container.innerHTML = `
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-red-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-gray-500">${message}</p>
        </div>
    `;
}
</script>
@endauth
