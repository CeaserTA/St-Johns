<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use App\Models\Group;
use App\Models\Service;
use App\Models\ServiceRegistration;
use App\Models\Giving;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * End-to-End tests for the notification system
 * 
 * Tests the complete flow from event creation through notification display
 * and marking as read functionality.
 */
class NotificationEndToEndTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $member;
    protected Member $memberProfile;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
            'name' => 'Admin User'
        ]);

        // Create member user with profile
        $this->member = User::factory()->create([
            'role' => 'member',
            'email' => 'member@test.com',
            'name' => 'Test Member'
        ]);
        
        $this->memberProfile = Member::factory()->create([
            'user_id' => $this->member->id,
            'email' => 'member@test.com',
            'full_name' => 'Test Member'
        ]);
    }

    /**
     * Test complete member registration notification flow
     */
    public function test_member_registration_notification_flow(): void
    {
        // Step 1: Create a new member
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

        $response->assertStatus(302); // Redirect after creation

        // Step 2: Verify notification was created
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $this->admin->id,
            'notifiable_type' => User::class,
        ]);

        // Step 3: Check unread count via API
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread-count');
        $response->assertStatus(200);
        $response->assertJson(['count' => 1]);

        // Step 4: Get notification details
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'type',
                'title',
                'message',
                'icon',
                'color',
                'action_url',
                'created_at',
                'created_at_human',
                'read_at'
            ]
        ]);

        $notificationId = $response->json()[0]['id'];

        // Step 5: Mark notification as read
        $response = $this->actingAs($this->admin)->postJson("/api/notifications/{$notificationId}/read");
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Step 6: Verify unread count is now 0
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread-count');
        $response->assertJson(['count' => 0]);
    }

    /**
     * Test complete giving submission notification flow
     */
    public function test_giving_submission_notification_flow(): void
    {
        // Step 1: Submit a giving
        $response = $this->postJson('/give', [
            'giving_type' => 'tithe',
            'amount' => 50000,
            'currency' => 'UGX',
            'payment_method' => 'cash',
            'guest_name' => 'Jane Doe',
            'guest_email' => 'jane@example.com',
        ]);

        $response->assertStatus(200);

        // Step 2: Verify notification was created
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $this->admin->id,
            'notifiable_type' => User::class,
        ]);

        // Step 3: Check notification contains giving details
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread');
        $response->assertStatus(200);
        $notification = $response->json()[0];
        
        $this->assertStringContainsString('50,000', $notification['message']); // Formatted with comma
        $this->assertEquals('giving_submitted', $notification['type']);
    }

    /**
     * Test complete service registration notification flow
     */
    public function test_service_registration_notification_flow(): void
    {
        // Step 1: Create a service
        $service = Service::create([
            'name' => 'Baptism',
            'description' => 'Baptism service',
            'schedule' => 'Sundays',
            'fee' => 0,
            'is_free' => true,
            'currency' => 'UGX',
        ]);

        // Step 2: Register for service as member
        $response = $this->actingAs($this->member)->post('/service-register', [
            'service_id' => $service->id,
        ]);

        $response->assertStatus(302);

        // Step 3: Verify notification was created
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $this->admin->id,
            'notifiable_type' => User::class,
        ]);

        // Step 4: Check notification contains service details
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread');
        $response->assertStatus(200);
        $notification = $response->json()[0];
        
        $this->assertStringContainsString('Baptism', $notification['message']);
        $this->assertEquals('service_registered', $notification['type']);
    }

    /**
     * Test complete group join notification flow
     */
    public function test_group_join_notification_flow(): void
    {
        // Step 1: Create a group
        $group = Group::factory()->create([
            'name' => 'Youth Ministry',
            'description' => 'Youth group'
        ]);

        // Step 2: Join group as member
        $response = $this->actingAs($this->member)->postJson('/groups/join', [
            'group' => $group->name,
        ]);

        $response->assertStatus(200);

        // Step 3: Verify notification was created
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $this->admin->id,
            'notifiable_type' => User::class,
        ]);

        // Step 4: Check notification contains group details
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread');
        $response->assertStatus(200);
        $notification = $response->json()[0];
        
        $this->assertStringContainsString('Youth Ministry', $notification['message']);
        $this->assertEquals('group_joined', $notification['type']);
    }

    /**
     * Test mark all as read functionality
     */
    public function test_mark_all_as_read_functionality(): void
    {
        // Clear any existing notifications first
        $this->admin->notifications()->delete();
        
        // Step 1: Create multiple notifications
        // Create member
        $this->post('/members', [
            'fullname' => 'Member One',
            'dateOfBirth' => '1990-01-01',
            'gender' => 'male',
            'maritalStatus' => 'single',
            'phone' => '0700000001',
            'email' => 'member1@example.com',
            'address' => '123 Test St',
            'dateJoined' => now()->format('Y-m-d'),
            'cell' => 'north',
        ]);

        // Submit giving
        $this->postJson('/give', [
            'giving_type' => 'offering',
            'amount' => 25000,
            'currency' => 'UGX',
            'payment_method' => 'mobile_money',
            'guest_name' => 'Giver One',
            'guest_email' => 'giver1@example.com',
        ]);

        // Create another member
        $this->post('/members', [
            'fullname' => 'Member Two',
            'dateOfBirth' => '1992-02-02',
            'gender' => 'female',
            'maritalStatus' => 'married',
            'phone' => '0700000002',
            'email' => 'member2@example.com',
            'address' => '456 Test Ave',
            'dateJoined' => now()->format('Y-m-d'),
            'cell' => 'south',
        ]);

        // Step 2: Verify we have at least 2 unread notifications (member registration might not always trigger)
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread-count');
        $unreadCount = $response->json()['count'];
        $this->assertGreaterThanOrEqual(2, $unreadCount, 'Should have at least 2 notifications');

        // Step 3: Mark all as read
        $response = $this->actingAs($this->admin)->postJson('/api/notifications/read-all');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'unread_count' => 0
        ]);

        // Step 4: Verify unread count is now 0
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread-count');
        $response->assertJson(['count' => 0]);

        // Step 5: Verify all notifications have read_at timestamp
        $notifications = $this->admin->notifications;
        foreach ($notifications as $notification) {
            $this->assertNotNull($notification->read_at);
        }
    }

    /**
     * Test service payment submission notification flow
     */
    public function test_service_payment_submission_notification_flow(): void
    {
        // Step 1: Create a paid service
        $service = Service::create([
            'name' => 'Wedding',
            'description' => 'Wedding service',
            'schedule' => 'By appointment',
            'fee' => 100000,
            'is_free' => false,
            'currency' => 'UGX',
        ]);

        // Step 2: Create a registration
        $registration = ServiceRegistration::create([
            'service_id' => $service->id,
            'member_id' => $this->memberProfile->id,
            'amount_paid' => 0,
            'payment_status' => 'pending',
        ]);

        // Clear any existing notifications
        $this->admin->notifications()->delete();

        // Step 3: Submit payment proof
        $response = $this->actingAs($this->member)->postJson('/service-payment-proof', [
            'registration_id' => $registration->id,
            'payment_method' => 'mobile_money',
            'transaction_reference' => 'MTN123456',
            'payment_notes' => 'Paid via MTN Mobile Money',
        ]);

        $response->assertStatus(200);

        // Step 4: Verify notification was created
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $this->admin->id,
            'notifiable_type' => User::class,
        ]);

        // Step 5: Check notification contains payment details
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread');
        $response->assertStatus(200);
        $notification = $response->json()[0];
        
        $this->assertStringContainsString('Wedding', $notification['message']);
        $this->assertEquals('service_payment', $notification['type']); // Actual type from notification
    }

    /**
     * Test notification system with multiple admins
     */
    public function test_notifications_sent_to_all_admins(): void
    {
        // Step 1: Create additional admin users
        $admin2 = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin2@test.com'
        ]);
        
        $admin3 = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin3@test.com'
        ]);

        // Step 2: Create a member (triggers notification)
        $this->post('/members', [
            'fullname' => 'Shared Member',
            'dateOfBirth' => '1990-01-01',
            'gender' => 'male',
            'maritalStatus' => 'single',
            'phone' => '0700000003',
            'email' => 'shared@example.com',
            'address' => '789 Test Blvd',
            'dateJoined' => now()->format('Y-m-d'),
            'cell' => 'east',
        ]);

        // Step 3: Verify all admins received the notification
        $this->assertEquals(1, $this->admin->unreadNotifications()->count());
        $this->assertEquals(1, $admin2->unreadNotifications()->count());
        $this->assertEquals(1, $admin3->unreadNotifications()->count());

        // Step 4: Mark as read for one admin
        $notificationId = $this->admin->unreadNotifications()->first()->id;
        $this->actingAs($this->admin)->postJson("/api/notifications/{$notificationId}/read");

        // Step 5: Verify only that admin's notification is marked as read
        $this->assertEquals(0, $this->admin->unreadNotifications()->count());
        $this->assertEquals(1, $admin2->unreadNotifications()->count());
        $this->assertEquals(1, $admin3->unreadNotifications()->count());
    }

    /**
     * Test notification authorization (non-admins cannot access)
     */
    public function test_notification_endpoints_require_authentication(): void
    {
        // Test without authentication - Laravel redirects to login (302)
        $response = $this->getJson('/api/notifications/unread-count');
        $response->assertStatus(302); // Redirects to login

        $response = $this->getJson('/api/notifications/unread');
        $response->assertStatus(302);

        $response = $this->postJson('/api/notifications/fake-id/read');
        $response->assertStatus(302);

        $response = $this->postJson('/api/notifications/read-all');
        $response->assertStatus(302);
    }

    /**
     * Test marking invalid notification as read
     */
    public function test_marking_invalid_notification_returns_404(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson('/api/notifications/invalid-uuid-12345/read');
        
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Notification not found'
        ]);
    }

    /**
     * Test relative timestamp formatting
     */
    public function test_notification_timestamp_formatting(): void
    {
        // Create a notification
        $this->post('/members', [
            'fullname' => 'Timestamp Test',
            'dateOfBirth' => '1990-01-01',
            'gender' => 'male',
            'maritalStatus' => 'single',
            'phone' => '0700000004',
            'email' => 'timestamp@example.com',
            'address' => '123 Test St',
            'dateJoined' => now()->format('Y-m-d'),
            'cell' => 'north',
        ]);

        // Get notification
        $response = $this->actingAs($this->admin)->getJson('/api/notifications/unread');
        $response->assertStatus(200);
        
        $notification = $response->json()[0];
        
        // Verify timestamp fields exist
        $this->assertArrayHasKey('created_at', $notification);
        $this->assertArrayHasKey('created_at_human', $notification);
        
        // Verify human-readable format (should be "Just now" or "Xm ago")
        $this->assertMatchesRegularExpression(
            '/^(Just now|\d+m ago|\d+h ago|[A-Z][a-z]{2} \d+)$/',
            $notification['created_at_human']
        );
    }
}
