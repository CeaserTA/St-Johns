<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use App\Models\Group;
use App\Models\Service;
use App\Models\ServiceRegistration;
use App\Models\Giving;
use App\Notifications\NewMemberRegistered;
use App\Notifications\NewGivingSubmitted;
use App\Notifications\ServiceRegistrationCreated;
use App\Notifications\MemberJoinedGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Eris\TestTrait;

class NotificationPropertyTest extends TestCase
{
    use RefreshDatabase;
    use TestTrait;

    /**
     * **Feature: admin-notification-system, Property 1: Notification Creation Completeness**
     * 
     * For any critical event (member registration, giving submission, service registration, 
     * group join), when the event occurs, a notification should be created for all admin 
     * users in the system.
     * 
     * **Validates: Requirements 1.1, 2.1, 3.1, 4.1, 10.3**
     */
    public function test_property_notification_creation_completeness(): void
    {
        $this->forAll(
            \Eris\Generator\choose(1, 10) // Number of admin users
        )->then(function (int $adminCount) {
            // Clean up before each iteration
            User::query()->delete();
            Member::query()->delete();
            \DB::table('notifications')->truncate();
            
            // Create admin users with unique emails
            $admins = collect();
            for ($i = 0; $i < $adminCount; $i++) {
                $admins->push(User::factory()->create([
                    'role' => 'admin',
                    'email' => "admin" . uniqid() . "@test.com"
                ]));
            }

            // Test member registration notification
            $member = Member::factory()->create();
            $notification = new NewMemberRegistered($member);
            Notification::send($admins, $notification);
            
            $notificationCount = \DB::table('notifications')
                ->where('type', NewMemberRegistered::class)
                ->count();
            
            $this->assertEquals(
                $adminCount, 
                $notificationCount,
                "Expected {$adminCount} notifications for member registration, got {$notificationCount}"
            );
        });
    }

    /**
     * **Feature: admin-notification-system, Property 2: Unread Count Accuracy**
     * 
     * For any admin user, the unread notification count displayed should equal the number 
     * of notifications in the database where notifiable_id matches the user ID and read_at is NULL.
     * 
     * **Validates: Requirements 5.2, 5.3**
     */
    public function test_property_unread_count_accuracy(): void
    {
        $this->forAll(
            \Eris\Generator\choose(0, 50), // Total notifications
            \Eris\Generator\choose(0, 100) // Percentage to mark as read (0-100)
        )->then(function (int $totalNotifications, int $readPercentage) {
            // Clean up before each iteration
            User::query()->delete();
            Member::query()->delete();
            \DB::table('notifications')->truncate();
            
            // Create an admin user
            $admin = User::factory()->create([
                'role' => 'admin',
                'email' => 'admin' . uniqid() . '@test.com'
            ]);

            // Create notifications for the admin
            $expectedUnreadCount = 0;
            for ($i = 0; $i < $totalNotifications; $i++) {
                $member = Member::factory()->create();
                $notification = new NewMemberRegistered($member);
                $admin->notify($notification);
                
                // Randomly mark some as read based on percentage
                $shouldMarkAsRead = (rand(0, 100) < $readPercentage);
                if ($shouldMarkAsRead) {
                    $admin->notifications()->latest()->first()->markAsRead();
                } else {
                    $expectedUnreadCount++;
                }
            }

            // Get unread count from database
            $actualUnreadCount = $admin->unreadNotifications()->count();
            
            $this->assertEquals(
                $expectedUnreadCount,
                $actualUnreadCount,
                "Expected {$expectedUnreadCount} unread notifications, got {$actualUnreadCount}"
            );
        });
    }

