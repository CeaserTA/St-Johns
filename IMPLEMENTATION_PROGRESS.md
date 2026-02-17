# Member Authentication Implementation Progress

## ✅ Completed

### Phase 1.2: Member Registration Form Updated
**File:** `resources/views/index.blade.php`

Added:
- ✅ "Create an account" checkbox
- ✅ Password and confirm password fields (hidden by default)
- ✅ JavaScript to show/hide password fields
- ✅ Required field validation
- ✅ User-friendly messaging

## 🔄 Next Steps (Continue in new session or implement manually)

### Phase 1.3: Update MemberController
**File:** `app/Http/Controllers/MemberController.php`

**Add after line 88 (after validation, before creating member):**

```php
// Check if user wants to create an account
$createAccount = $request->boolean('create_account');
$user = null;

if ($createAccount) {
    // Validate password fields
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);
    
    // Check if email already has a user account
    if ($request->email && \App\Models\User::where('email', $request->email)->exists()) {
        return back()->withErrors(['email' => 'An account with this email already exists. Please login instead.'])->withInput();
    }
    
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
```

**Update return statements (around line 200):**

```php
// After member creation, check if user was logged in
if ($user) {
    Auth::login($user);
    \Log::info('User auto-logged in after registration', ['user_id' => $user->id]);
}

// Handle AJAX requests (from admin modal)
if ($request->wantsJson() || $request->expectsJson()) {
    return response()->json([
        'success' => true,
        'message' => 'Member added successfully',
        'member' => [
            'id' => $member->id,
            'full_name' => $member->full_name,
            'email' => $member->email,
            'phone' => $member->phone,
            'profile_image_url' => $member->profile_image_url,
        ]
    ]);
}

// If an admin (authenticated user) created the member from the admin UI
if (Auth::check() && Auth::user()->role === 'admin') {
    return redirect()->route('members')->with('success', 'Member added successfully');
}

// If member just registered with account (auto-logged in)
if (Auth::check() && Auth::user()->role === 'member') {
    return redirect()->route('services')->with('success', 'Welcome! Your account has been created. You can now register for services.');
}

// Guest registration (no account created)
return redirect()->route('home')->with('success', 'Thank you for registering — we will contact you soon.');
```

### Phase 2: Protect Service Routes
**File:** `routes/web.php`

Find and wrap service registration routes with auth middleware.

### Phase 3: Update ServiceRegistrationController
Link registrations to member_id instead of guest fields.

### Phase 4: Update Services View
Show login prompt for unauthenticated users.

## Testing Checklist

- [ ] Register member WITHOUT account creation
- [ ] Register member WITH account creation
- [ ] Verify auto-login works
- [ ] Try to register for service (should require login)
- [ ] Complete full flow

## Files Modified So Far

1. ✅ `resources/views/index.blade.php` - Added account creation option
2. ⏳ `app/Http/Controllers/MemberController.php` - Needs update
3. ⏳ `routes/web.php` - Needs auth middleware
4. ⏳ `app/Http/Controllers/ServiceRegistrationController.php` - Needs update
5. ⏳ `resources/views/services.blade.php` - Needs login prompt

