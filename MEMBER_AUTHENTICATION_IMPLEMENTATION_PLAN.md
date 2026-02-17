# Member Authentication Implementation - Complete Plan

## Overview
This document outlines the complete implementation for adding member authentication with optional account creation during registration.

## Current State
- Members can register but NO user account is created
- Only admins can login
- Members cannot access services, groups, or updates
- No authentication for members exists

## Goal
- Add optional account creation during member registration
- Protect services/groups/updates with authentication
- Allow existing members to create accounts later
- Implement member profile dropdown with dashboard

---

## Phase 1: Update Member Registration (PRIORITY)

### 1.1 Find Member Registration Modal/Form
**Location to check:**
- `resources/views/partials/` (likely has a modal)
- `resources/views/index.blade.php` or home page
- Search for "Register as Member" or member registration form

### 1.2 Add Account Creation Checkbox
**Add to registration form:**
```html
<!-- After existing fields, before submit button -->
<div class="form-group mt-4">
    <label class="flex items-center">
        <input type="checkbox" id="createAccount" name="create_account" value="1" 
               class="rounded border-gray-300 text-primary focus:ring-primary">
        <span class="ml-2 text-sm text-gray-700">
            Create an account to access services, updates, and groups
        </span>
    </label>
</div>

<!-- Password fields (hidden by default) -->
<div id="accountFields" class="hidden mt-4 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Password *</label>
        <input type="password" name="password" id="password" 
               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Confirm Password *</label>
        <input type="password" name="password_confirmation" id="password_confirmation" 
               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
    </div>
</div>

<script>
// Show/hide password fields based on checkbox
document.getElementById('createAccount').addEventListener('change', function() {
    const accountFields = document.getElementById('accountFields');
    const passwordInput = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    
    if (this.checked) {
        accountFields.classList.remove('hidden');
        passwordInput.required = true;
        passwordConfirm.required = true;
    } else {
        accountFields.classList.add('hidden');
        passwordInput.required = false;
        passwordConfirm.required = false;
        passwordInput.value = '';
        passwordConfirm.value = '';
    }
});
</script>
```
**File:** `app/Http/Controllers/MemberController.php`

**Add after validation, before creating member:**
```php
// Check if user wants to create an account
$createAccount = $request->boolean('create_account');
$user = null;

if ($createAccount) {
    // Validate password fields
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);
    
    // Create user account
    $user = \App\Models\User::create([
        'name' => $request->fullname,
        'email' => $request->email,
        'password' => \Hash::make($request->password),
        'role' => 'member',
    ]);
    
    \Log::info('User account created for member', ['user_id' => $user->id]);
}

// Add user_id to member data if account was created
if ($user) {
    $data['user_id'] = $user->id;
}

// Create member (existing code continues)
$member = Member::create($data);

// Auto-login if account was created
if ($user) {
    Auth::login($user);
    \Log::info('User auto-logged in after registration', ['user_id' => $user->id]);
}
```

**Update return statements:**
```php
// After member creation, check if user was logged in
if (Auth::check() && !$request->wantsJson()) {
    // If admin created the member
    if (Auth::user()->role === 'admin') {
        return redirect()->route('members')->with('success', 'Member added successfully');
    }
    
    // If member just registered with account
    return redirect()->route('services')->with('success', 'Welcome! Your account has been created. You can now register for services.');
}

// Guest registration (no account created)
return redirect()->route('home')->with('success', 'Thank you for registering — we will contact you soon.');
```

---

## Phase 2: Protect Service Routes

### 2.1 Add Middleware to Service Registration
**File:** `routes/web.php`

**Find and update:**
```php
// OLD:
Route::get('/services', [PublicServiceController::class, 'index'])->name('services');
Route::post('/service-register', [ServiceRegistrationController::class, 'store'])->name('service.register');

// NEW:
Route::get('/services', [PublicServiceController::class, 'index'])->name('services');

// Protect service registration with auth
Route::middleware(['auth'])->group(function () {
    Route::post('/service-register', [ServiceRegistrationController::class, 'store'])->name('service.register');
    Route::post('/service-payment-proof', [ServiceRegistrationController::class, 'submitPaymentProof'])->name('service.payment.proof');
});
```

