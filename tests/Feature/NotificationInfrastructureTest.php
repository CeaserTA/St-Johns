<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Notification;
use Tests\TestCase;

class NotificationInfrastructureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that notification routes are accessible to admin users
     */
    public function test_notification_routes_require_admin_authentication(): void
    {
        // Test unread count endpoint
        $response = $this->get('/api/notifications/unread-count');
        $response->assertRedirect(); // Should redirect to login

        // Test unread notifications endpoint
        $response = $this->get('/api/notifications/unread');
        $response->assertRedirect();

        // Test mark as read endpoint
        $response = $this->post('/api/notifications/test-id/read');
        $response->assertRedirect();

        // Test mark all as read endpoint
        $response = $this->post('/api/notifications/read-all');
        $response->assertRedirect();
    }

    /**
     * Test that admin users can access notification endpoints
     */
    public function test_admin_can_access_notification_endpoints(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        // Test unread count endpoint
        $response = $this->get('/api/notifications/unread-count');
        $response->assertStatus(200);
        $response->assertJson(['count' => 0]);

        // Test unread notifications endpoint
        $response = $this->get('/api/notifications/unread');
        $response->assertStatus(200);
        $response->assertJsonStructure([]);
    }

    /**
     * Test that NotificationService can find admin users
     */
    public function test_notification_service_finds_admin_users(): void
    {
        // Create some users with different roles
        User::factory()->create(['role' => 'admin']);
        User::factory()->create(['role' => 'admin']);
        User::factory()->create(['role' => 'member']);

        $service = new NotificationService();
        
        // Use reflection to access private method for testing
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('getAdminUsers');
        $method->setAccessible(true);
        
        $admins = $method->invoke($service);
        
        $this->assertCount(2, $admins);
    }

    /**
     * Test that notifications table uses Laravel's standard structure
     */
    public function test_notifications_table_has_correct_structure(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Create a test notification using Laravel's notification system
        $admin->notify(new TestNotification());

        // Verify the notification was stored
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $admin->id,
            'notifiable_type' => User::class,
        ]);

        // Verify the notification has the correct structure
        $notification = $admin->notifications()->first();
        $this->assertNotNull($notification);
        $this->assertIsString($notification->id); // UUID
        $this->assertIsArray($notification->data);
        $this->assertNull($notification->read_at);
    }
}

/**
 * Test notification class for infrastructure testing
 */
class TestNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'test',
            'title' => 'Test Notification',
            'message' => 'This is a test notification',
            'icon' => 'test',
            'color' => 'blue',
            'action_url' => '/test',
        ];
    }
}
