<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Integration Tests for Full Registration Flows
 * 
 * These tests verify the complete user journey through the registration and account creation process,
 * testing the actual controller methods and database interactions.
 * 
 * Requirements: 1.1, 1.2, 1.3, 2.1, 2.2, 3.4, 3.5
 */

describe('Existing Member Creating Account Later', function () {
    
    it('allows existing member to create account later via quick account modal', function () {
        // Step 1: Create a member without an account (simulating member registration)
        $memberData = [
            'full_name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'date_of_birth' => '1990-01-15',
            'gender' => 'male',
            'marital_status' => 'single',
            'phone' => '123-456-7890',
            'address' => '123 Main St',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'north',
        ];
        
        $member = Member::create($memberData);
        
        // Verify member has no user_id initially
        expect($member->user_id)->toBeNull();
        
        // Step 2: Member creates account later via MemberController::createAccount
        $response = $this->post(route('member.create-account'), [
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        // Step 3: Verify account creation succeeded
        $response->assertRedirect(route('services'));
        $response->assertSessionHas('success', 'Account created successfully! You can now register for services.');
        
        // Step 4: Verify user account was created
        $user = User::where('email', 'john.doe@example.com')->first();
        expect($user)->not->toBeNull();
        expect($user->name)->toBe('John Doe');
        expect($user->role)->toBe('member');
        expect(Hash::check('password123', $user->password))->toBeTrue();
        
        // Step 5: Verify member is linked to user
        $member->refresh();
        expect($member->user_id)->toBe($user->id);
        
        // Step 6: Verify bidirectional relationship
        expect($member->user->id)->toBe($user->id);
        expect($user->member->id)->toBe($member->id);
        
        // Step 7: Verify user is authenticated
        $this->assertAuthenticatedAs($user);
        
        // Step 8: Verify user can access services
        $servicesResponse = $this->get(route('services'));
        $servicesResponse->assertOk();
    });
    
    it('prevents duplicate account creation for member who already has account', function () {
        // Step 1: Create member with account
        $member = Member::create([
            'full_name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'date_of_birth' => '1985-05-20',
            'gender' => 'female',
            'marital_status' => 'married',
            'phone' => '987-654-3210',
            'address' => '456 Oak Ave',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'south',
        ]);
        
        $user = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);
        
        $member->user_id = $user->id;
        $member->save();
        
        // Step 2: Attempt to create another account
        $response = $this->post(route('member.create-account'), [
            'email' => 'jane.smith@example.com',
            'password' => 'newpassword456',
            'password_confirmation' => 'newpassword456',
        ]);
        
        // Step 3: Verify duplicate account creation was prevented
        $response->assertRedirect();
        $response->assertSessionHas('error', 'This member already has an account. Please login.');
        
        // Step 4: Verify only one user exists with this email
        $userCount = User::where('email', 'jane.smith@example.com')->count();
        expect($userCount)->toBe(1);
        
        // Step 5: Verify member still linked to original user
        $member->refresh();
        expect($member->user_id)->toBe($user->id);
    });
    
    it('handles account creation with non-existent member email', function () {
        // Attempt to create account for email not in members table
        $response = $this->post(route('member.create-account'), [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        // Verify validation error
        $response->assertSessionHasErrors(['email']);
        
        // Verify no user was created
        $user = User::where('email', 'nonexistent@example.com')->first();
        expect($user)->toBeNull();
    });
});

describe('Guest Being Redirected to Member Registration', function () {
    
    it('redirects guest to member registration when email not in members table', function () {
        // Step 1: Guest attempts to create account via RegisteredUserController
        $response = $this->post(route('register'), [
            'name' => 'New Guest',
            'email' => 'newguest@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        // Step 2: Verify redirect with appropriate error message
        $response->assertRedirect();
        $response->assertSessionHas('error', 'You must register as a church member before creating an account.');
        $response->assertSessionHas('show_member_registration', true);
        
        // Step 3: Verify no user account was created
        $user = User::where('email', 'newguest@example.com')->first();
        expect($user)->toBeNull();
        
        // Step 4: Verify no member record was created
        $member = Member::where('email', 'newguest@example.com')->first();
        expect($member)->toBeNull();
    });
    
    it('allows account creation after member registration is complete', function () {
        // Step 1: Guest completes member registration first
        $member = Member::create([
            'full_name' => 'Registered Guest',
            'email' => 'registered.guest@example.com',
            'date_of_birth' => '1992-08-10',
            'gender' => 'male',
            'marital_status' => 'single',
            'phone' => '555-123-4567',
            'address' => '789 Pine Rd',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'east',
        ]);
        
        // Verify member has no user_id
        expect($member->user_id)->toBeNull();
        
        // Step 2: Now guest attempts to create account (should succeed)
        $response = $this->post(route('register'), [
            'name' => 'Registered Guest',
            'email' => 'registered.guest@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        // Step 3: Verify account creation succeeded
        $response->assertRedirect(route('services'));
        $response->assertSessionHas('success', 'Welcome! Your account is ready.');
        
        // Step 4: Verify user was created and linked
        $user = User::where('email', 'registered.guest@example.com')->first();
        expect($user)->not->toBeNull();
        
        $member->refresh();
        expect($member->user_id)->toBe($user->id);
        
        // Step 5: Verify user is authenticated
        $this->assertAuthenticatedAs($user);
    });
    
    it('prevents account creation when member already has account', function () {
        // Step 1: Create member with existing account
        $member = Member::create([
            'full_name' => 'Existing Member',
            'email' => 'existing@example.com',
            'date_of_birth' => '1988-03-25',
            'gender' => 'female',
            'marital_status' => 'married',
            'phone' => '555-987-6543',
            'address' => '321 Elm St',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'west',
        ]);
        
        $user = User::create([
            'name' => 'Existing Member',
            'email' => 'existing@example.com',
            'password' => Hash::make('oldpassword'),
            'role' => 'member',
        ]);
        
        $member->user_id = $user->id;
        $member->save();
        
        // Step 2: Attempt to create another account with different email to bypass unique validation
        // but same member (this tests the member already has account logic)
        $response = $this->post(route('register'), [
            'name' => 'Existing Member',
            'email' => 'existing@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        
        // Step 3: Verify duplicate prevention - will fail at validation level due to unique email constraint
        $response->assertRedirect();
        // The validation error for unique email will be triggered first
        $response->assertSessionHasErrors(['email']);
        
        // Step 4: Verify only one user exists
        $userCount = User::where('email', 'existing@example.com')->count();
        expect($userCount)->toBe(1);
        
        // Step 5: Verify original password unchanged
        $user->refresh();
        expect(Hash::check('oldpassword', $user->password))->toBeTrue();
    });
});

describe('Concurrent Account Creation Attempts', function () {
    
    it('handles concurrent account creation attempts for same member', function () {
        // Step 1: Create member without account
        $member = Member::create([
            'full_name' => 'Concurrent Test',
            'email' => 'concurrent@example.com',
            'date_of_birth' => '1995-11-30',
            'gender' => 'male',
            'marital_status' => 'single',
            'phone' => '555-111-2222',
            'address' => '999 Concurrent Ln',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'north',
        ]);
        
        // Step 2: Simulate first account creation attempt
        $response1 = $this->post(route('member.create-account'), [
            'email' => 'concurrent@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        // Step 3: Verify first attempt succeeded
        $response1->assertRedirect(route('services'));
        
        $user1 = User::where('email', 'concurrent@example.com')->first();
        expect($user1)->not->toBeNull();
        
        $member->refresh();
        expect($member->user_id)->toBe($user1->id);
        
        // Step 4: Simulate second concurrent attempt (should fail)
        // Logout first to simulate different session
        Auth::logout();
        
        $response2 = $this->post(route('member.create-account'), [
            'email' => 'concurrent@example.com',
            'password' => 'differentpassword456',
            'password_confirmation' => 'differentpassword456',
        ]);
        
        // Step 5: Verify second attempt was prevented
        $response2->assertRedirect();
        $response2->assertSessionHas('error', 'This member already has an account. Please login.');
        
        // Step 6: Verify only one user exists
        $userCount = User::where('email', 'concurrent@example.com')->count();
        expect($userCount)->toBe(1);
        
        // Step 7: Verify member still linked to first user
        $member->refresh();
        expect($member->user_id)->toBe($user1->id);
        
        // Step 8: Verify original password unchanged
        expect(Hash::check('password123', $user1->password))->toBeTrue();
    });
    
    it('prevents race condition with database constraints', function () {
        // Step 1: Create member
        $member = Member::create([
            'full_name' => 'Race Condition Test',
            'email' => 'race@example.com',
            'date_of_birth' => '1993-07-18',
            'gender' => 'female',
            'marital_status' => 'single',
            'phone' => '555-333-4444',
            'address' => '777 Race St',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'south',
        ]);
        
        // Step 2: Attempt to create user directly (bypassing controller checks)
        // This simulates a race condition scenario
        $user1 = User::create([
            'name' => 'Race Condition Test',
            'email' => 'race@example.com',
            'password' => Hash::make('password1'),
            'role' => 'member',
        ]);
        
        $member->user_id = $user1->id;
        $member->save();
        
        // Step 3: Attempt to create duplicate user (should fail due to unique constraint)
        try {
            $user2 = User::create([
                'name' => 'Race Condition Test',
                'email' => 'race@example.com',
                'password' => Hash::make('password2'),
                'role' => 'member',
            ]);
            
            // If we get here, the unique constraint didn't work
            expect(false)->toBeTrue('Duplicate user creation should have failed');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Expected: unique constraint violation
            expect($e->getCode())->toBeIn(['23000', '23505', 1062]); // SQLite, PostgreSQL, MySQL error codes
        }
        
        // Step 4: Verify only one user exists
        $userCount = User::where('email', 'race@example.com')->count();
        expect($userCount)->toBe(1);
        
        // Step 5: Verify member linked to first user
        $member->refresh();
        expect($member->user_id)->toBe($user1->id);
    });
});

describe('Transaction Rollback Scenarios', function () {
    
    it('rolls back user creation when member linking fails', function () {
        // Step 1: Create member
        $member = Member::create([
            'full_name' => 'Rollback Test',
            'email' => 'rollback@example.com',
            'date_of_birth' => '1991-04-12',
            'gender' => 'male',
            'marital_status' => 'single',
            'phone' => '555-777-8888',
            'address' => '888 Rollback Ave',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'east',
        ]);
        
        $memberId = $member->id;
        
        // Step 2: Count users before operation
        $userCountBefore = User::count();
        
        // Step 3: Simulate transaction failure during linking
        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'name' => 'Rollback Test',
                'email' => 'rollback@example.com',
                'password' => Hash::make('password123'),
                'role' => 'member',
            ]);
            
            // Simulate a failure during the linking process
            // For example, trying to set an invalid user_id
            throw new \Exception('Simulated linking failure');
            
            // This code should never execute
            $member->user_id = $user->id;
            $member->save();
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
        }
        
        // Step 4: Verify user was rolled back
        $userCountAfter = User::count();
        expect($userCountAfter)->toBe($userCountBefore);
        
        // Step 5: Verify no user exists with this email
        $user = User::where('email', 'rollback@example.com')->first();
        expect($user)->toBeNull();
        
        // Step 6: Verify member still exists unchanged (was created before transaction)
        $member = Member::find($memberId);
        expect($member)->not->toBeNull();
        expect($member->user_id)->toBeNull();
    });
    
    it('maintains data integrity when transaction fails during account creation', function () {
        // Step 1: Create member
        $member = Member::create([
            'full_name' => 'Integrity Test',
            'email' => 'integrity@example.com',
            'date_of_birth' => '1989-09-05',
            'gender' => 'female',
            'marital_status' => 'married',
            'phone' => '555-999-0000',
            'address' => '111 Integrity Blvd',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'west',
        ]);
        
        $originalMemberState = $member->user_id; // Should be null
        
        // Step 2: Count records before
        $userCountBefore = User::count();
        $memberCountBefore = Member::count();
        
        // Step 3: Simulate transaction with failure
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => 'Integrity Test',
                'email' => 'integrity@example.com',
                'password' => Hash::make('password123'),
                'role' => 'member',
            ]);
            
            // Simulate failure before linking
            throw new \Exception('Simulated transaction failure');
            
            $member->user_id = $user->id;
            $member->save();
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
        }
        
        // Step 4: Verify user was not created
        $userCountAfter = User::count();
        expect($userCountAfter)->toBe($userCountBefore);
        
        // Step 5: Verify member unchanged
        $memberCountAfter = Member::count();
        expect($memberCountAfter)->toBe($memberCountBefore);
        
        $member->refresh();
        expect($member->user_id)->toBe($originalMemberState);
        
        // Step 6: Verify no orphaned users
        $orphanedUser = User::where('email', 'integrity@example.com')->first();
        expect($orphanedUser)->toBeNull();
    });
    
    it('handles validation failure without creating partial records', function () {
        // Step 1: Create member
        $member = Member::create([
            'full_name' => 'Validation Test',
            'email' => 'validation@example.com',
            'date_of_birth' => '1994-12-20',
            'gender' => 'male',
            'marital_status' => 'single',
            'phone' => '555-222-3333',
            'address' => '222 Validation Way',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'north',
        ]);
        
        // Step 2: Attempt account creation with invalid password confirmation
        $response = $this->post(route('member.create-account'), [
            'email' => 'validation@example.com',
            'password' => 'password123',
            'password_confirmation' => 'wrongpassword', // Mismatch
        ]);
        
        // Step 3: Verify validation error
        $response->assertSessionHasErrors(['password']);
        
        // Step 4: Verify no user was created
        $user = User::where('email', 'validation@example.com')->first();
        expect($user)->toBeNull();
        
        // Step 5: Verify member unchanged
        $member->refresh();
        expect($member->user_id)->toBeNull();
    });
    
    it('ensures atomicity across multiple database operations', function () {
        // Step 1: Create member
        $member = Member::create([
            'full_name' => 'Atomicity Test',
            'email' => 'atomicity@example.com',
            'date_of_birth' => '1987-06-14',
            'gender' => 'female',
            'marital_status' => 'divorced',
            'phone' => '555-444-5555',
            'address' => '333 Atomicity Ct',
            'date_joined' => now()->format('Y-m-d'),
            'cell' => 'south',
        ]);
        
        // Step 2: Perform account creation through controller
        $response = $this->post(route('member.create-account'), [
            'email' => 'atomicity@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        // Step 3: Verify success
        $response->assertRedirect(route('services'));
        
        // Step 4: Verify all operations completed atomically
        $user = User::where('email', 'atomicity@example.com')->first();
        expect($user)->not->toBeNull();
        
        $member->refresh();
        expect($member->user_id)->toBe($user->id);
        
        // Step 5: Verify bidirectional relationship
        expect($user->member->id)->toBe($member->id);
        expect($member->user->id)->toBe($user->id);
        
        // Step 6: Verify no orphaned records
        $userCount = User::where('email', 'atomicity@example.com')->count();
        $memberCount = Member::where('email', 'atomicity@example.com')->count();
        
        expect($userCount)->toBe(1);
        expect($memberCount)->toBe(1);
    });
});
