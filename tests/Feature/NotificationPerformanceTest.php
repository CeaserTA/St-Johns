<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use App\Notifications\NewMemberRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Performance tests for the notification system
 * 
 * Tests polling performance with multiple admins and verifies
 * database query efficiency.
 */
class NotificationPerformanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test polling performance with multiple admins
     * 
     * Simulates multiple admins polling for notifications simultaneously
     * and verifies that the system can handle the load efficiently.
     */
    public function test_polling_performance_with_multiple_admins(): void
    {
        // Create 10 admin users
        $admins = collect();
        for ($i = 0; $i < 10; $i++) {
            $admins->push(User::factory()->create([
                'role' => 'admin',
                'email' => "admin{$i}@test.com"
            ]));
        }

        // Create 50 notifications for each admin
        foreach ($admins as $admin) {
            for ($j = 0; $j < 50; $j++) {
                $member = Member::factory()->create();
                $admin->notify(new NewMemberRegistered($member));
            }
        }

        // Measure query count and time for polling
        DB::enableQueryLog();
        $startTime = microtime(true);

        // Simulate all admins polling simultaneously
        foreach ($admins as $admin) {
            // Get unread count (what happens every 30 seconds)
            $this->actingAs($admin)->getJson('/api/notifications/unread-count');
        }

        $endTime = microtime(true);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();

        $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
        $queryCount = count($queries);

        // Performance assertions
        // Each admin should execute minimal queries (ideally 1-2 per request)
        $this->assertLessThanOrEqual(30, $queryCount, 
            "Query count should be minimal for 10 admins polling. Got {$queryCount} queries.");
        
        // Total execution time should be reasonable (< 1 second for 10 admins)
        $this->assertLessThan(1000, $executionTime,
            "Polling 10 admins should complete in under 1 second. Took {$executionTime}ms.");

        // Log performance metrics for reference
        echo "\n";
        echo "Performance Metrics:\n";
        echo "- Admins: 10\n";
        echo "- Notifications per admin: 50\n";
        echo "- Total queries: {$queryCount}\n";
        echo "- Execution time: " . number_format($executionTime, 2) . "ms\n";
        echo "- Avg time per admin: " . number_format($executionTime / 10, 2) . "ms\n";
    }

    /**
     * Test notification list query performance
     * 
     * Verifies that fetching the notification list is efficient
     * even with many notifications.
     */
    public function test_notification_list_query_performance(): void
    {
        // Create an admin with 100 notifications
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com'
        ]);

        for ($i = 0; $i < 100; $i++) {
            $member = Member::factory()->create();
            $admin->notify(new NewMemberRegistered($member));
        }

        // Measure query performance
        DB::enableQueryLog();
        $startTime = microtime(true);

        $response = $this->actingAs($admin)->getJson('/api/notifications/unread');

        $endTime = microtime(true);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();

        $executionTime = ($endTime - $startTime) * 1000;
        $queryCount = count($queries);

        // Should return only 10 notifications (limit)
        $response->assertStatus(200);
        $response->assertJsonCount(10);

        // Should use minimal queries (ideally 1-2)
        $this->assertLessThanOrEqual(5, $queryCount,
            "Fetching notification list should use minimal queries. Got {$queryCount} queries.");

        // Should be fast (< 100ms)
        $this->assertLessThan(100, $executionTime,
            "Fetching notification list should be fast. Took {$executionTime}ms.");

        echo "\n";
        echo "Notification List Performance:\n";
        echo "- Total notifications: 100\n";
        echo "- Returned: 10 (limit)\n";
        echo "- Queries: {$queryCount}\n";
        echo "- Execution time: " . number_format($executionTime, 2) . "ms\n";
    }

    /**
     * Test mark all as read performance
     * 
     * Verifies that marking all notifications as read is efficient
     * even with many notifications.
     */
    public function test_mark_all_as_read_performance(): void
    {
        // Create an admin with 200 unread notifications
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com'
        ]);

        for ($i = 0; $i < 200; $i++) {
            $member = Member::factory()->create();
            $admin->notify(new NewMemberRegistered($member));
        }

        // Measure query performance
        DB::enableQueryLog();
        $startTime = microtime(true);

        $response = $this->actingAs($admin)->postJson('/api/notifications/read-all');

        $endTime = microtime(true);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();

        $executionTime = ($endTime - $startTime) * 1000;
        $queryCount = count($queries);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'unread_count' => 0
        ]);

        // Should use a single UPDATE query (bulk update)
        $this->assertLessThanOrEqual(5, $queryCount,
            "Mark all as read should use minimal queries. Got {$queryCount} queries.");

        // Should be fast even with 200 notifications
        $this->assertLessThan(200, $executionTime,
            "Mark all as read should be fast. Took {$executionTime}ms.");

        // Verify all notifications are marked as read
        $unreadCount = $admin->unreadNotifications()->count();
        $this->assertEquals(0, $unreadCount);

        echo "\n";
        echo "Mark All as Read Performance:\n";
        echo "- Notifications marked: 200\n";
        echo "- Queries: {$queryCount}\n";
        echo "- Execution time: " . number_format($executionTime, 2) . "ms\n";
    }

    /**
     * Test database index effectiveness
     * 
     * Verifies that database indexes are being used for notification queries.
     */
    public function test_database_indexes_are_used(): void
    {
        // Create an admin with notifications
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com'
        ]);

        for ($i = 0; $i < 50; $i++) {
            $member = Member::factory()->create();
            $admin->notify(new NewMemberRegistered($member));
        }

        // Enable query log to inspect queries
        DB::enableQueryLog();

        // Execute typical notification queries
        $admin->unreadNotifications()->count();
        $admin->unreadNotifications()->orderBy('created_at', 'desc')->limit(10)->get();

        $queries = DB::getQueryLog();
        DB::disableQueryLog();

        // Verify queries are using WHERE clauses that match our indexes
        $hasIndexedQuery = false;
        foreach ($queries as $query) {
            $sql = strtolower($query['query']);
            
            // Check if query uses notifiable_id and read_at (our composite index)
            if (strpos($sql, 'notifiable_id') !== false && 
                strpos($sql, 'read_at') !== false) {
                $hasIndexedQuery = true;
                break;
            }
        }

        $this->assertTrue($hasIndexedQuery, 
            'Notification queries should use indexed columns (notifiable_id, read_at)');

        echo "\n";
        echo "Database Index Usage:\n";
        echo "- Queries executed: " . count($queries) . "\n";
        echo "- Using indexed columns: " . ($hasIndexedQuery ? 'Yes' : 'No') . "\n";
    }

    /**
     * Test concurrent polling simulation
     * 
     * Simulates realistic concurrent polling scenario where multiple
     * admins poll at different intervals.
     */
    public function test_concurrent_polling_simulation(): void
    {
        // Create 5 admins with varying notification counts
        $admins = collect();
        for ($i = 0; $i < 5; $i++) {
            $admin = User::factory()->create([
                'role' => 'admin',
                'email' => "admin{$i}@test.com"
            ]);
            
            // Create random number of notifications (10-100)
            $notificationCount = rand(10, 100);
            for ($j = 0; $j < $notificationCount; $j++) {
                $member = Member::factory()->create();
                $admin->notify(new NewMemberRegistered($member));
            }
            
            $admins->push($admin);
        }

        // Simulate 3 polling cycles (like 3 x 30-second intervals)
        $totalTime = 0;
        $totalQueries = 0;

        for ($cycle = 0; $cycle < 3; $cycle++) {
            DB::enableQueryLog();
            $startTime = microtime(true);

            // Each admin polls
            foreach ($admins as $admin) {
                $this->actingAs($admin)->getJson('/api/notifications/unread-count');
                
                // Randomly fetch full notification list (not every poll)
                if (rand(0, 1)) {
                    $this->actingAs($admin)->getJson('/api/notifications/unread');
                }
            }

            $endTime = microtime(true);
            $queries = DB::getQueryLog();
            DB::disableQueryLog();

            $cycleTime = ($endTime - $startTime) * 1000;
            $totalTime += $cycleTime;
            $totalQueries += count($queries);
        }

        // Performance assertions for realistic scenario
        $avgCycleTime = $totalTime / 3;
        $avgQueriesPerCycle = $totalQueries / 3;

        $this->assertLessThan(500, $avgCycleTime,
            "Average polling cycle should complete quickly. Took {$avgCycleTime}ms.");

        echo "\n";
        echo "Concurrent Polling Simulation:\n";
        echo "- Admins: 5\n";
        echo "- Polling cycles: 3\n";
        echo "- Total time: " . number_format($totalTime, 2) . "ms\n";
        echo "- Avg time per cycle: " . number_format($avgCycleTime, 2) . "ms\n";
        echo "- Total queries: {$totalQueries}\n";
        echo "- Avg queries per cycle: " . number_format($avgQueriesPerCycle, 1) . "\n";
    }
}
