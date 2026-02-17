<!-- Quick Account Creation Modal -->
<div id="quickAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl max-w-md w-full p-8">
        <h3 class="text-2xl font-bold text-primary mb-4">Create Your Account</h3>
        <p class="text-gray-600 mb-6">Create an account to register for services and access member features.</p>
        
        <form action="{{ route('member.create-account') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                <p class="text-xs text-gray-500 mt-1">Use the email you registered with as a member</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                <input type="password" name="password" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                <input type="password" name="password_confirmation" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-secondary hover:bg-red-700 text-white font-bold py-3 rounded-xl">
                    Create Account
                </button>
                <button type="button" onclick="closeQuickAccountModal()" class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50">
                    Cancel
                </button>
            </div>
        </form>
        
        <p class="text-sm text-gray-600 mt-4 text-center">
            Already have an account? <a href="{{ route('login') }}" class="text-primary font-semibold">Login</a>
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
}
</script>
