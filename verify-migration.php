<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Phase 1 Migration Verification ===\n\n";

// Check events table structure
echo "1. Events Table Columns:\n";
$columns = DB::select("SHOW COLUMNS FROM events");
foreach ($columns as $column) {
    echo "   - {$column->Field} ({$column->Type})\n";
}

echo "\n2. Data Counts:\n";
echo "   - Total events: " . DB::table('events')->count() . "\n";
echo "   - Events (type='event'): " . DB::table('events')->where('type', 'event')->count() . "\n";
echo "   - Announcements (type='announcement'): " . DB::table('events')->where('type', 'announcement')->count() . "\n";

echo "\n3. Indexes on events table:\n";
$indexes = DB::select("SHOW INDEXES FROM events");
$indexNames = array_unique(array_column($indexes, 'Key_name'));
foreach ($indexNames as $indexName) {
    echo "   - {$indexName}\n";
}

echo "\n4. Foreign Keys on events table:\n";
$foreignKeys = DB::select("
    SELECT 
        CONSTRAINT_NAME,
        COLUMN_NAME,
        REFERENCED_TABLE_NAME,
        REFERENCED_COLUMN_NAME
    FROM information_schema.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'events'
    AND REFERENCED_TABLE_NAME IS NOT NULL
");
foreach ($foreignKeys as $fk) {
    echo "   - {$fk->CONSTRAINT_NAME}: {$fk->COLUMN_NAME} -> {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME}\n";
}

echo "\n5. Announcements table exists: " . (Schema::hasTable('announcements') ? 'YES ❌' : 'NO ✅') . "\n";

echo "\n=== Phase 1 Complete! ===\n";