### 2.2 Update ServiceRegistrationController
**File:** `app/Http/Controllers/ServiceRegistrationController.php`

**Replace store method:**
```php
public function store(Request $request)
{
    $user = Auth::user();
    $member = $user->member;
    
    // Check if user has member profile
    if (!$member) {
        return back()->with('error', 'Please complete your member profile first.');
    }
    
    $validated = $request->validate([
        'service_id' => 'required|exists:services,id',
    ]);

    // Get the service
    $service = Service::findOrFail($validated['service_id']);

    // Create registration linked to member
    $registration = ServiceRegistration::create([
        'service_id' => $validated['service_id'],
        'member_id' => $member->id,
        'amount_paid' => 0,
        'payment_status' => $service->isFree() ? 'paid' : 'pending',
        'paid_at' => $service->isFree() ? now() : null,
    ]);

    $serviceName = $registration->service->name;

    if ($service->isFree()) {
        return back()->with('success', 'Thank you! You are registered for ' . $serviceName . '.');
    } else {
        return back()->with([
            'success' => 'Registration successful! Please complete payment to confirm your registration.',
            'show_payment_modal' => true,
            'registration_data' => [
                'registration_id' => $registration->id,
                'service_name' => $service->name,
                'service_fee' => $service->formatted_fee,
            ]
        ]);
    }
}
```

### 2.3 Update Services View Registration Form
**File:** `resources/views/services.blade.php`

**Find the registration form and update:**
```html
<!-- Remove guest fields (fullname, email, address, contact) -->
<!-- Keep only service selection -->

<form action="{{ route('service.register') }}" method="POST" class="space-y-5">
    @csrf
    
    @auth
        <!-- User is logged in, show simple form -->
        <div class="bg-blue-50 rounded-xl p-4 mb-4">
            <p class="text-sm text-blue-800">
                <strong>Registering as:</strong> {{ Auth::user()->member->full_name ?? Auth::user()->name }}
            </p>
        </div>
        
        <select name="service_id" required class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
            <option value="" disabled selected>Choose a service...</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="w-full bg-secondary hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
            Register for Service →
        </button>
    @else
        <!-- User not logged in, show login prompt -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl">
            <p class="text-yellow-800 font-medium">Please login to register for services</p>
            <div class="mt-3 flex gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 border-2 border-primary text-primary rounded-lg hover:bg-blue-50">
                    Create Account
                </a>
            </div>
        </div>
    @endauth
</form>
```

---

## Phase 3: Quick Account Creation for Existing Members

### 3.1 Create Account Creation Route
**File:** `routes/web.php`

```php
// Quick account creation for existing members
Route::post('/member/create-account', [MemberController::class, 'createAccount'])->name('member.create-account');
```

### 3.2 Add Method to MemberController
**File:** `app/Http/Controllers/MemberController.php`

```php
/**
 * Create user account for existing member
 */
public function createAccount(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:members,email',
        'password' => 'required|string|min:8|confirmed',
    ]);
    
    // Find member by email
    $member = Member::where('email', $request->email)->first();
    
    if (!$member) {
        return back()->with('error', 'Member not found with this email.');
    }
    
    // Check if member already has an account
    if ($member->user_id) {
        return back()->with('error', 'This member already has an account. Please login.');
    }
    
    // Create user account
    $user = \App\Models\User::create([
        'name' => $member->full_name,
        'email' => $member->email,
        'password' => \Hash::make($request->password),
        'role' => 'member',
    ]);
    
    // Link user to member
    $member->update(['user_id' => $user->id]);
    
    // Auto-login
    Auth::login($user);
    
    return redirect()->route('services')->with('success', 'Account created successfully! You can now register for services.');
}
```

### 3.3 Create Quick Account Modal
**File:** `resources/views/partials/quick-account-modal.blade.php`

```html
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
```

---

## Phase 4: Member Profile Dropdown

