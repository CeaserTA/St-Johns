# Design Document

## Overview

This design addresses two critical bugs in the member registration and account creation flow:

1. **Account Linking Bug**: When existing members create user accounts later, the accounts are not linked to their member profiles, preventing login and access to services/groups.

2. **Guest Registration Flow Bug**: Guests can create user accounts without first completing member registration, violating the business rule that all users must be registered members.

The solution implements proper account linking logic and enforces the correct registration flow for both existing members and new guests.

## Architecture

The fix follows Laravel's existing MVC architecture with enhancements to:

1. **Controller Layer**: Enhanced `MemberController::createAccount()` and `RegisteredUserController::store()` with proper linking logic
2. **View Layer**: Updated modals and forms to guide users through the correct flow
3. **Route Layer**: No changes needed - existing routes are sufficient
4. **Database Layer**: No schema changes needed - existing `user_id` foreign key in members table supports linking

### Current State Problems

**Problem 1: Account Linking**
```php
// MemberController::createAccount() creates user but doesn't link properly
$user = User::create([...]);
$member->update(['user_id' => $user->id]); // This line exists but may fail silently
```

**Problem 2: Guest Flow**
```php
// RegisteredUserController::store() creates user without checking for member
$user = User::create([...]);
// No check if member record exists
// No guidance to register as member first
```

### Target State

**Solution 1: Robust Account Linking**
- Verify member exists before creating account
- Use database transactions for atomic operations
- Properly link user_id to member record
- Handle edge cases (duplicate accounts, missing members)

**Solution 2: Enforced Registration Flow**
- Check if email exists in members table before account creation
- Redirect guests to member registration if not found
- Show clear messaging about required steps
- Seamlessly transition from member registration to account creation

## Components and Interfaces

### 1. MemberController::createAccount() Enhancement

**File**: `app/Http/Controllers/MemberController.php`

**Current Issues**:
- May not properly handle transaction failures
- Error messages not specific enough
- No validation that member doesn't already have an account

**Required Changes**:
```php
public function createAccount(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:members,email',
        'password' => 'required|string|min:8|confirmed',
    ]);
    
    DB::beginTransaction();
    try {
        // Find member by email
        $member = Member::where('email', $request->email)->first();
        
        if (!$member) {
            throw new \Exception('Member not found with this email.');
        }
        
        // Check if member already has an account
        if ($member->user_id) {
            $existingUser = User::find($member->user_id);
            if ($existingUser) {
                throw new \Exception('This member already has an account. Please login.');
            }
        }
        
        // Check if email already has a user account (orphaned account)
        if (User::where('email', $request->email)->exists()) {
            throw new \Exception('An account with this email already exists. Please login.');
        }
        
        // Create user account
        $user = User::create([
            'name' => $member->full_name,
            'email' => $member->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]);
        
        // Link user to member
        $member->user_id = $user->id;
        $member->save();
        
        DB::commit();
        
        // Auto-login
        Auth::login($user);
        
        return redirect()->route('services')->with('success', 'Account created successfully! You can now register for services.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage())->withInput();
    }
}
```

### 2. RegisteredUserController::store() Enhancement

**File**: `app/Http/Controllers/Auth/RegisteredUserController.php`

**Current Issues**:
- Creates user accounts without checking for member registration
- No guidance for guests to register as members first

**Required Changes**:
```php
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Check if email exists in members table
    $member = Member::where('email', $request->email)->first();
    
    if (!$member) {
        // Guest trying to create account without member registration
        return back()
            ->withInput()
            ->with('error', 'You must register as a church member before creating an account.')
            ->with('show_member_registration', true);
    }
    
    // Check if member already has an account
    if ($member->user_id) {
        return back()
            ->withInput()
            ->with('error', 'This email is already registered. Please login instead.');
    }

    DB::beginTransaction();
    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]);

        // Link to existing member
        $member->user_id = $user->id;
        $member->save();

        event(new Registered($user));

        Auth::login($user);
        
        DB::commit();

        return redirect()->route('services')->with('success', 'Welcome! Your account is ready.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->withInput()
            ->with('error', 'Account creation failed. Please try again.');
    }
}
```

### 3. Quick Account Modal Enhancement

**File**: `resources/views/partials/quick-account-modal.blade.php`

**Required Changes**:
- Add better error display
- Show guidance message about member registration requirement
- Add link to member registration modal if needed

### 4. Member Registration Modal Enhancement

**File**: `resources/views/partials/member-registration-modal.blade.php` (if exists) or inline in services page

**Required Changes**:
- After successful member registration, automatically show account creation modal
- Pre-fill email in account creation form
- Add clear messaging about next steps

### 5. Services Page Enhancement

**File**: `resources/views/services.blade.php`

**Required Changes**:
- Detect when user needs to register as member first
- Show appropriate modal based on user state
- Handle session flash messages for redirects

## Data Models

No changes to data models required. The existing structure supports the fix:

