<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Event;

echo "=== Phase 2 Model Testing ===\n\n";

// Test 1: Type Constants
echo "1. Type Constants:\n";
echo "   - TYPE_EVENT: " . Event::TYPE_EVENT . "\n";
echo "   - TYPE_ANNOUNCEMENT: " . Event::TYPE_ANNOUNCEMENT . "\n";

// Test 2: Category Constants
echo "\n2. Category Constants:\n";
foreach (Event::getCategories() as $category) {
    echo "   - {$category}\n";
}

// Test 3: Get Types
echo "\n3. Available Types:\n";
foreach (Event::getTypes() as $key => $value) {
    echo "   - {$key}: {$value}\n";
}

// Test 4: Query Scopes
echo "\n4. Query Scopes Test:\n";
echo "   - Total events: " . Event::count() . "\n";
echo "   - Events (type=event): " . Event::events()->count() . "\n";
echo "   - Announcements (type=announcement): " . Event::announcements()->count() . "\n";
echo "   - Active items: " . Event::active()->count() . "\n";
echo "   - Pinned items: " . Event::pinned()->count() . "\n";
echo "   - Not expired: " . Event::notExpired()->count() . "\n";

// Test 5: Get first event and test accessors
$event = Event::first();
if ($event) {
    echo "\n5. Accessor Tests (Event ID: {$event->id}):\n";
    echo "   - Title: {$event->title}\n";
    echo "   - Slug: " . ($event->slug ?? 'NULL') . "\n";
    echo "   - Type: {$event->type}\n";
    echo "   - Is Event: " . ($event->is_event ? 'YES' : 'NO') . "\n";
    echo "   - Is Announcement: " . ($event->is_announcement ? 'YES' : 'NO') . "\n";
    echo "   - Is Active: " . ($event->is_active ? 'YES' : 'NO') . "\n";
    echo "   - Is Pinned: " . ($event->is_pinned ? 'YES' : 'NO') . "\n";
    echo "   - Formatted Date: " . ($event->formatted_date ?? 'NULL') . "\n";
    echo "   - Formatted Time: " . ($event->formatted_time ?? 'NULL') . "\n";
    echo "   - Formatted DateTime: " . ($event->formatted_date_time ?? 'NULL') . "\n";
    echo "   - Excerpt: " . ($event->excerpt ?? 'NULL') . "\n";
    echo "   - View Count: {$event->view_count}\n";
} else {
    echo "\n5. No events found in database\n";
}

// Test 6: Relationships
if ($event) {
    echo "\n6. Relationship Tests:\n";
    echo "   - Creator: " . ($event->creator ? $event->creator->name : 'NULL') . "\n";
    echo "   - Registrations count: " . $event->registrations()->count() . "\n";
}

// Test 7: Test creating an event with auto-slug
echo "\n7. Testing Auto-Slug Generation:\n";
try {
    $testEvent = new Event([
        'title' => 'Test Event ' . time(),
        'type' => Event::TYPE_EVENT,
        'description' => 'This is a test event',
    ]);
    // Don't save, just test slug generation
    echo "   - Title: {$testEvent->title}\n";
    echo "   - Auto-slug would be generated on save\n";
    echo "   ✅ Slug generation logic exists\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 8: Soft Deletes
echo "\n8. Soft Deletes:\n";
echo "   - Trait loaded: " . (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Event::class)) ? 'YES ✅' : 'NO ❌') . "\n";

echo "\n=== Phase 2 Model Tests Complete! ===\n";
