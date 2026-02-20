<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use App\Models\Group;
use App\Models\Service;
use App\Models\ServiceRegistration;
use App\Models\Giving;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Notifications\NewMemberRegistered;
use App\Notifications\NewAccountCreated;
use App\Notifications\NewGivingSubmitted;
use App\Notifications\ServiceRegistrationCreated;
use App\Notifications\ServicePaymentSubmitted;
use App\Notifications\MemberJoinedGroup;

class NotificationIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin users to receive notifications
        User::factory()->create(['role' => 'admin', 'email' => 'admin1@test.com']);
        User::factory()->create(['role' => 'admin', 'email' => 'admin2@test.com']);
    }

    /**
     * Test that member registration sends notification to admins
     */
    public function test_member_registration_sends_notification(): void
    {
        Notification::fake();

        // Create a member via the controller
        $response = $this->post('/members', [
            'fullname' => 'John Doe',
            'dateOfBirth' => '1990-01-01',
            'gender' => 'male',
            'maritalStatus' => 'single',
            'phone' => '0700000000',
            'email' => 'john@example.com',
            'address' => '123 Test St',
            'dateJoined' => now()->format('Y-m-d'),
            'cell' => 'north',
        ]);

        // Verify notification was sent to all admins
        Notification::assertSentTo(
            User::where('role', 'admin')->get(),
            NewMemberRegistered::class
        );
    }

    /**
     * Test that account creation sends notification to admins
     */
    public function test_account_creation_sends_notification(): void
    {
        Notification::fake();

        // Create a member first
        $member = Member::factory()->create([
            'email' => 'test@example.com',
            'user_id' => null,
        ]);

        // Create account via registration
        $response = $this->post('/register', [
            'name' => $member->full_name,
            'email' => $member->email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Verify notification was sent to all admins
        Notification::assertSentTo(
            User::where('role', 'admin')->get(),
            NewAccountCreated::class
        );
    }

    /**
     * Test that giving submission sends notification to admins
     */
    public function test_giving_submission_sends_notification(): void
    {
        Notification::fake();

        // Submit giving as guest
        $response = $this->postJson('/give', [
            'giving_type' => 'tithe',
            'amount' => 50000,
            'currency' => 'UGX',
            'payment_method' => 'cash',
            'guest_name' => 'Jane Doe',
            'guest_email' => 'jane@example.com',
        ]);

        $response->assertStatus(200);

        // Verify notification was sent to all admins
        Notification::assertSentTo(
            User::where('role', 'admin')->get(),
            NewGivingSubmitted::class
        );
    }

    /**
     * Test that service registration sends notification to admins
     */
    public function test_service_registration_sends_notification(): void
    {
        Notification::fake();

        // Create a member with user account
        $user = User::factory()->create(['role' => 'member']);
        $member = Member::factory()->create(['user_id' => $user->id]);

        // Create a service
        $service = Service::create([
            'name' => 'Baptism',
            'description' => 'Baptism service',
            'schedule' => 'Sundays',
            'fee' => 0,
            'is_free' => true,
            'currency' => 'UGX',
        ]);

        // Register for service
        $response = $this->actingAs($user)->post('/service-register', [
            'service_id' => $service->id,
        ]);

        // Verify notification was sent to all admins
        Notification::assertSentTo(
            User::where('role', 'admin')->get(),
            ServiceRegistrationCreated::class
        );
    }

    /**
     * Test that service payment submission sends notification to admins
     */
    public function test_service_payment_submission_sends_notification(): void
    {
        Notification::fake();

        // Create a member with user account
        $user = User::factory()->create(['role' => 'member']);
        $member = Member::factory()->create(['user_id' => $user->id]);

        // Create a paid service
        $service = Service::create([
            'name' => 'Wedding',
            'description' => 'Wedding service',
            'schedule' => 'By appointment',
            'fee' => 100000,
            'is_free' => false,
            'currency' => 'UGX',
        ]);

        // Create a registration
        $registration = ServiceRegistration::create([
            'service_id' => $service->id,
            'member_id' => $member->id,
            'amount_paid' => 0,
            'payment_status' => 'pending',
        ]);

        // Submit payment proof
        $response = $this->actingAs($user)->postJson('/service-payment-proof', [
            'registration_id' => $registration->id,
            'payment_method' => 'mobile_money',
            'transaction_reference' => 'MTN123456',
            'payment_notes' => 'Paid via MTN Mobile Money',
        ]);

        $response->assertStatus(200);

        // Verify notification was sent to all admins
        Notification::assertSentTo(
            User::where('role', 'admin')->get(),
            ServicePaymentSubmitted::class
        );
    }

    /**
     * Test that group join sends notification to admins
     */
    public function test_group_join_sends_notification(): void
    {
        Notification::fake();

        // Create a member with user account
        $user = User::factory()->create(['role' => 'member']);
        $member = Member::factory()->create(['user_id' => $user->id]);

        // Create a group
        $group = Group::factory()->create(['name' => 'Youth Ministry']);

        // Join group
        $response = $this->actingAs($user)->postJson('/groups/join', [
            'group' => $group->name,
        ]);

        $response->assertStatus(200);

        // Verify notification was sent to all admins
        Notification::assertSentTo(
            User::where('role', 'admin')->get(),
            MemberJoinedGroup::class
        );
    }
}