```php
// User Model (app/Models/User.php)
class User extends Authenticatable
{
    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }
}

// Member Model (app/Models/Member.php)
class Member extends Model
{
    protected $fillable = [
        'user_id',  // This field is key for linking
        'full_name',
        'email',
        // ... other fields
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system-essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Account-Member Linking Integrity
*For any* existing member who creates a user account, the member record's user_id field should be set to the new user's ID, creating a valid bidirectional relationship
**Validates: Requirements 1.1, 1.2**

### Property 2: No Orphaned Accounts
*For any* user account created through the registration flow, there should exist a corresponding member record linked via user_id
**Validates: Requirements 2.1, 2.4, 3.1**

### Property 3: No Duplicate Accounts
*For any* member record, there should be at most one user account linked to it
**Validates: Requirements 1.3, 3.3**

### Property 4: Guest Registration Enforcement
*For any* guest attempting to create an account, if no member record exists for their email, the account creation should fail and redirect to member registration
**Validates: Requirements 2.1, 2.2, 2.5**

### Property 5: Transaction Atomicity
*For any* account creation or linking operation, either both the user account is created AND the member is linked, or neither operation succeeds
**Validates: Requirements 3.4, 3.5**

## Error Handling

### Error Scenarios and Responses

| Scenario | Error Handling | User Feedback |
|----------|---------------|---------------|
| Guest creates account without member registration | Prevent account creation, redirect to member registration | "You must register as a church member before creating an account." |
| Existing member creates account with wrong email | Validation fails | "No member found with this email address." |
| Member already has account | Prevent duplicate account | "This member already has an account. Please login." |
| Email already has user account | Prevent duplicate account | "An account with this email already exists. Please login." |
| Database transaction fails | Rollback all changes | "Account creation failed. Please try again." |
| Member linking fails | Rollback user creation | "Failed to link account to member profile. Please contact support." |

### Transaction Safety

All account creation and linking operations will use database transactions:

```php
DB::beginTransaction();
try {
    // Create user
    // Link to member
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    // Handle error
}
```

## Testing Strategy

### Unit Tests

1. **Test existing member account creation**:
   - Create member without user_id
   - Call createAccount with member's email
   - Verify user created and linked to member
   - Verify user can login

2. **Test guest account creation prevention**:
   - Attempt to create account with non-member email
   - Verify account not created
   - Verify appropriate error message

3. **Test duplicate account prevention**:
   - Create member with existing user_id
   - Attempt to create another account
   - Verify second account not created

4. **Test transaction rollback**:
   - Simulate database error during linking
   - Verify user account not created
   - Verify member record unchanged

### Property-Based Tests

Property-based tests will use PHPUnit. Each test will run a minimum of 100 iterations.

1. **Property 1 Test**: Generate random members and create accounts, verify all have valid user_id links
   - **Feature: member-account-linking-fix, Property 1: Account-Member Linking Integrity**

2. **Property 2 Test**: Generate random user accounts, verify all have corresponding member records
   - **Feature: member-account-linking-fix, Property 2: No Orphaned Accounts**

3. **Property 3 Test**: Generate random members, verify none have multiple user accounts
   - **Feature: member-account-linking-fix, Property 3: No Duplicate Accounts**

4. **Property 4 Test**: Generate random emails (some members, some not), verify non-members cannot create accounts
   - **Feature: member-account-linking-fix, Property 4: Guest Registration Enforcement**

5. **Property 5 Test**: Simulate random transaction failures, verify no partial states exist
   - **Feature: member-account-linking-fix, Property 5: Transaction Atomicity**

### Integration Tests

1. **Full flow test - existing member**:
   - Register as member without account
   - Create account via quick account modal
   - Verify login works
   - Verify can access services

2. **Full flow test - new guest**:
   - Attempt to create account
   - Verify redirected to member registration
   - Complete member registration
   - Create account
   - Verify login and service access

3. **Edge case test - concurrent account creation**:
   - Simulate two simultaneous account creation attempts for same member
   - Verify only one succeeds

### Manual Testing Checklist

- [ ] Register as member without creating account
- [ ] Logout
- [ ] Click "Create Account" from services page
- [ ] Enter member email and password
- [ ] Verify account created and logged in
- [ ] Verify can register for services
- [ ] Logout
- [ ] Try to create another account with same email
- [ ] Verify error message about existing account
- [ ] As guest, try to create account without member registration
- [ ] Verify redirected to member registration
- [ ] Complete member registration
- [ ] Verify prompted to create account
- [ ] Create account and verify access

## Implementation Notes

### Critical Files to Update

1. `app/Http/Controllers/MemberController.php` - Fix createAccount() method
2. `app/Http/Controllers/Auth/RegisteredUserController.php` - Add member check
3. `resources/views/partials/quick-account-modal.blade.php` - Better error display
4. `resources/views/services.blade.php` - Handle registration flow redirects

### Database Transaction Pattern

Always use this pattern for account operations:

```php
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
try {
    // 1. Create or find user
    // 2. Link to member
    // 3. Verify link successful
    DB::commit();
    // 4. Auto-login
    // 5. Redirect with success
} catch (\Exception $e) {
    DB::rollBack();
    // Log error
    // Return with error message
}
```

### Session Flash Messages

Use consistent flash message keys:
- `success` - Operation succeeded
- `error` - Operation failed
- `show_member_registration` - Trigger member registration modal
- `show_account_creation` - Trigger account creation modal
- `prefill_email` - Pre-fill email in forms

### Logging

Add comprehensive logging for debugging:
```php
\Log::info('Account creation attempt', ['email' => $email]);
\Log::info('Member found', ['member_id' => $member->id]);
\Log::info('User created and linked', ['user_id' => $user->id, 'member_id' => $member->id]);
\Log::error('Account linking failed', ['error' => $e->getMessage()]);
```