### ✅ 4.1 Update Navbar with Profile Dropdown (COMPLETED)
**File:** `resources/views/partials/navbar.blade.php`

**Features Implemented:**
- Profile circle with member photo or initial
- Member name display
- Dropdown menu with Alpine.js
- Different UI for admin vs member roles
- Smooth animations and transitions

### ✅ 4.2 Create Member Dashboard Modals (COMPLETED)
**File:** `resources/views/partials/member-modals.blade.php`

**Modals Created:**
1. **My Service Registrations Modal**
   - Displays all member's service registrations
   - Shows payment status badges
   - Quick payment submission buttons
   - Empty and loading states

2. **Pending Payments Modal**
   - Shows only services with pending payments
   - Highlights amount due
   - Direct payment submission
   - Empty state when all paid

### ✅ 4.3 Add API Endpoints (COMPLETED)
**Files:** `routes/web.php` & `app/Http/Controllers/ServiceRegistrationController.php`

**Endpoints Created:**
- `GET /api/my-service-registrations` - Fetch member's registrations
- `GET /api/my-pending-payments` - Fetch pending payments

**Controller Methods:**
- `myRegistrations()` - Returns formatted registration data
- `myPendingPayments()` - Returns filtered pending payments

### ✅ 4.4 Include Modals in Pages (COMPLETED)
**Files Modified:**
- `resources/views/services.blade.php`
- `resources/views/index.blade.php`
- `resources/views/events.blade.php`

All pages now include the member modals partial for consistent access to member dashboard features.

---

## Testing Checklist

### Test Path A: Member Only Registration
- [ ] Register as member without checking "Create account"
- [ ] Verify only Member record created (no User)
- [ ] Try to register for service → Should see login prompt
- [ ] Use quick account creation
- [ ] Verify User created and linked to Member
- [ ] Can now register for services

### Test Path B: Member + Account Registration
- [ ] Register as member WITH "Create account" checked
- [ ] Enter password
- [ ] Verify both User and Member created
- [ ] Verify user_id linked in members table
- [ ] Verify auto-logged in
- [ ] Can immediately register for services

### Test Service Registration
- [ ] Login as member
- [ ] Go to /services
- [ ] Register for a service
- [ ] Verify registration linked to member_id (not guest fields)
- [ ] Payment modal appears for paid services
- [ ] Can submit payment proof

---

## Files to Modify

1. ✅ Member registration form/modal (COMPLETED - index.blade.php)
2. ✅ `app/Http/Controllers/MemberController.php` (COMPLETED)
3. ✅ `app/Http/Controllers/ServiceRegistrationController.php` (COMPLETED)
4. ✅ `resources/views/services.blade.php` (COMPLETED)
5. ✅ `routes/web.php` (COMPLETED)
6. ✅ Create `resources/views/partials/quick-account-modal.blade.php` (COMPLETED)

---

## Implementation Status

### ✅ Phase 1: Update Member Registration (COMPLETED)
- ✅ 1.1 Member registration form located in `resources/views/index.blade.php`
- ✅ 1.2 Account creation checkbox added with password fields
- ✅ 1.3 MemberController updated with account creation logic and proper redirects

### ✅ Phase 2: Protect Service Routes (COMPLETED)
- ✅ 2.1 Service registration routes protected with auth middleware
- ✅ 2.2 ServiceRegistrationController updated to use authenticated member
- ✅ 2.3 Services view updated with auth checks and login prompts

### ✅ Phase 3: Quick Account Creation for Existing Members (COMPLETED)
- ✅ 3.1 Account creation route added
- ✅ 3.2 createAccount method added to MemberController
- ✅ 3.3 Quick account modal created and included in services page

---

## Next Steps

After completing Phase 1-3, we'll implement:
- Member profile dropdown menu
- Dashboard with service registrations
- Pending payments management
- Profile settings page
- Account deletion functionality

---

## Security Notes

✅ All implemented:
- Password hashing with bcrypt
- CSRF protection on all forms
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)
- Input validation
- Authentication middleware
- Email uniqueness validation

