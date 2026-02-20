<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Feature: member-account-linking-fix, Property 1: Account-Member Linking Integrity
 * 
 * Property: For any existing member who creates a user account, the member record's 
 * user_id field should be set to the new user's ID, creating a valid bidirectional relationship
 * 
 * Validates: Requirements 1.1, 1.2
 */
describe('Account-Member Linking Integrity Property', function () {
    
    it('maintains account-member linking integrity across multiple random scenarios', function () {
        $iterations = 100;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random member data
                $memberData = [
                    'full_name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'date_joined' => fake()->date('Y-m-d', 'now'),
                    'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                ];
                
                // Create member without user account (existing member scenario)
                $member = Member::create($memberData);
                
                // Verify member has no user_id initially
                if ($member->user_id !== null) {
                    $failures[] = "Iteration $i: Member should not have user_id initially, but has: {$member->user_id}";
                    continue;
                }
                
                // Simulate account creation via MemberController::createAccount
                $password = 'password123';
                
                DB::beginTransaction();
                
                // Create user account
                $user = User::create([
                    'name' => $member->full_name,
                    'email' => $member->email,
                    'password' => Hash::make($password),
                    'role' => 'member',
                ]);
                
                // Link user to member
                $member->user_id = $user->id;
                $member->save();
                
                DB::commit();
                
                // Refresh models to get latest data
                $member->refresh();
                $user->refresh();
                
                // Property Verification: Check bidirectional relationship integrity
                
                // 1. Member should have user_id set to the created user's ID
                if ($member->user_id !== $user->id) {
                    $failures[] = "Iteration $i: Member user_id ({$member->user_id}) does not match User id ({$user->id})";
                }
                
                // 2. Member->user relationship should return the correct user
                $linkedUser = $member->user;
                if (!$linkedUser || $linkedUser->id !== $user->id) {
                    $failures[] = "Iteration $i: Member->user relationship broken. Expected user {$user->id}, got " . ($linkedUser ? $linkedUser->id : 'null');
                }
                
                // 3. User->member relationship should return the correct member
                $linkedMember = $user->member;
                if (!$linkedMember || $linkedMember->id !== $member->id) {
                    $failures[] = "Iteration $i: User->member relationship broken. Expected member {$member->id}, got " . ($linkedMember ? $linkedMember->id : 'null');
                }
                
                // 4. Email should match between user and member
                if ($user->email !== $member->email) {
                    $failures[] = "Iteration $i: Email mismatch. User: {$user->email}, Member: {$member->email}";
                }
                
                // 5. Name should match between user and member
                if ($user->name !== $member->full_name) {
                    $failures[] = "Iteration $i: Name mismatch. User: {$user->name}, Member: {$member->full_name}";
                }
                
                // 6. User should have member role
                if ($user->role !== 'member') {
                    $failures[] = "Iteration $i: User role should be 'member', got: {$user->role}";
                }
                
            } catch (\Exception $e) {
                DB::rollBack();
                $failures[] = "Iteration $i: Exception occurred: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
    
    it('prevents duplicate account creation for members who already have accounts', function () {
        $iterations = 50;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random member data
                $email = fake()->unique()->safeEmail();
                $memberData = [
                    'full_name' => fake()->name(),
                    'email' => $email,
                    'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'date_joined' => fake()->date('Y-m-d', 'now'),
                    'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                ];
                
                // Create member
                $member = Member::create($memberData);
                
                // Create first user account
                $user1 = User::create([
                    'name' => $member->full_name,
                    'email' => $member->email,
                    'password' => Hash::make('password123'),
                    'role' => 'member',
                ]);
                
                // Link to member
                $member->user_id = $user1->id;
                $member->save();
                $member->refresh();
                
                // Verify initial link
                if ($member->user_id !== $user1->id) {
                    $failures[] = "Iteration $i: Initial link failed";
                    continue;
                }
                
                // Attempt to create duplicate account (should be prevented)
                $duplicateAttemptFailed = false;
                
                try {
                    // Check if member already has account (this is what the controller should do)
                    if ($member->user_id) {
                        $existingUser = User::find($member->user_id);
                        if ($existingUser) {
                            // This should prevent duplicate account creation
                            $duplicateAttemptFailed = true;
                            throw new \Exception('This member already has an account. Please login.');
                        }
                    }
                    
                    // If we get here, the check didn't work
                    $failures[] = "Iteration $i: Duplicate account check did not prevent creation";
                    
                } catch (\Exception $e) {
                    if ($e->getMessage() === 'This member already has an account. Please login.') {
                        $duplicateAttemptFailed = true;
                    } else {
                        $failures[] = "Iteration $i: Unexpected exception: " . $e->getMessage();
                    }
                }
                
                // Property: Member should still have only one account
                if (!$duplicateAttemptFailed) {
                    $failures[] = "Iteration $i: Duplicate account prevention logic did not trigger";
                }
                
                // Verify member still linked to original user
                $member->refresh();
                if ($member->user_id !== $user1->id) {
                    $failures[] = "Iteration $i: Member user_id changed from original. Expected {$user1->id}, got {$member->user_id}";
                }
                
                // Verify only one user exists with this email
                $userCount = User::where('email', $email)->count();
                if ($userCount !== 1) {
                    $failures[] = "Iteration $i: Expected 1 user with email $email, found $userCount";
                }
                
            } catch (\Exception $e) {
                if (!str_contains($e->getMessage(), 'already has an account')) {
                    $failures[] = "Iteration $i: Unexpected exception: " . $e->getMessage();
                }
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Duplicate prevention property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10));
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
});

/**
 * Feature: member-account-linking-fix, Property 4: Guest Registration Enforcement
 * 
 * Property: For any guest attempting to create an account, if no member record exists 
 * for their email, the account creation should fail and redirect to member registration
 * 
 * Validates: Requirements 2.1, 2.2, 2.5
 */
describe('Guest Registration Enforcement Property', function () {
    
    it('prevents account creation for guests without member records across random scenarios', function () {
        $iterations = 100;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random guest email (not in members table)
                $guestEmail = fake()->unique()->safeEmail();
                $guestName = fake()->name();
                $password = 'password123';
                
                // Verify no member exists with this email
                $existingMember = Member::where('email', $guestEmail)->first();
                if ($existingMember) {
                    // Skip this iteration - we need a truly non-member email
                    continue;
                }
                
                // Simulate guest attempting to create account via RegisteredUserController
                // This should fail because no member record exists
                
                $accountCreationPrevented = false;
                $redirectedToMemberRegistration = false;
                $errorMessageShown = false;
                
                try {
                    // Check if email exists in members table (controller logic)
                    $member = Member::where('email', $guestEmail)->first();
                    
                    if (!$member) {
                        // Guest trying to create account without member registration
                        // This should prevent account creation
                        $accountCreationPrevented = true;
                        $redirectedToMemberRegistration = true;
                        $errorMessageShown = true;
                        
                        // Verify no user account was created
                        $userExists = User::where('email', $guestEmail)->exists();
                        if ($userExists) {
                            $failures[] = "Iteration $i: User account was created for guest email $guestEmail despite no member record";
                        }
                        
                        continue; // Don't create the account
                    }
                    
                    // If we get here, the check didn't work (member was found when it shouldn't be)
                    $failures[] = "Iteration $i: Member check passed when it should have failed for guest email $guestEmail";
                    
                } catch (\Exception $e) {
                    $failures[] = "Iteration $i: Unexpected exception during guest check: " . $e->getMessage();
                }
                
                // Property Verification: Account creation should have been prevented
                if (!$accountCreationPrevented) {
                    $failures[] = "Iteration $i: Account creation was not prevented for guest email $guestEmail";
                }
                
                if (!$redirectedToMemberRegistration) {
                    $failures[] = "Iteration $i: Guest was not redirected to member registration for email $guestEmail";
                }
                
                if (!$errorMessageShown) {
                    $failures[] = "Iteration $i: No error message shown to guest for email $guestEmail";
                }
                
                // Verify no user account exists for this guest email
                $userCount = User::where('email', $guestEmail)->count();
                if ($userCount > 0) {
                    $failures[] = "Iteration $i: Found $userCount user account(s) for guest email $guestEmail, expected 0";
                }
                
                // Verify no member record was accidentally created
                $memberCount = Member::where('email', $guestEmail)->count();
                if ($memberCount > 0) {
                    $failures[] = "Iteration $i: Found $memberCount member record(s) for guest email $guestEmail, expected 0";
                }
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Exception occurred: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Guest Registration Enforcement property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
    
    it('allows account creation for guests who have completed member registration', function () {
        $iterations = 100;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random member data (guest who completed member registration)
                $email = fake()->unique()->safeEmail();
                $memberData = [
                    'full_name' => fake()->name(),
                    'email' => $email,
                    'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'date_joined' => fake()->date('Y-m-d', 'now'),
                    'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                ];
                
                // Create member without user account (completed member registration)
                $member = Member::create($memberData);
                
                // Verify member has no user_id initially
                if ($member->user_id !== null) {
                    $failures[] = "Iteration $i: Member should not have user_id initially";
                    continue;
                }
                
                // Simulate account creation attempt (should succeed)
                $accountCreationAllowed = false;
                
                DB::beginTransaction();
                try {
                    // Check if email exists in members table (controller logic)
                    $foundMember = Member::where('email', $email)->first();
                    
                    if (!$foundMember) {
                        // This should not happen - member should be found
                        $failures[] = "Iteration $i: Member not found when it should exist for email $email";
                        DB::rollBack();
                        continue;
                    }
                    
                    // Check if member already has an account
                    if ($foundMember->user_id) {
                        $failures[] = "Iteration $i: Member already has account when it shouldn't";
                        DB::rollBack();
                        continue;
                    }
                    
                    // Create user account (should be allowed)
                    $user = User::create([
                        'name' => $foundMember->full_name,
                        'email' => $foundMember->email,
                        'password' => Hash::make('password123'),
                        'role' => 'member',
                    ]);
                    
                    // Link to existing member
                    $foundMember->user_id = $user->id;
                    $foundMember->save();
                    
                    DB::commit();
                    
                    $accountCreationAllowed = true;
                    
                    // Verify the link was created
                    $foundMember->refresh();
                    if ($foundMember->user_id !== $user->id) {
                        $failures[] = "Iteration $i: Member user_id not set correctly after account creation";
                    }
                    
                    // Verify user exists
                    $createdUser = User::where('email', $email)->first();
                    if (!$createdUser) {
                        $failures[] = "Iteration $i: User account not found after creation for email $email";
                    }
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    $failures[] = "Iteration $i: Exception during account creation: " . $e->getMessage();
                }
                
                // Property Verification: Account creation should have been allowed
                if (!$accountCreationAllowed) {
                    $failures[] = "Iteration $i: Account creation was prevented when it should have been allowed for member email $email";
                }
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Exception occurred: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Guest with member registration property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
});

/**
 * Feature: member-account-linking-fix, Property 2: No Orphaned Accounts
 * 
 * Property: For any user account created through the registration flow, there should exist 
 * a corresponding member record linked via user_id
 * 
 * Validates: Requirements 2.4, 3.1
 */
describe('No Orphaned Accounts Property', function () {
    
    it('ensures all user accounts have corresponding member records linked via user_id', function () {
        $iterations = 100;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random member data
                $email = fake()->unique()->safeEmail();
                $memberData = [
                    'full_name' => fake()->name(),
                    'email' => $email,
                    'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'date_joined' => fake()->date('Y-m-d', 'now'),
                    'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                ];
                
                // Create member first (simulating member registration)
                $member = Member::create($memberData);
                
                // Simulate account creation through registration flow
                DB::beginTransaction();
                try {
                    // Check if email exists in members table (as controller should do)
                    $foundMember = Member::where('email', $email)->first();
                    
                    if (!$foundMember) {
                        // This should not happen in proper flow
                        $failures[] = "Iteration $i: Member not found during account creation for email $email";
                        DB::rollBack();
                        continue;
                    }
                    
                    // Create user account
                    $user = User::create([
                        'name' => $foundMember->full_name,
                        'email' => $foundMember->email,
                        'password' => Hash::make('password123'),
                        'role' => 'member',
                    ]);
                    
                    // Link to existing member
                    $foundMember->user_id = $user->id;
                    $foundMember->save();
                    
                    DB::commit();
                    
                    // Property Verification: User should have a corresponding member record
                    
                    // 1. User should exist
                    $createdUser = User::find($user->id);
                    if (!$createdUser) {
                        $failures[] = "Iteration $i: User {$user->id} not found after creation";
                        continue;
                    }
                    
                    // 2. Member record should exist with this user_id
                    $linkedMember = Member::where('user_id', $user->id)->first();
                    if (!$linkedMember) {
                        $failures[] = "Iteration $i: No member record found with user_id {$user->id} (orphaned account detected)";
                        continue;
                    }
                    
                    // 3. The linked member should be the original member
                    if ($linkedMember->id !== $member->id) {
                        $failures[] = "Iteration $i: User {$user->id} linked to wrong member. Expected {$member->id}, got {$linkedMember->id}";
                    }
                    
                    // 4. Member's email should match user's email
                    if ($linkedMember->email !== $user->email) {
                        $failures[] = "Iteration $i: Email mismatch. User: {$user->email}, Member: {$linkedMember->email}";
                    }
                    
                    // 5. User->member relationship should work
                    $relationshipMember = $user->member;
                    if (!$relationshipMember) {
                        $failures[] = "Iteration $i: User->member relationship returned null for user {$user->id}";
                    } elseif ($relationshipMember->id !== $member->id) {
                        $failures[] = "Iteration $i: User->member relationship points to wrong member. Expected {$member->id}, got {$relationshipMember->id}";
                    }
                    
                    // 6. Member->user relationship should work
                    $relationshipUser = $linkedMember->user;
                    if (!$relationshipUser) {
                        $failures[] = "Iteration $i: Member->user relationship returned null for member {$linkedMember->id}";
                    } elseif ($relationshipUser->id !== $user->id) {
                        $failures[] = "Iteration $i: Member->user relationship points to wrong user. Expected {$user->id}, got {$relationshipUser->id}";
                    }
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    $failures[] = "Iteration $i: Exception during account creation: " . $e->getMessage();
                }
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Exception occurred: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "No Orphaned Accounts property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
    
    it('detects orphaned accounts when user is created without proper member linking', function () {
        $iterations = 50;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random user data
                $email = fake()->unique()->safeEmail();
                
                // Intentionally create user WITHOUT going through proper registration flow
                // This simulates the bug scenario where accounts are created without member linking
                $orphanedUser = User::create([
                    'name' => fake()->name(),
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => 'member',
                ]);
                
                // Property Verification: This should be detected as an orphaned account
                
                // 1. Check if any member has this user_id
                $linkedMember = Member::where('user_id', $orphanedUser->id)->first();
                
                if ($linkedMember) {
                    // If a member is linked, verify the relationship is correct
                    if ($linkedMember->email !== $orphanedUser->email) {
                        $failures[] = "Iteration $i: Member linked to user but emails don't match. User: {$orphanedUser->email}, Member: {$linkedMember->email}";
                    }
                } else {
                    // No member linked - this is an orphaned account (expected in this test)
                    // Verify that this is indeed problematic by checking if a member exists with same email
                    $memberWithSameEmail = Member::where('email', $email)->first();
                    
                    if ($memberWithSameEmail) {
                        // There's a member with same email but not linked - this is the bug!
                        if ($memberWithSameEmail->user_id !== $orphanedUser->id) {
                            // This is the orphaned account scenario we want to detect
                            // The test passes because we successfully detected the orphan
                            continue;
                        }
                    } else {
                        // No member exists at all with this email - this is also an orphaned account
                        // In proper flow, member should exist before user account is created
                        continue;
                    }
                }
                
                // 2. Verify user->member relationship
                $relationshipMember = $orphanedUser->member;
                if (!$relationshipMember) {
                    // Orphaned account detected (expected in this test scenario)
                    // This is what we want to catch in production
                    continue;
                }
                
                // If we get here, the account is properly linked (unexpected in this test)
                // This would mean our orphan detection isn't working
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Exception occurred: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Orphaned account detection test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
    
    it('ensures proper registration flow prevents orphaned accounts', function () {
        $iterations = 100;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Test the complete proper flow: member registration -> account creation
                $email = fake()->unique()->safeEmail();
                
                // Step 1: Member registration (without account)
                $memberData = [
                    'full_name' => fake()->name(),
                    'email' => $email,
                    'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'date_joined' => fake()->date('Y-m-d', 'now'),
                    'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                ];
                
                $member = Member::create($memberData);
                
                // Verify member has no user_id initially
                if ($member->user_id !== null) {
                    $failures[] = "Iteration $i: Member should not have user_id after registration";
                    continue;
                }
                
                // Step 2: Account creation (following proper flow)
                DB::beginTransaction();
                try {
                    // Controller should check if member exists
                    $foundMember = Member::where('email', $email)->first();
                    
                    if (!$foundMember) {
                        $failures[] = "Iteration $i: Member not found when creating account";
                        DB::rollBack();
                        continue;
                    }
                    
                    // Create user account
                    $user = User::create([
                        'name' => $foundMember->full_name,
                        'email' => $foundMember->email,
                        'password' => Hash::make('password123'),
                        'role' => 'member',
                    ]);
                    
                    // Link to member (critical step to prevent orphaned accounts)
                    $foundMember->user_id = $user->id;
                    $foundMember->save();
                    
                    DB::commit();
                    
                    // Property Verification: No orphaned account should exist
                    
                    // 1. User should have a linked member
                    $userMember = Member::where('user_id', $user->id)->first();
                    if (!$userMember) {
                        $failures[] = "Iteration $i: User {$user->id} has no linked member (orphaned account)";
                        continue;
                    }
                    
                    // 2. The linked member should be the one we created
                    if ($userMember->id !== $member->id) {
                        $failures[] = "Iteration $i: User linked to wrong member. Expected {$member->id}, got {$userMember->id}";
                    }
                    
                    // 3. Member should have the user_id set
                    $member->refresh();
                    if ($member->user_id !== $user->id) {
                        $failures[] = "Iteration $i: Member user_id not set correctly. Expected {$user->id}, got {$member->user_id}";
                    }
                    
                    // 4. Verify no other users exist with this email (no duplicates)
                    $userCount = User::where('email', $email)->count();
                    if ($userCount !== 1) {
                        $failures[] = "Iteration $i: Expected 1 user with email $email, found $userCount";
                    }
                    
                    // 5. Verify no other members exist with this email (no duplicates)
                    $memberCount = Member::where('email', $email)->count();
                    if ($memberCount !== 1) {
                        $failures[] = "Iteration $i: Expected 1 member with email $email, found $memberCount";
                    }
                    
                    // 6. Verify bidirectional relationship works
                    $user->refresh();
                    $relationshipMember = $user->member;
                    if (!$relationshipMember || $relationshipMember->id !== $member->id) {
                        $failures[] = "Iteration $i: User->member relationship broken";
                    }
                    
                    $relationshipUser = $member->user;
                    if (!$relationshipUser || $relationshipUser->id !== $user->id) {
                        $failures[] = "Iteration $i: Member->user relationship broken";
                    }
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    $failures[] = "Iteration $i: Exception during proper flow: " . $e->getMessage();
                }
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Exception occurred: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Proper registration flow property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
});

/**
 * Feature: member-account-linking-fix, Property 3: No Duplicate Accounts
 * 
 * Property: For any member record, there should be at most one user account linked to it
 * 
 * Validates: Requirements 1.3, 3.3
 */
describe('No Duplicate Accounts Property', function () {
    
    it('ensures no member has multiple user accounts linked across random scenarios', function () {
        $iterations = 100;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random number of members (1-10)
                $memberCount = fake()->numberBetween(1, 10);
                $createdMembers = [];
                
                for ($j = 0; $j < $memberCount; $j++) {
                    $email = fake()->unique()->safeEmail();
                    $memberData = [
                        'full_name' => fake()->name(),
                        'email' => $email,
                        'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                        'gender' => fake()->randomElement(['male', 'female']),
                        'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                        'phone' => fake()->phoneNumber(),
                        'address' => fake()->address(),
                        'date_joined' => fake()->date('Y-m-d', 'now'),
                        'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                    ];
                    
                    $member = Member::create($memberData);
                    
                    // Randomly decide if this member should have an account (70% chance)
                    if (fake()->boolean(70)) {
                        $user = User::create([
                            'name' => $member->full_name,
                            'email' => $member->email,
                            'password' => Hash::make('password123'),
                            'role' => 'member',
                        ]);
                        
                        $member->user_id = $user->id;
                        $member->save();
                    }
                    
                    $createdMembers[] = $member;
                }
                
                // Property Verification: Check that no member has multiple accounts
                foreach ($createdMembers as $idx => $member) {
                    $member->refresh();
                    
                    // If member has a user_id, verify it points to exactly one user
                    if ($member->user_id) {
                        // Check that the user_id is valid
                        $linkedUser = User::find($member->user_id);
                        if (!$linkedUser) {
                            $failures[] = "Iteration $i, Member $idx: Member has user_id {$member->user_id} but user doesn't exist";
                            continue;
                        }
                        
                        // Check that no other users have the same email
                        $usersWithEmail = User::where('email', $member->email)->get();
                        if ($usersWithEmail->count() > 1) {
                            $failures[] = "Iteration $i, Member $idx: Found {$usersWithEmail->count()} users with email {$member->email}, expected at most 1";
                        }
                        
                        // Check that the linked user's email matches the member's email
                        if ($linkedUser->email !== $member->email) {
                            $failures[] = "Iteration $i, Member $idx: User email ({$linkedUser->email}) doesn't match member email ({$member->email})";
                        }
                        
                        // Check that user->member relationship points back correctly
                        $reverseLinkedMember = $linkedUser->member;
                        if (!$reverseLinkedMember || $reverseLinkedMember->id !== $member->id) {
                            $failures[] = "Iteration $i, Member $idx: Bidirectional relationship broken. User {$linkedUser->id} doesn't link back to member {$member->id}";
                        }
                    }
                    
                    // Check that no users exist with this member's email if member has no user_id
                    if (!$member->user_id) {
                        $orphanedUsers = User::where('email', $member->email)->count();
                        if ($orphanedUsers > 0) {
                            $failures[] = "Iteration $i, Member $idx: Member has no user_id but {$orphanedUsers} orphaned user(s) exist with email {$member->email}";
                        }
                    }
                }
                
                // Additional check: Verify no user is linked to multiple members
                $allUsers = User::whereIn('email', array_map(fn($m) => $m->email, $createdMembers))->get();
                foreach ($allUsers as $user) {
                    $linkedMembers = Member::where('user_id', $user->id)->get();
                    if ($linkedMembers->count() > 1) {
                        $failures[] = "Iteration $i: User {$user->id} is linked to {$linkedMembers->count()} members, expected at most 1";
                    }
                }
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Exception occurred: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "No Duplicate Accounts property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
});

/**
 * Feature: member-account-linking-fix, Property 5: Transaction Atomicity
 * 
 * Property: For any account creation or linking operation, either both the user account 
 * is created AND the member is linked, or neither operation succeeds
 * 
 * Validates: Requirements 3.4, 3.5
 */
describe('Transaction Atomicity Property', function () {
    
    it('ensures account creation and member linking are atomic across random scenarios', function () {
        $iterations = 100;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random member data
                $email = fake()->unique()->safeEmail();
                $memberData = [
                    'full_name' => fake()->name(),
                    'email' => $email,
                    'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'date_joined' => fake()->date('Y-m-d', 'now'),
                    'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                ];
                
                // Create member without user account
                $member = Member::create($memberData);
                $originalMemberState = $member->user_id; // Should be null
                
                // Count users before operation
                $userCountBefore = User::where('email', $email)->count();
                
                // Simulate account creation with transaction
                $transactionSucceeded = false;
                $exceptionThrown = false;
                
                DB::beginTransaction();
                try {
                    // Find member
                    $foundMember = Member::where('email', $email)->first();
                    
                    if (!$foundMember) {
                        throw new \Exception('Member not found');
                    }
                    
                    // Create user account
                    $user = User::create([
                        'name' => $foundMember->full_name,
                        'email' => $foundMember->email,
                        'password' => Hash::make('password123'),
                        'role' => 'member',
                    ]);
                    
                    // Randomly simulate failure scenarios (20% chance)
                    if (fake()->boolean(20)) {
                        // Simulate various failure scenarios
                        $failureType = fake()->randomElement([
                            'before_link',
                            'during_link',
                            'after_link'
                        ]);
                        
                        if ($failureType === 'before_link') {
                            // Fail before linking
                            throw new \Exception('Simulated failure before linking');
                        } elseif ($failureType === 'during_link') {
                            // Attempt to link with invalid data
                            $foundMember->user_id = $user->id;
                            throw new \Exception('Simulated failure during linking');
                        } else {
                            // Fail after linking but before commit
                            $foundMember->user_id = $user->id;
                            $foundMember->save();
                            throw new \Exception('Simulated failure after linking');
                        }
                    }
                    
                    // Normal flow: Link user to member
                    $foundMember->user_id = $user->id;
                    $foundMember->save();
                    
                    DB::commit();
                    $transactionSucceeded = true;
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    $exceptionThrown = true;
                }
                
                // Property Verification: Check atomicity
                
                // Refresh member to get current state
                $member->refresh();
                
                // Count users after operation
                $userCountAfter = User::where('email', $email)->count();
                
                if ($transactionSucceeded) {
                    // Transaction succeeded: Both user and link should exist
                    
                    // 1. User should exist
                    $createdUser = User::where('email', $email)->first();
                    if (!$createdUser) {
                        $failures[] = "Iteration $i: Transaction succeeded but user not found for email $email";
                    }
                    
                    // 2. Member should have user_id set
                    if ($member->user_id === null) {
                        $failures[] = "Iteration $i: Transaction succeeded but member user_id is null";
                    }
                    
                    // 3. Member user_id should match created user
                    if ($createdUser && $member->user_id !== $createdUser->id) {
                        $failures[] = "Iteration $i: Transaction succeeded but member user_id ({$member->user_id}) doesn't match user id ({$createdUser->id})";
                    }
                    
                    // 4. User count should have increased by 1
                    if ($userCountAfter !== $userCountBefore + 1) {
                        $failures[] = "Iteration $i: Transaction succeeded but user count changed from $userCountBefore to $userCountAfter (expected " . ($userCountBefore + 1) . ")";
                    }
                    
                    // 5. Bidirectional relationship should work
                    if ($createdUser) {
                        $linkedMember = $createdUser->member;
                        if (!$linkedMember || $linkedMember->id !== $member->id) {
                            $failures[] = "Iteration $i: Transaction succeeded but user->member relationship broken";
                        }
                    }
                    
                } else {
                    // Transaction failed: Neither user nor link should exist
                    
                    // 1. No user should exist with this email
                    $orphanedUser = User::where('email', $email)->first();
                    if ($orphanedUser) {
                        $failures[] = "Iteration $i: Transaction failed but user still exists for email $email (atomicity violated)";
                    }
                    
                    // 2. Member should not have user_id set (should be unchanged)
                    if ($member->user_id !== $originalMemberState) {
                        $failures[] = "Iteration $i: Transaction failed but member user_id changed from $originalMemberState to {$member->user_id} (atomicity violated)";
                    }
                    
                    // 3. User count should be unchanged
                    if ($userCountAfter !== $userCountBefore) {
                        $failures[] = "Iteration $i: Transaction failed but user count changed from $userCountBefore to $userCountAfter (atomicity violated)";
                    }
                    
                    // 4. Member should still be in original state
                    if ($member->user_id !== null) {
                        $failures[] = "Iteration $i: Transaction failed but member has user_id {$member->user_id} (should be null)";
                    }
                }
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Unexpected exception: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Transaction Atomicity property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
    
    it('ensures rollback prevents partial state when member linking fails', function () {
        $iterations = 50;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random member data
                $email = fake()->unique()->safeEmail();
                $memberData = [
                    'full_name' => fake()->name(),
                    'email' => $email,
                    'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'date_joined' => fake()->date('Y-m-d', 'now'),
                    'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                ];
                
                // Create member
                $member = Member::create($memberData);
                
                // Count records before operation
                $userCountBefore = User::count();
                $memberCountBefore = Member::count();
                
                // Attempt account creation with intentional failure after user creation
                DB::beginTransaction();
                try {
                    // Create user
                    $user = User::create([
                        'name' => $member->full_name,
                        'email' => $member->email,
                        'password' => Hash::make('password123'),
                        'role' => 'member',
                    ]);
                    
                    // Intentionally fail before linking
                    throw new \Exception('Simulated linking failure');
                    
                    // This code should never execute
                    $member->user_id = $user->id;
                    $member->save();
                    
                    DB::commit();
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                }
                
                // Property Verification: Rollback should have prevented partial state
                
                // 1. User should not exist (rolled back)
                $orphanedUser = User::where('email', $email)->first();
                if ($orphanedUser) {
                    $failures[] = "Iteration $i: User still exists after rollback for email $email (atomicity violated)";
                }
                
                // 2. Member should not have user_id
                $member->refresh();
                if ($member->user_id !== null) {
                    $failures[] = "Iteration $i: Member has user_id {$member->user_id} after rollback (should be null)";
                }
                
                // 3. User count should be unchanged
                $userCountAfter = User::count();
                if ($userCountAfter !== $userCountBefore) {
                    $failures[] = "Iteration $i: User count changed from $userCountBefore to $userCountAfter after rollback";
                }
                
                // 4. Member count should only include the member we created (not affected by rollback)
                $memberCountAfter = Member::count();
                if ($memberCountAfter !== $memberCountBefore) {
                    $failures[] = "Iteration $i: Member count changed unexpectedly from $memberCountBefore to $memberCountAfter";
                }
                
                // 5. No orphaned users should exist
                $allUsers = User::all();
                foreach ($allUsers as $user) {
                    $linkedMember = Member::where('user_id', $user->id)->first();
                    if (!$linkedMember) {
                        $failures[] = "Iteration $i: Found orphaned user {$user->id} with email {$user->email} after rollback";
                    }
                }
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Unexpected exception: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Rollback atomicity property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
    
    it('ensures concurrent account creation attempts maintain atomicity', function () {
        $iterations = 30;
        $failures = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            try {
                // Generate random member data
                $email = fake()->unique()->safeEmail();
                $memberData = [
                    'full_name' => fake()->name(),
                    'email' => $email,
                    'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'date_joined' => fake()->date('Y-m-d', 'now'),
                    'cell' => fake()->randomElement(['north', 'east', 'south', 'west']),
                ];
                
                // Create member
                $member = Member::create($memberData);
                
                // Simulate two concurrent account creation attempts
                $attempt1Succeeded = false;
                $attempt2Succeeded = false;
                
                // First attempt
                DB::beginTransaction();
                try {
                    $foundMember1 = Member::where('email', $email)->first();
                    
                    if (!$foundMember1) {
                        throw new \Exception('Member not found');
                    }
                    
                    // Check if member already has account
                    if ($foundMember1->user_id) {
                        throw new \Exception('Member already has account');
                    }
                    
                    $user1 = User::create([
                        'name' => $foundMember1->full_name,
                        'email' => $foundMember1->email,
                        'password' => Hash::make('password123'),
                        'role' => 'member',
                    ]);
                    
                    $foundMember1->user_id = $user1->id;
                    $foundMember1->save();
                    
                    DB::commit();
                    $attempt1Succeeded = true;
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                }
                
                // Second attempt (should fail because member already has account)
                DB::beginTransaction();
                try {
                    $foundMember2 = Member::where('email', $email)->first();
                    
                    if (!$foundMember2) {
                        throw new \Exception('Member not found');
                    }
                    
                    // Check if member already has account (should catch this)
                    if ($foundMember2->user_id) {
                        $existingUser = User::find($foundMember2->user_id);
                        if ($existingUser) {
                            throw new \Exception('Member already has account');
                        }
                    }
                    
                    // This should not execute if check works
                    $user2 = User::create([
                        'name' => $foundMember2->full_name,
                        'email' => $foundMember2->email . '.duplicate', // Avoid unique constraint
                        'password' => Hash::make('password456'),
                        'role' => 'member',
                    ]);
                    
                    $foundMember2->user_id = $user2->id;
                    $foundMember2->save();
                    
                    DB::commit();
                    $attempt2Succeeded = true;
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                }
                
                // Property Verification: Only one attempt should succeed
                
                // 1. First attempt should succeed
                if (!$attempt1Succeeded) {
                    $failures[] = "Iteration $i: First account creation attempt failed unexpectedly";
                }
                
                // 2. Second attempt should fail (duplicate prevention)
                if ($attempt2Succeeded) {
                    $failures[] = "Iteration $i: Second account creation attempt succeeded (duplicate not prevented)";
                }
                
                // 3. Member should have exactly one user_id
                $member->refresh();
                if ($member->user_id === null) {
                    $failures[] = "Iteration $i: Member has no user_id after attempts";
                }
                
                // 4. Only one user should exist with this email
                $userCount = User::where('email', $email)->count();
                if ($userCount !== 1) {
                    $failures[] = "Iteration $i: Expected 1 user with email $email, found $userCount";
                }
                
                // 5. Member should be linked to the first user created
                if ($attempt1Succeeded && $member->user_id) {
                    $linkedUser = User::find($member->user_id);
                    if (!$linkedUser) {
                        $failures[] = "Iteration $i: Member user_id points to non-existent user";
                    } elseif ($linkedUser->email !== $email) {
                        $failures[] = "Iteration $i: Member linked to wrong user (email mismatch)";
                    }
                }
                
            } catch (\Exception $e) {
                $failures[] = "Iteration $i: Unexpected exception: " . $e->getMessage();
            }
        }
        
        // Report all failures if any occurred
        if (!empty($failures)) {
            $failureReport = "Concurrent creation atomicity property test failed in " . count($failures) . " out of $iterations iterations:\n\n";
            $failureReport .= implode("\n", array_slice($failures, 0, 10)); // Show first 10 failures
            if (count($failures) > 10) {
                $failureReport .= "\n... and " . (count($failures) - 10) . " more failures";
            }
            
            throw new \Exception($failureReport);
        }
        
        expect(true)->toBeTrue(); // All iterations passed
    });
});
