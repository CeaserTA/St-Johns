<!-- Quick Account Creation Modal -->
<div id="quickAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl max-w-md w-full p-8">
        <h3 class="text-2xl font-bold text-primary mb-4">Create Your Account</h3>
        <p class="text-gray-600 mb-6">Create an account to register for services and access member features.</p>
        
        <!-- Member Registration Complete Message -->
        @if(session('member_registration_complete'))
        <div id="memberRegistrationCompleteMessage" class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Registration Complete!</p>
                    <p class="text-sm text-blue-700 mt-1">{{ session('member_registration_complete') }}</p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Error Message Display -->
        @if(session('error'))
        <div id="quickAccountError" class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-800">Error</p>
                    <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Success Message Display -->
        @if(session('success'))
        <div id="quickAccountSuccess" class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-green-800">Success</p>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif
        
        <form id="quickAccountForm" action="{{ route('member.create-account') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" id="quickAccountEmail" required 
                       value="{{ old('email', session('prefill_email')) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition @error('email') border-red-500 @enderror">
                @error('email')
                <p class="text-xs text-red-600 mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
                @else
                <p class="text-xs text-gray-500 mt-1">Use the email you registered with as a member</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                <input type="password" name="password" id="quickAccountPassword" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition @error('password') border-red-500 @enderror">
                @error('password')
                <p class="text-xs text-red-600 mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
                @else
                <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                <input type="password" name="password_confirmation" id="quickAccountPasswordConfirm" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition @error('password_confirmation') border-red-500 @enderror">
                @error('password_confirmation')
                <p class="text-xs text-red-600 mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="submit" id="quickAccountSubmitBtn" class="flex-1 bg-secondary hover:bg-red-700 text-white font-bold py-3 rounded-xl transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                    <span id="quickAccountSubmitText">Create Account</span>
                    <svg id="quickAccountLoadingSpinner" class="hidden animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
                <button type="button" id="quickAccountCancelBtn" onclick="closeQuickAccountModal()" class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                    Cancel
                </button>
            </div>
        </form>
        
        <p class="text-sm text-gray-600 mt-4 text-center">
            Already have an account? <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Login</a>
        </p>
    </div>
</div>

<script>
function showQuickAccountModal() {
    document.getElementById('quickAccountModal').classList.remove('hidden');
    document.getElementById('quickAccountModal').classList.add('flex');
}

function closeQuickAccountModal() {
    document.getElementById('quickAccountModal').classList.add('hidden');
    document.getElementById('quickAccountModal').classList.remove('flex');
    // Reset form and clear any error/success messages
    const form = document.getElementById('quickAccountForm');
    if (form) {
        form.reset();
    }
    // Clear error and success messages
    const errorDiv = document.getElementById('quickAccountError');
    const successDiv = document.getElementById('quickAccountSuccess');
    if (errorDiv) errorDiv.remove();
    if (successDiv) successDiv.remove();
}

// Handle form submission with loading state
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quickAccountForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('quickAccountSubmitBtn');
            const submitText = document.getElementById('quickAccountSubmitText');
            const loadingSpinner = document.getElementById('quickAccountLoadingSpinner');
            const cancelBtn = document.getElementById('quickAccountCancelBtn');
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.textContent = 'Creating Account...';
            loadingSpinner.classList.remove('hidden');
            cancelBtn.disabled = true;
        });
    }
    
    // Auto-show modal if there are validation errors or show_account_creation flag
    @if($errors->any() || session('error') || session('show_account_creation'))
        showQuickAccountModal();
    @endif
});
</script>
