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
</script>