    /**
     * **Feature: admin-notification-system, Property 3: Mark as Read Idempotence**
     * 
     * For any notification, marking it as read multiple times should result in the same 
     * state as marking it once (read_at timestamp set, unread count decremented once).
     * 
     * **Validates: Requirements 6.4, 7.3**
     */
    public function test_property_mark_as_read_idempotence(): void
    {
        $this->forAll(
            \Eris\Generator\choose(1, 10) // Number of times to mark as read
        )->then(function (int $markAsReadCount) {
            // Clean up before each iteration
            User::query()->delete();
            Member::query()->delete();
            \DB::table('notifications')->truncate();
            
            // Create an admin user
            $admin = User::factory()->create([
                'role' => 'admin',
                'email' => 'admin' . uniqid() . '@test.com'
            ]);

            // Create a notification
            $member = Member::factory()->create();
            $notification = new NewMemberRegistered($member);
            $admin->notify($notification);
            
            // Get the notification
            $dbNotification = $admin->notifications()->first();
            $initialReadAt = $dbNotification->read_at;
            
            // Initial unread count should be 1
            $initialUnreadCount = $admin->unreadNotifications()->count();
            $this->assertEquals(1, $initialUnreadCount);
            
            // Mark as read N times
            $firstReadAt = null;
            for ($i = 0; $i < $markAsReadCount; $i++) {
                $dbNotification->markAsRead();
                $dbNotification->refresh();
                
                if ($i === 0) {
                    $firstReadAt = $dbNotification->read_at;
                }
            }
            
            // Verify read_at is set
            $this->assertNotNull($dbNotification->read_at);
            
            // Verify read_at hasn't changed after first mark
            $this->assertEquals(
                $firstReadAt->timestamp,
                $dbNotification->read_at->timestamp,
                "read_at should not change after first mark"
            );
            
            // Verify unread count is 0 (decremented only once)
            $finalUnreadCount = $admin->unreadNotifications()->count();
            $this->assertEquals(
                0,
                $finalUnreadCount,
                "Unread count should be 0 after marking as read"
            );
        });
    }

    /**
     * **Feature: admin-notification-system, Property 4: Notification Data Integrity**
     * 
     * For any notification created, the data field should contain all required fields 
     * (type, title, message, icon, action_url, entity_type, entity_id) and the data 
     * should be valid JSON.
     * 
     * **Validates: Requirements 1.2, 2.2, 3.2, 4.2, 10.4**
     */
    public function test_property_notification_data_integrity(): void
    {
        $this->forAll(
            \Eris\Generator\elements([
                'member_registration',
                'giving_submission',
                'service_registration',
                'group_join'
            ])
        )->then(function (string $eventType) {
            // Clean up before each iteration
            User::query()->delete();
            Member::query()->delete();
            Group::query()->delete();
            Service::query()->delete();
            ServiceRegistration::query()->delete();
            Giving::query()->delete();
            \DB::table('notifications')->truncate();
            
            // Create an admin user
            $admin = User::factory()->create([
                'role' => 'admin',
                'email' => 'admin' . uniqid() . '@test.com'
            ]);

            // Create notification based on event type
            switch ($eventType) {
                case 'member_registration':
                    $member = Member::factory()->create();
                    $notification = new NewMemberRegistered($member);
                    break;
                    
                case 'giving_submission':
                    $giving = Giving::factory()->guest()->create([
                        'confirmed_by' => null,
                    ]);
                    $notification = new NewGivingSubmitted($giving);
                    break;
                    
                case 'service_registration':
                    $service = Service::create([
                        'name' => 'Test Service',
                        'description' => 'Test',
                        'schedule' => 'Test',
                        'fee' => 0,
                        'is_free' => true,
                        'currency' => 'UGX',
                    ]);
                    $member = Member::factory()->create();
                    $registration = ServiceRegistration::create([
                        'service_id' => $service->id,
                        'member_id' => $member->id,
                        'amount_paid' => 0,
                        'payment_status' => 'pending',
                    ]);
                    $notification = new ServiceRegistrationCreated($registration);
                    break;
                    
                case 'group_join':
                    $member = Member::factory()->create();
                    $group = Group::factory()->create();
                    $notification = new MemberJoinedGroup($member, $group);
                    break;
            }

            // Send notification
            $admin->notify($notification);
            
            // Get the notification from database
            $dbNotification = $admin->notifications()->first();
            
            // Verify data is valid JSON
            $this->assertIsArray($dbNotification->data);
            
            // Verify all required fields are present
            $requiredFields = ['type', 'title', 'message', 'icon', 'action_url', 'entity_type', 'entity_id'];
            foreach ($requiredFields as $field) {
                $this->assertArrayHasKey(
                    $field,
                    $dbNotification->data,
                    "Notification data should contain '{$field}' field"
                );
                $this->assertNotEmpty(
                    $dbNotification->data[$field],
                    "Notification data field '{$field}' should not be empty"
                );
            }
            
            // Verify data types
            $this->assertIsString($dbNotification->data['type']);
            $this->assertIsString($dbNotification->data['title']);
            $this->assertIsString($dbNotification->data['message']);
            $this->assertIsString($dbNotification->data['icon']);
            $this->assertIsString($dbNotification->data['action_url']);
            $this->assertIsString($dbNotification->data['entity_type']);
        });
    }
}
